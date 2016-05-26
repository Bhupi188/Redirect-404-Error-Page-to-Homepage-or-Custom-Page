<?php
/*
Plugin Name: Redirect 404 Error Page to Homepage or Custom Page
Plugin URI: https://plugins.svn.wordpress.org/wp-reset/trunk/WP-Reset/
Description: Easily redirect 404 error page to homepage or Custom page URL.
Version: 1.0
Author: Bhupender Singh
Author URI: https://github.com/Bhupi188/
Text Domain: redirect-404-error-page-to-homepage-or-custom-page
License: GPL v3
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Redirect 404 Error Page to Homepage or Custom Page
Copyright (C) 2016 Bhupender Singh - bhupndersingh@gmail.com

@package WP_Store_finder
@category Core
@author Bhupender Singh
*/

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed this file directly
} 

if ( is_admin() ) {
	
	/**
	 * Class for adding a new field to the options-general.php page
	 */
	class Add_Settings_Field {

		/**
		 * Class constructor
		 */
		public function __construct() {
			add_action( 'admin_init' , array( &$this , 'register_fields' ) );
		}

		/**
		 * Add new fields to wp-admin/options-general.php page
		 */
		public function register_fields() {
			register_setting( 'general', 'redirect_404_to_homepage_or_custom_page', 'esc_attr' );
			add_settings_field(
				'fav_color',
				'<label for="redirect_404_to_homepage_or_custom_page">' . __( 'Redirect 404 to Custom Page' , 'redirect_404_to_homepage_or_custom_page' ) . '</label>',
				array( &$this, 'fields_html' ),
				'general'
			);
		}

		/**
		 * HTML for extra settings
		 */
		public function fields_html() {
			$value = get_option( 'redirect_404_to_homepage_or_custom_page', '' );
			echo '<input type="text" id="redirect_404_to_homepage_or_custom_page" name="redirect_404_to_homepage_or_custom_page" class="regular-text code" value="' . esc_attr( $value ) . '" />
			<p class="description" id="admin-redirect-404-error-page-to-homepage-or-custom-page-description">Enter page slug in this field(eg. http://xyz.com/about-us "about-us" is slug in this url).<br/>Default 404 page redirect to home page.</p>';
		}

	}
	new Add_Settings_Field();
}


function redirect_404_to_homepage_or_custom_page() {
  	
	if (is_404()) {
		$redirect_slug= get_option( 'redirect_404_to_homepage_or_custom_page' );
		if ($redirect_slug){
			wp_redirect(home_url($redirect_slug),301);
		}else{
			wp_redirect(home_url(),301);
		}
		
		die();
	}
}

add_action('wp', 'redirect_404_to_homepage_or_custom_page', 1);
?>