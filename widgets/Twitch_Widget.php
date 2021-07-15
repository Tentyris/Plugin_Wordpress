<?php

class Twitch_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'twitch_widget',
            __('Twitch Live Widget', 'twitch_chat_domain'),
            array( 'description' => __( 'Widget d\'intégration de lives Twitch', 'twitch_chat_domain' ), )
        );
    }

    public function widget( $args, $instance ) {

        echo $args['before_widget'];
        if(!empty($instance['title'])){
            $title = apply_filters('widget_title', $instance['title']);
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $parent = isset($instance['parent']) ? $instance['parent'] : '';
        $channel = isset($instance['channel']) ? $instance['channel'] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        $fullscreen = ($instance['fullscreen'] == 'on') ? 'true' : 'false';
        $scroll = ($instance['scroll'] == 'on') ? 'yes' : 'no';

        echo '<iframe src="https://player.twitch.tv/?channel='. $channel .'&parent='. $parent .'" allowfullscreen="'. $fullscreen .'" scrolling="'. $scroll .'" height="'. $height .'" width="'. $width .'"></iframe>';

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = isset($instance[ 'title' ]) ? $instance[ 'title' ] : '';
        $parent = isset($instance['parent']) ? $instance['parent'] : '';
        $channel = isset($instance[ 'channel' ]) ? $instance[ 'channel' ] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        ?>
        <p>
            <label for="<?= $this->get_field_id('title') ?>">
                <?php esc_attr_e('Titre : ', 'twitch_chat_domain'); ?>
            </label>
            <input
                class="widefat"
                type="text"
                name="<?= $this->get_field_name('title') ?>"
                value="<?= esc_attr($title) ?>"
                id="<?= $this->get_field_name('title') ?>">
        </p>
        <p>
            <label for="<?= $this->get_field_id('parent') ?>">
                <?php esc_attr_e('Nom de votre site : ', 'twitch_chat_domain'); ?>
            </label>
            <input
                class="widefat"
                type="text"
                name="<?= $this->get_field_name('parent') ?>"
                value="<?= esc_attr($parent) ?>"
                id="<?= $this->get_field_name('parent') ?>">
        </p>
        <p>
            <label for="<?= $this->get_field_id('channel') ?>">
                <?php esc_attr_e('Chaîne : ', 'twitch_chat_domain'); ?>
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
            <label for="<?php echo $this->get_field_id( 'scroll' ); ?>">
                <?php esc_attr_e( 'scroll :', 'twitch_chat_domain' ); ?>
            </label>
            <input class="checkbox"
                   id="<?php echo $this->get_field_id( 'scroll' ); ?>"
                   name="<?php echo $this->get_field_name( 'scroll' ); ?>"
                   type="checkbox"
                <?php checked( $instance[ 'scroll' ], 'on' ); ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'fullscreen' ); ?>">
                <?php esc_attr_e( 'fullscreen :', 'twitch_chat_domain' ); ?>
            </label>
            <input class="checkbox"
                   id="<?php echo $this->get_field_id( 'fullscreen' ); ?>"
                   name="<?php echo $this->get_field_name( 'fullscreen' ); ?>"
                   type="checkbox"
                <?php checked( $instance[ 'fullscreen' ], 'on' ); ?> />
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
        $instance['scroll'] = (!empty($newInstance['scroll'])) ? $newInstance['scroll'] : '';
        $instance['fullscreen'] = (!empty($newInstance['fullscreen'])) ? $newInstance['fullscreen'] : '';
        return $instance;
    }

// Class wpb_widget ends here
}