<?php
/*
Plugin Name: Browser Shots
Plugin URI: http://wordpress.org/#
Description: Easily take dynamic screenshots of a website
Author: Kevin Leary
Version: 1.0
Author URI: http://www.kevinleary.net
*/

if ( !class_exists('BrowserShots') ):

class BrowserShots 
{
	/**
	 * Setup the object
	 *
	 * Brief description of what it does
	 *
	 * @global
	 * @param $options An array of options for this object
	 * @return
	 * @staticvar
	 */
	function __construct( $options = array() ) 
	{
		add_shortcode( 'browser-shot', array( $this, 'shortcode' ) );
		add_action( 'init', array( $this, 'tinymce_button' ) );
	}
	
	
	/**
	 * [browser-shot] Shortcode
	 *
	 * Create a shortcode: [browser-shot url="http://link-to-website" width="600"]
	 */
	public function shortcode( $attributes, $content = '', $code = '' ) 
	{
		// Get attributes as parameters
		extract( shortcode_atts( array(
			'url' => '',
			'width' => 600,
			'alt' => ''
		), $attributes ) );
		
		// Sanitize
		$width = intval( $width );
		$url = esc_url( $url );
		$alt = ( empty($alt) ) ? $url : esc_attr($alt);
		
		// Get screenshot
		$image_uri = $this->get_shot( $url, $width );
	
		if ( !empty( $image_uri ) ) {
			$image = '<img src="' . $image_uri . '" alt="' . $alt . '" width="' . $width . '" class="alignnone" />';
			return '<div class="browser-shot"><a href="' . $url . '">' . $image . '</a></div>';
		}
		
		return '';
	}
	
	
	/**
	 * Get Browser Screenshot
	 *
	 * Get a screenshot of a website using WordPress
	 */
	public function get_shot( $url = '', $width = 250 ) {
		
		// Image found
		if ( $url != '' ) {
			return 'http://s.wordpress.com/mshots/v1/' . urlencode( $url ) . '?w=' . $width;
		} 
		
		// No image
		else {
			return '';
		}
	}
	
	
	/**
	 * Register TinyMCE Button
	 */
	public function register_button( $buttons ) {
		array_push( $buttons, "|", "browsershots" );
		
		return $buttons;
	}
	
	
	/**
	 * Register TinyMCE Plugin
	 */
	public function add_plugin( $plugin_array ) {
		$plugin_array['browsershots'] = plugins_url( 'js/browser-shots.js' , __FILE__ );
		
		return $plugin_array;
	}
	
	
	/**
	 * Create TinyMCE Button
	 */
	public function tinymce_button() {
	
		// Capabilities check
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
		
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array( $this, 'add_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_button' ) );
		}
	}
}

$BrowserShots = new BrowserShots();

endif; // class_exists
?>