<?php

function load_css() {
  // CSS Plugins
  wp_register_style('vendor', get_template_directory_uri() . '/assets/css/vendor.css', array(), '0.1', 'all');
  wp_enqueue_style('vendor');

  // Main CSS
  wp_register_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), '0.1', 'all');
  wp_enqueue_style('main');
}

add_action('wp_enqueue_scripts', 'load_css');

function load_js() {
  // JQuery
  wp_enqueue_script('jquery');

  // JS Plugins
  wp_register_script('vendor', get_template_directory_uri() .'/assets/js/vendor.js', 'jquery', '0.1', true);
  wp_enqueue_script('vendor');

  // Main JS
  wp_register_script('main', get_template_directory_uri() .'/assets/js/main.js', 'jquery', '0.1', true);
  wp_enqueue_script('main');
}

add_action('wp_enqueue_scripts', 'load_js');

//add_action('user_register', 'dctit_add_cp_based_on_level',999);
add_action( 'pmpro_after_checkout', 'dctit_add_cp_based_on_level');
//add_action( 'pmpro_after_change_membership_level', 'dctit_add_cp_based_on_level');

function dctit_add_cp_based_on_level($user_id)
{
    if(function_exists('pmpro_hasMembershipLevel') && pmpro_hasMembershipLevel())
    {
        //var_dump($user_id);
        $level = pmpro_getMembershipLevelForUser($user_id);
        //var_dump($level);
        $l_name = strtolower($level->name);
        $l_id = $level->id;
        $l_key = str_replace(' ', '_', $l_name) . $l_id;
        $level_cp = get_option($l_key);
        update_user_meta($user_id, 'user_cp_dct', $level_cp);
    }
    
}

