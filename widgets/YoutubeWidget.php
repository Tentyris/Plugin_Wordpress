<?php

class YoutubeWidget extends WP_Widget{
    public function __construct()
    {
        parent::__construct('youtube_widget', 'Youtube Widget');
    }

    public function widget ($args, $instance){
        echo $args['before_widget'];
        if(isset($instance['title'])){
            $title = apply_filters('widget_title', $instance['title']);
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        echo '<iframe width="'. esc_attr($width) .'" height="' . $height . '" src="https://www.youtube.com/embed/'. esc_attr($youtube) . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        echo $args['after_widget'];

    }

    public function form($instance){
        $title = isset($instance['title']) ? $instance['title'] : '';
        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        ?>
            <p>
            <label for="<?= $this->get_field_id('title') ?>">Titre</label>
            <input 
                class="widefat" 
                type="text" 
                name="<?= $this->get_field_name('title') ?>"
                value="<?= esc_attr($title) ?>"
                id="<?= $this->get_field_name('title') ?>">
            </p>
            <p>
            <label for="<?= $this->get_field_id('youtube') ?>">Id Youtube</label>
            <input 
                class="widefat" 
                type="text" 
                name="<?= $this->get_field_name('youtube') ?>"
                value="<?= esc_attr($youtube) ?>"
                id="<?= $this->get_field_name('youtube') ?>">
            </p>
            <p>
            <label for="<?= $this->get_field_id('width') ?>">Largeur</label>
            <input 
                class="widefat" 
                type="text" 
                name="<?= $this->get_field_name('width') ?>"
                value="<?= esc_attr($width) ?>"
                id="<?= $this->get_field_name('width') ?>">
            </p>
            <p>
            <label for="<?= $this->get_field_id('height') ?>">Hauteur</label>
            <input 
                class="widefat" 
                type="text" 
                name="<?= $this->get_field_name('height') ?>"
                value="<?= esc_attr($height) ?>"
                id="<?= $this->get_field_name('height') ?>">
            </p>
        <?php
    }

    public function update($newInstance, $oldInstance)
    {
        return $newInstance;
    }
}