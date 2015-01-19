<?php
/*
Plugin Name: Browser Shots
Plugin URI: https://wordpress.org/plugins/browser-shots/
Description: Easily take dynamic screenshots of a website inside of WordPress
Author: Kevin Leary
Version: 1.3.1
Author URI: http://prothemedesign.com
*/


if ( !class_exists( 'BrowserShots' ) ) {

class BrowserShots {

	/**
	 * Setup the object
	 *
	 * Brief description of what it does
	 *
	 * @global
	 * @param unknown $options An array of options for this object
	 * @return
	 * @staticvar
	 */
	function __construct( $options = array() ) {
		add_shortcode( 'browser-shot', array( $this, 'shortcode' ) );
		add_action( 'init', array( $this, 'tinymce_button' ) );
	}


	/**
	 * [browser-shot] Shortcode
	 *
	 * Create a shortcode: [browser-shot url="http://link-to-website" width="600"]
	 */
	public function shortcode( $attributes, $content = '', $code = '' ) {

		// Get attributes as parameters
		extract( shortcode_atts( array(
			'url' => '',
			'width' => 600,
			'height' => 450,
			'alt' => '',
			'link' => '',
			'target' => '',
		), $attributes ) );

		// Sanitize
		$width = intval( $width );
		$height = intval( $height );
		$url = esc_url( $url );
		$link = esc_url( $link );
		$alt = ( empty( $alt ) ) ? $url : esc_attr( $alt );
		$target = esc_attr( $target );
		$caption = esc_html( $content );

		if ( empty( $link ) ) {
			$link = $url;
		}

		if ( $target ) {
			$target = ' target="' . $target . '"';
		}

		// Get screenshot
		$image_uri = $this->get_shot( $url, $width, $height );

		if ( !empty( $image_uri ) ) {

			ob_start();

			if ( $caption ) {
				echo '<div class="wp-caption" style="width:' . ($width + 10) . 'px;">';
			}
?>
	<div class="browser-shot">
		<a href="<?php echo $link; ?>" <?php echo $target; ?>>
			<img src="<?php echo $image_uri; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="alignnone" />
		</a>
	</div>
<?php

			if ( $caption ) {
				echo '<p class="wp-caption-text">' . $caption . '</p>';
				echo '</div>';
			}
			return ob_get_clean();
		}

		return '';
	}


	/**
	 * Get Browser Screenshot
	 *
	 * Get a screenshot of a website using WordPress
	 */
	public function get_shot( $url = '', $width = 600, $height = 450 ) {

		// Image found
		if ( $url != '' ) {
			return 'http://s.wordpress.com/mshots/v1/' . urlencode( $url ) . '?w=' . $width . '&h=' . $height;
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
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
			return;

		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array( $this, 'add_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_button' ) );
		}
	}
}

new BrowserShots();

} // class_exists
