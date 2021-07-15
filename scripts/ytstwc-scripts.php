<?php

function ytstwc_add_scripts() {
    //On ajoute le fichier css
    wp_enqueue_style('ytstwc-main-style', plugins_url(). '/youtubeTwitchPlayer/css/style.css');
    //On ajoute le fichier js
    wp_enqueue_script('ytstwc-main-script', plugins_url(). '/youtubeTwitchPlayer/js/main.js');
    //On ajoute un script Google
    wp_register_script('google', 'https://apis.google.com/js/platform.js');
    wp_enqueue_script('google');
}

add_action('wp_enqueue_scripts', 'ytstwc_add_scripts');