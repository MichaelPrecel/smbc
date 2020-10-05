<?php

/**
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       DCTIT Advance Custom Feature
 * Plugin URI:        https//www.dctit.host/archive/plugin/dctit-advance-custom-feature
 * Description:       Custom Feature for SMBC.
 * Version:           1.0.0
 * Author:            Adil Mahmud Choudhury, Tahmid
 * Author URI:        http://dctit.host/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dctit-acf
 * Domain Path:       /languages
 */

// don't load directly
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_DACF_VERSION', '1.0.0' );


define( 'PLUGIN_MAIN_DIR', plugin_dir_path( __FILE__ ) );
include( PLUGIN_MAIN_DIR . 'includes/community-offers.php');
include( PLUGIN_MAIN_DIR . 'includes/com-offers-functions.php');
include( PLUGIN_MAIN_DIR . 'includes/send-request-log.php');
include( PLUGIN_MAIN_DIR . 'includes/send-request-functions.php');
include( PLUGIN_MAIN_DIR . 'includes/connection-point.php');
include( PLUGIN_MAIN_DIR . 'includes/cp-functions.php');

add_action( 'init', 'dctit_script_enqueuer' );

function dctit_script_enqueuer() {
   wp_register_script( "dctit_main", WP_PLUGIN_URL.'/dctit-advance-custom-feature/public/js/main.js', array('jquery') );
   wp_localize_script( 'dctit_main', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'dctit_main' );

}