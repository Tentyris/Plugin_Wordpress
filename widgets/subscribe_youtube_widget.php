<?php

class Subscribe_Youtube_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(

            'youtube_subscribe_widget',

            __('Subscribe Youtube Widget', 'yts_domain'),

            array( 'description' => __( 'Bouton d\'abonnement youtube', 'yts_domain' ), )
        );
    }

    public function widget( $args, $instance ) {

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) )
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];

        $channel = (!empty($instance['channel'])) ? $instance['channel'] : 'fantabobgames';
        $count = ($instance['count'] == 'on') ? 'default' : 'hidden';
        $layout = ($instance['layout'] == 'on') ? 'full' : 'default';

        echo '<div class="g-ytsubscribe" data-channel="'. $channel .'" data-layout="'. $layout .'" data-count="'. $count .'"></div>';
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = (!empty($instance[ 'title' ])) ? $instance['title'] : '';
        $channel = (!empty($instance[ 'channel' ])) ? $instance['channel'] : '';
        $count = (!empty($instance[ 'count' ])) ? $instance['count'] : '';
        $layout = (!empty($instance[ 'layout' ])) ? $instance['layout'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php esc_attr_e( 'Title:', 'yts_domain' ); ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'channel' ); ?>">
                <?php esc_attr_e( 'channel:', 'yts_domain' ); ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'channel' ); ?>"
                   name="<?php echo $this->get_field_name( 'channel' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $channel ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>">
                <?php esc_attr_e( 'count:', 'yts_domain' ); ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'count' ); ?>"
                   name="<?php echo $this->get_field_name( 'count' ); ?>"
                   type="checkbox"
                   <?php checked( $instance[ 'count' ], 'on' ); ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'layout' ); ?>">
                <?php esc_attr_e( 'layout:', 'yts_domain' ); ?>
            </label>
            <input class="checkbox"
                   id="<?php echo $this->get_field_id( 'layout' ); ?>"
                   name="<?php echo $this->get_field_name( 'layout' ); ?>"
                   type="checkbox"
                   <?php checked( $instance[ 'layout' ], 'on' ); ?> />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['channel'] = ( ! empty( $new_instance['channel'] ) ) ? strip_tags( $new_instance['channel'] ) : '';
        $instance['count'] = $new_instance['count'];
        $instance['layout'] = $new_instance['layout'];
        return $instance;
    }

}

