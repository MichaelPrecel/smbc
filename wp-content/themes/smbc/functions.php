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