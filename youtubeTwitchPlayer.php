<?php

/**
 * Plugin Name: Youtube Twitch Player
 * Plugin URI: http://www.mywebsite.com/youtube-twitch-player
 * Description: Plugin to add Youtube Videos and Twiych streams onto your pages
 * Version: 1.0
 * Author: Groupe Thomas Yanis Jérémy
 * Author URI: http://www.mywebsite.com
 */

// On redirige si on accède directement au fichier
if (!defined('ABSPATH')) {
    exit;
}

// On charge les scripts
require_once(plugin_dir_path(__FILE__).'scripts/ytstwc-scripts.php');

// On charge la classe Youtube_Widget
require_once(plugin_dir_path(__FILE__).'widgets/Youtube_Widget.php');

// On charge la classe Subscribe_Youtube_Widget
require_once(plugin_dir_path(__FILE__).'widgets/subscribe_youtube_widget.php');

// On enregistre le widget Youtube
function register_youtube_widget() {
    register_widget('Youtube_Widget');
}
add_action('widgets_init', 'register_youtube_widget');

// Register and load the widget
function yts_load_widget() {
    register_widget( 'Subscribe_Youtube_Widget' );
}
add_action( 'widgets_init', 'yts_load_widget' );


