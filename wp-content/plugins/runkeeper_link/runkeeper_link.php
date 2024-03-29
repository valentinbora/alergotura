<?php
/*
Plugin Name: RunKeeper API - Backend Link
Author: Alergotura.ro GeekMeet Team
Version: 1.0
*/

define('RUNKEEPER_ACCESS_TOKEN', '4d5d016ed8e941c88623cf38910d88f5');

register_activation_hook(__FILE__, 'runkeeper_link_install');

function runkeeper_link_install() {
  global $wpdb;

  $table_name = $wpdb->prefix . "running_geopoints";
  
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    name tinytext NOT NULL,
    text text NOT NULL,
    url VARCHAR(55) DEFAULT '' NOT NULL,
    UNIQUE KEY id (id)
  );";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}

define('YAMLPATH', ABSPATH . '/wp-content/plugins/runkeeper_link/lib/yaml/');
define('RUNKEEPERAPIPATH', ABSPATH . '/wp-content/plugins/runkeeper_link/lib/');
define('CONFIGPATH', ABSPATH . '/wp-content/plugins/runkeeper_link/config/');

require(YAMLPATH . 'lib/sfYamlParser.php');
require(RUNKEEPERAPIPATH . 'runkeeperAPI.class.php');

function runkeeper_link_connect_get_api_object() {
  $rkAPI = new runkeeperAPI(
    CONFIGPATH . 'api.yml'
  );
  
  if ($rkAPI->api_created == false) {
  	echo 'error ' . $rkAPI->api_last_error; /* api creation problem */
  	exit();
  }
  
  return $rkAPI;
}

function runkeeper_link_connect_api_oauth_process() {
  $rkAPI = runkeeper_link_connect_get_api_object();
  
  /* Generate link to allow user to connect to Runkeeper and to allow your app*/
  $linkUrl = $rkAPI->connectRunkeeperButtonUrl();
  
  /* After connecting to Runkeeper and allowing your app, user is redirected to redirect_uri param (as specified in YAML config file) with $_GET parameter "code" */
  if ($_GET['code']) {
  	$auth_code = $_GET['code'];
  	if ($rkAPI->getRunkeeperToken($auth_code) == false) {
  		echo $rkAPI->api_last_error; /* get access token problem */
  		exit();
  } else {
  		/* Your code to store $rkAPI->access_token (client-side, server-side or session-side) */
  		/* Note: $rkAPI->access_token will have to be set et valid for following operations */

  		/* Do a "Read" request on "Profile" interface => return all fields available for this Interface */
  		$rkProfile = $rkAPI->doRunkeeperRequest('Profile','Read');
  		print_r($rkProfile);
  		die();

  		/* Do a "Read" request on "Settings" interface => return all fields available for this Interface */
  		$rkSettings = $rkAPI->doRunkeeperRequest('Settings','Read');
  		print_r($rkSettings);

  		/* Do a "Read" request on "FitnessActivities" interface => return all fields available for this Interface or false if request fails */
  		$rkActivities = $rkAPI->doRunkeeperRequest('FitnessActivities','Read');
  		if ($rkActivities) {
  			print_r($rkActivities);
  		}
  		else {
  			echo $rkAPI->api_last_error;
  			print_r($rkAPI->request_log);
  		}

  		/* Do a "Read" request on "FitnessActivityFeed" interface => return all fields available for this Interface or false if request fails */
  		$rkActivities = $rkAPI->doRunkeeperRequest('FitnessActivityFeed','Read');
  		if ($rkUpdateActivity) {
  			print_r($rkUpdateActivity);
  		}
  		else {
  			echo $rkAPI->api_last_error;
  			print_r($rkAPI->request_log);
  		}

  		/* Do a "Create" request on "FitnessActivity" interface with fields => return created FitnessActivity content if request success, false if not */
  		$fields = json_decode('{"type": "Running", "equipment": "None", "start_time": "Sat, 1 Jan 2011 00:00:00", "notes": "My first late-night run", "path": [{"timestamp":0, "altitude":0, "longitude":-70.95182336425782, "latitude":42.312620297384676, "type":"start"}, {"timestamp":8, "altitude":0, "longitude":-70.95255292510987, "latitude":42.31230294498018, "type":"end"}], "post_to_facebook": true, "post_to_twitter": true}');
  		$rkCreateActivity = $rkAPI->doRunkeeperRequest('NewFitnessActivity','Create',$fields);
  		if ($rkCreateActivity) {
  			print_r($rkCreateActivity);
  		}
  		else {
  			echo $rkAPI->api_last_error;
  			print_r($rkAPI->request_log);
  		}
  	}
  }
}

