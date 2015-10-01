<?php
/*
	Plugin Name: Browser Shots
	Plugin URI: https://wordpress.org/plugins/browser-shots/
	Description: Easily take dynamic screenshots of a website inside of WordPress
	Author: Kevin Leary
	Version: 1.5
	Author URI: http://prothemedesign.com
	Text Domain: browser-shots
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
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
	 *
	 * @param type $attributes
	 * @param type $content
	 * @param type $code
	 * @return string
	 */
	public function shortcode( $attributes, $content = '', $code = '' ) {

		// Get attributes as parameters
		extract(
			shortcode_atts(
				array(
					'url' => '',
					'width' => 600,
					'height' => 450,
					'alt' => '',
					'link' => '',
					'target' => '',
				),
				$attributes
			)
		);

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
				echo '<div class="wp-caption" style="width:' . ( $width + 10 ) . 'px;">';
			}
?>
	<div class="browser-shot">
		<a href="<?php echo $link; ?>" <?php echo $target; ?>>
			<img src="<?php echo esc_url( $image_uri ); ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="alignnone" />
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
	 *
	 * @param type $url
	 * @param type $width
	 * @param type $height
	 * @return string
	 */
	public function get_shot( $url = '', $width = 600, $height = 450 ) {

		// Image found
		if ( '' != $url ) {

			$query_args = array(
				'w' => intval( $width ),
				'h' => intval( $height ),
			);

			return add_query_arg( $query_args, 'https://s0.wordpress.com/mshots/v1/' . urlencode( $url ) );

		} else {

			// No image
			return '';

		}

	}


	/**
	 * Register TinyMCE Button
	 *
	 * @param type $buttons
	 * @return type
	 */
	public function register_button( $buttons ) {

		array_push( $buttons, '|', 'browsershots' );

		return $buttons;

	}


	/**
	 * Register TinyMCE Plugin
	 *
	 * @param array $plugins
	 * @return type
	 */
	public function add_plugin( $plugins ) {

		$plugins[ 'browsershots' ] = plugins_url( 'js/browser-shots.js' , __FILE__ );

		return $plugins;

	}


	/**
	 * Add translations to TinyMCE button
	 *
	 * @param array $locales
	 * @return string
	 */
	public function button_locale( $locales ) {

		$locales[ 'browsershots' ] = plugin_dir_path ( __FILE__ ) . 'locale.php';

		return $locales;

	}


	/**
	 * Create TinyMCE Button
	 */
	public function tinymce_button() {

		// Capabilities check
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {

			return;

		}

		if ( get_user_option( 'rich_editing' ) == 'true' ) {

			add_filter( 'mce_external_plugins', array( $this, 'add_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_button' ) );
			add_filter( 'mce_external_languages', array( $this, 'button_locale' ) );

		}

	}

}

new BrowserShots();

} // class_exists
