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

// On charge la classe Twitch_Widget
require_once(plugin_dir_path(__FILE__).'widgets/Twitch_Widget.php');

// On charge la classe Twitch_Widget
require_once(plugin_dir_path(__FILE__).'widgets/Twitch_Video_Widget.php');

// On charge la classe Twitch_Widget
require_once(plugin_dir_path(__FILE__).'widgets/Twitch_Chat_Widget.php');

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

// On enregistre le widget Twitch
function register_twitch_widget() {
    register_widget('Twitch_Widget');
}
add_action('widgets_init', 'register_twitch_widget');

// On enregistre le widget Twitch
function register_twitch_video_widget() {
    register_widget('Twitch_Video_Widget');
}
add_action('widgets_init', 'register_twitch_video_widget');

// On enregistre le widget Twitch
function register_twitch_chat_widget() {
    register_widget('Twitch_Chat_Widget');
}
add_action('widgets_init', 'register_twitch_chat_widget');

function yts_sub_btn_all($atts) {
    return '<div class="g-ytsubscribe" data-channel="'. $atts['channel'] .'" data-layout="full" data-count="default"></div>';
}

function yts_sub_btn_no_count($atts) {
    return '<div class="g-ytsubscribe" data-channel="'. $atts['channel'] .'" data-layout="full" data-count="hidden"></div>';
}

function yts_sub_btn_no_layout($atts) {
    return '<div class="g-ytsubscribe" data-channel="'. $atts['channel'] .'" data-layout="default" data-count="default"></div>';
}

function yts_sub_btn_none($atts) {
    return '<div class="g-ytsubscribe" data-channel="'. $atts['channel'] .'" data-layout="default" data-count="hidden"></div>';
}

function yts_video_short($atts) {
    return '<iframe width="500" height="300" src="https://www.youtube.com/embed/'. $atts['video'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen></iframe>';
}

function add_shortcodes_yts() {
    add_shortcode('SubscribeAll', 'yts_sub_btn_all');
    add_shortcode('SubscribeNoCount', 'yts_sub_btn_no_count');
    add_shortcode('SubscribeNoLayout', 'yts_sub_btn_no_layout');
    add_shortcode('SubscribeNone', 'yts_sub_btn_none');
    add_shortcode('YoutubeVideo', 'yts_video_short');
}
add_action('widgets_init', 'add_shortcodes_yts');

function twc_live_short($atts) {
    return '<iframe src="https://player.twitch.tv/?channel='. $atts['channel'] .'&parent='
        . $atts['parent'] .'" allowfullscreen="true" scrolling="yes" height="300" width="500"></iframe>';
}

function twc_video_short($atts) {
    return '<iframe src="https://player.twitch.tv/?video='.$atts['video'].'&parent='
        . $atts['parent'] .'" height="300" width="500" allowfullscreen="true"></iframe>';
}

function twc_chat_short($atts) {
    return '<iframe src="https://www.twitch.tv/embed/'. $atts['channel'] .'/chat?parent='. $atts['parent'] .'" height="500" width="300"></iframe>';
}

function add_shortcodes_twc() {
    add_shortcode('TwitchLive', 'twc_live_short');
    add_shortcode('TwitchVideo', 'twc_video_short');
    add_shortcode('TwitchChat', 'twc_chat_short');
}
add_action('widgets_init', 'add_shortcodes_twc');