function runkeeper_link_update_local_records() {
  $rkAPI = runkeeper_link_connect_get_api_object();
  
  $rkAPI->setRunkeeperToken(RUNKEEPER_ACCESS_TOKEN);
  
  $rkActivities = $rkAPI->doRunkeeperRequest('FitnessActivityFeed', 'Read');
  
	if ($rkActivities) {
	  if (isset($rkActivities->items) && count($rkActivities->items)) {
	    $totalDistance = 0.00;
	    
	    /**
	     * Compute total distance, store it to options
	     */
	    foreach ($rkActivities->items as $activity) {
	      $totalDistance += floatval($activity->total_distance) / 1000;
	    }
	    
	    update_option('runkeeper_total_distance', $totalDistance);
	    
	    /**
	     * Retrieve last point
	     */
  	  $latestActivity = $rkActivities->items[0];
  	  $latestActivity = $rkAPI->doRunkeeperRequest('FitnessActivity', 'Read', null, $latestActivity->uri);

  	  if ($latestActivity) {
  	    $points = array();
  	    
  	    foreach ($latestActivity->path as $pathPoint) {
  	      $points[] = array($pathPoint->latitude, $pathPoint->longitude);
  	    }
  	    
    		$last_path_point = end($latestActivity->path);
    		update_option('runkeeper_last_point_lat', $last_path_point->latitude);
    		update_option('runkeeper_last_point_long', $last_path_point->longitude);
    		update_option('runkeeper_last_activity_path', json_encode($points));
  		} else {
  		  echo $rkAPI->api_last_error;
    		print_r($rkAPI->request_log);
  		}
		}
	} else {
		echo $rkAPI->api_last_error;
		print_r($rkAPI->request_log);
	}
}

function runkeeper_force_update_page () {
  return print_r(runkeeper_link_update_local_records(), true);
  
  return '';
}

function runkeeper_link_cron_interval($array) {
  $period = 20;
  
  $array['everytwentyseconds'] = array(
    'interval' => $period,
    'display' => 'Every 20 seconds'
  );
  
  return $array;
}

function runkeeper_link_login_button($atts) {
  runkeeper_link_connect_api_oauth_process();

  return '';
}

function runkeeper_link_uninstall() {
  wp_clear_scheduled_hook('runkeeper_link_update_local_records');
}

add_filter('cron_schedules', 'runkeeper_link_cron_interval');
add_shortcode('runkeeper_login', 'runkeeper_link_login_button');
add_shortcode('runkeeper_force_update', 'runkeeper_force_update_page');

if (!wp_next_scheduled('runkeeper_link_update_local_records')) {
  wp_schedule_event(time(), 'everytwentyseconds', 'runkeeper_link_update_local_records');
}

register_deactivation_hook(__FILE__, 'runkeeper_link_uninstall');

add_action('wp_ajax_nopriv_runkeeper_get_update', 'runkeeper_link_get_update');
add_action('wp_ajax_runkeeper_get_update', 'runkeeper_link_get_update');
add_action('runkeeper_link_update_local_records', 'runkeeper_link_update_local_records');

function runkeeper_link_get_update() {
  $path = json_decode(get_option('runkeeper_last_activity_path', '[]'));

  header("Content-Type: application/json");
  
  echo json_encode(array(
    'pos' => $_SESSION['pos'],
    'runkeeper_last_point_lat' => get_option('runkeeper_last_point_lat', 45),
    'runkeeper_last_point_long' => get_option('runkeeper_last_point_long', 45),
    'runkeeper_total_distance' => get_option('runkeeper_total_distance', 0),
    'runkeeper_last_activity_path' => json_encode($path),
  ));

	die();
}

function ddd($what) {
  echo '<pre>';
  print_r($what);
  die();
}