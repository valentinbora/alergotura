<?php
/*
	Plugin Name: Better Feedburner Widget
	Plugin URI: http://bit51.com/software/better-feedburner-widget/
	Description: A customizable widget allowing you to place a Feedburner email subscribe form in any widgetized area of your site.
	Version: 1.2.1
	Text Domain: better-feedburner-widget
	Domain Path: /languages
	Author: Bit51.com
	Author URI: http://bit51.com
	License: GPLv2
	Copyright 2012  Bit51.com  (email : chris@bit51.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU tweaks Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU tweaks Public License for more details.

	You should have received a copy of the GNU tweaks Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class BFW extends WP_Widget {

	function BFW() {
		$widget_ops = array('classname' => 'BFW', 'description' => __('Subscribe via email to your Feedburner feed.','better-feedburner-widget'));
		$this->WP_Widget('BFW', 'Better Feedburner Widget', $widget_ops);
	}

	function form($instance) {
		
		$instance = wp_parse_args((array) $instance, array(
			'title' => '',
			'feed' => '',
			'email_label' => '',
			'after_form' => '',
			'button_text' => '',
			'show_counter' => '',
			'counter_bg' => '',
			'counter_fg' => '',
		));
        
		$title = esc_attr($instance['title']);
		$feed = esc_attr($instance['feed']);
		$email_label = esc_attr($instance['email_label']);
		$after_form = esc_attr($instance['after_form']);
		$button_text = empty($instance['button_text']) ? 'Subscribe' : esc_attr($instance['button_text']);
		$show_counter = esc_attr($instance['show_counter']);
		$counter_bg = empty($instance['counter_bg']) ? '99ccff' : $instance['counter_bg'];
		$counter_fg = empty($instance['counter_fg']) ? '444444' : $instance['counter_fg'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Widget Title:','better-feedburner-widget'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('feed'); ?>"><strong><?php _e('Feedburner feed User:','better-feedburner-widget'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>" type="text" value="<?php echo $feed; ?>" /></label><br />
		<small><em>(http://feeds.feedburner.com/USER)</em></small></p>
		<p><label for="<?php echo $this->get_field_id('email_label'); ?>"><strong><?php _e('Label for email box:','better-feedburner-widget'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('email_label'); ?>" name="<?php echo $this->get_field_name('email_label'); ?>" type="text" value="<?php echo $email_label; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('button_text'); ?>"><strong><?php _e('Submit button text:','better-feedburner-widget'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('show_counter'); ?>"><strong><?php _e('Show Feed stats:','better-feedburner-widget'); ?> </strong><input class="widefat" id="<?php echo $this->get_field_id('show_counter'); ?>" name="<?php echo $this->get_field_name('show_counter'); ?>" type="checkbox"<?php echo (($show_counter) ? ' checked' : ''); ?> /></label></p>   
		<p><label for="<?php echo $this->get_field_id('counter_bg'); ?>"><strong><?php _e('Counter Background Color:','better-feedburner-widget'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('counter_bg'); ?>" name="<?php echo $this->get_field_name('counter_bg'); ?>" type="text" value="<?php echo $counter_bg; ?>" maxlength = "6"  /></label></p>		
		<p><label for="<?php echo $this->get_field_id('counter_fg'); ?>"><strong><?php _e('Counter Foreground Color:','better-feedburner-widget'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('counter_fg'); ?>" name="<?php echo $this->get_field_name('counter_fg'); ?>" type="text" value="<?php echo $counter_fg; ?>" maxlength = "6" /></label></p>		
		<p><label for="<?php echo $this->get_field_id('after_form'); ?>"><strong><?php _e('Text for after form:','better-feedburner-widget'); ?></strong> <textarea class="widefat" id="<?php echo $this->get_field_id('after_form'); ?>" name="<?php echo $this->get_field_name('after_form'); ?>" rows="10"><?php echo $after_form; ?></textarea></label></p>
		<div style="text-align: center; width: 100%;">If you find this software useful please consider a small gift. All donations are help with costs related to the continued development of this software.
			<iframe frameborder="0" scrolling="no" width="100%" src="<?php echo trailingslashit(WP_PLUGIN_URL) . 'better-feedburner-widget/' ?>donate.php"></iframe>
		</div>
		
<?php
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	 function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$html = $before_widget;
        
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$feed = empty($instance['feed']) ? false : $instance['feed'];
		$email_label = empty($instance['email_label']) ? false : $instance['email_label'];
		$after_form = empty($instance['after_form']) ? false : $instance['after_form'];
		$button_text = empty($instance['button_text']) ? 'Subscribe' : $instance['button_text'];
		$show_counter = (isset($instance['show_counter']) && $instance['show_counter']) ? true : false;
		$counter_bg = empty($instance['counter_bg']) ? '99ccff' : $instance['counter_bg'];
		$counter_fg = empty($instance['counter_fg']) ? '444444' : $instance['counter_fg'];
       
		$user = str_replace('http://feeds.feedburner.com/', '', $feed);
           
		if (!empty($title)) {
			$html .= $before_title . trim($title) . $after_title;
		}

		$html .= '<form id="BFW" action="http://feedburner.google.com/fb/a/mailverify" method="post" onsubmit="window.open(\'http://feedburner.google.com/fb/a/mailverify?uri=' . $user . '\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\')" target="popupwindow">';
		
		if (strlen($email_label) > 0) {
			$html .= '<label for="BFW_email" id="BFW_above">' . trim($email_label) . '</label>';
		}
		
		$html .= '<input id="BFW_email" type="text" name="email" />';
		$html .= '<input type="hidden" value="' . $user . '" name="uri"/>';
		$html .= '<input type="hidden" name="loc" value="en_US"/>';
            
		$html .= '<input id="BFW_submit" type="submit" value="' . trim($button_text) . '" />';

		if ($show_counter) {
			$html .= "<div id=\"BFW_stats\"><a href=\"http://feeds.feedburner.com/" . $user . "\"><img src=\"http://feeds.feedburner.com/~fc/" . $user . "?bg=" . $counter_bg . "&amp;fg=" . $counter_fg . "&amp;anim=0\" height=\"26\" width=\"88\" style=\"border:0\" alt=\"Feedburner Subscriber Count\" /></a></div>\n";
		}
				
		$html .= '</form>';
		
		if (strlen($after_form) > 0) {
			$html .= '<div id="BFW_afterform">' . trim($after_form) . '</div>';
		}
		
        $html .= $after_widget;
        
        echo($html);
    }

}

/**
  * Load the widget
  * @return Null
  **/
function BFW_load_widget() {
	register_widget( 'BFW' );
}

//register the widget
add_action( 'widgets_init', 'BFW_load_widget' );

/**
  * activate translations
  * @return null
  */
function BFW_languages() {
	if ( function_exists('load_plugin_textdomain') ) {
		if ( !defined('WP_PLUGIN_DIR') ) {
			load_plugin_textdomain('better-feedburner-widget', str_replace( ABSPATH, '', dirname(__FILE__) ) . '/languages');
		} else {
			load_plugin_textdomain('better-feedburner-widget', false, dirname( plugin_basename(__FILE__) ) . '/languages');
		}
	}
}

//load languages
add_action('init', 'BFW_languages');