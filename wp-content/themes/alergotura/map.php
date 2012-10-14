<?php
/**
 * Template Name: Google Maps Template
 * Description: A Page Template that lets us created a dedicated Google Maps page
 *
 * @package WordPress
 * @subpackage Alergotura
 * @since Twenty Eleven 1.0
 */
get_header();
?>

<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.8.0.js"></script>  
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.22/jquery-ui.js"></script>  
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="<?php bloginfo('stylesheet_directory') ?>/js/relay-map.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/relay.css" />

<div id="primary">  
  <div id="content" role="main">  
    <div class="run-metrics">
      <div class="progress-box">
        <div>
          <div class="progress center" style="width: 0%"><span>0%</span></div>
        </div>
      </div>
      
      <table class="metric-boxes" cellspacing="10">
        <tr>
          <td class="metric-box">
            <span class="metric-figure" id="metric-progres">0%</span>
            <div class="metric-description">Progres</div>
          </td>
        
          <td class="metric-box">
            <span class="metric-figure" id="metric-run-distance">0</span>
            <div class="metric-description">Distanta parcursa</div>
          </td>
        
          <td class="metric-box">
            <span class="metric-figure" id="metric-remaining-distance">3000</span>
            <div class="metric-description">Distanta ramasa</div>
          </td>
        
          <td class="metric-box">
            <span class="metric-figure" id="metric-days-remaining">23</span>
            <div class="metric-description">Zile ramase</div>
          </td>
        </tr>
      </table>
    </div>
    
    <div class="maps_content">           
        <div id="map_canvas"></div>
    </div><!-- #content -->
  </div><!-- #primary -->  

<?php get_footer(); ?>  