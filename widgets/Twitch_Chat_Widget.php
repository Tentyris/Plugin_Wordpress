<?php

class Twitch_Chat_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'twitch_chat_widget',
            __('Twitch Chat Widget', 'twitch_domain'),
            array( 'description' => __( 'Widget d\'intégration de chat Twitch', 'twitch_domain' ), )
        );
    }

    public function widget( $args, $instance ) {

        echo $args['before_widget'];
        if(!empty($instance['title'])){
            $title = apply_filters('widget_title', $instance['title']);
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $channel = isset($instance['channel']) ? $instance['channel'] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        $parent = isset($instance['parent']) ? $instance['parent'] : '';

        echo '<iframe src="https://www.twitch.tv/embed/'. $channel .'/chat?parent='. $parent .'" height="'. $height .'" width="'. $width .'"></iframe>';

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = isset($instance[ 'title' ]) ? $instance[ 'title' ] : '';
        $channel = isset($instance[ 'channel' ]) ? $instance[ 'channel' ] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        $parent = isset($instance['parent']) ? $instance['parent'] : '';
        ?>
        <p>
            <label for="<?= $this->get_field_id('title') ?>">
                <?php esc_attr_e('Titre : ', 'ytstwc_domain'); ?>
            </label>
            <input
                class="widefat"
                type="text"
                name="<?= $this->get_field_name('title') ?>"
                value="<?= esc_attr($title) ?>"
                id="<?= $this->get_field_name('title') ?>">
        </p>
        <p>
            <label for="<?= $this->get_field_id('channel') ?>">
                <?php esc_attr_e('Chaîne : ', 'ytstwc_domain'); ?>
            </label>
            <input
                class="widefat"
                type="text"
                name="<?= $this->get_field_name('channel') ?>"
                value="<?= esc_attr($channel) ?>"
                id="<?= $this->get_field_name('channel') ?>">
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
        <p>
            <label for="<?= $this->get_field_id('parent') ?>">
                <?php esc_attr_e('Nom de votre site : ', 'twitch_domain'); ?>
            </label>
            <input
                    class="widefat"
                    type="text"
                    name="<?= $this->get_field_name('parent') ?>"
                    value="<?= esc_attr($parent) ?>"
                    id="<?= $this->get_field_name('parent') ?>">
        </p>

        <?php
    }

    public function update( $newInstance, $oldInstance ) {
        $instance = array();
        $instance['parent'] = (!empty($newInstance['parent'])) ? $newInstance['parent'] : '';
        $instance['title'] = (!empty($newInstance['title'])) ? $newInstance['title'] : '';
        $instance['channel'] = (!empty($newInstance['channel'])) ? $newInstance['channel'] : '';
        $instance['width'] = (!empty($newInstance['width'])) ? $newInstance['width'] : '';
        $instance['height'] = (!empty($newInstance['height'])) ? $newInstance['height'] : '';
        return $instance;
    }

}