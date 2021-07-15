<?php

class Youtube_Widget extends WP_Widget{
    public function __construct()
    {
        parent::__construct(
                'youtube_widget',
                esc_html__('Youtube Widget', 'ytstwc_domain'),
                array('description' => esc_html__('Widget d\'intégration de vidéos Youtube', 'ytstwc_domain'))
        );
    }

    public function widget ($args, $instance){
        echo $args['before_widget'];
        if(!empty($instance['title'])){
            $title = apply_filters('widget_title', $instance['title']);
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        echo '<iframe width="'. esc_attr($width) .'" height="' . $height . '" src="https://www.youtube.com/embed/'. esc_attr($youtube) . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

        if ($instance['comments'] == 'on') {
            ?>
            <p id="commentsDisplay" class="card"></p>
                <?php
            echo '<script type="text/javascript">
                    jQuery.ajax({
                       url: \'https://youtube.googleapis.com/youtube/v3/commentThreads\',
                       method: \'GET\',
                       headers: {
                                "Authorization":"Bearer",
                           "Accept":"application/json"
                       },
                       data: "part=id%2C%20snippet&maxResults=10&order=relevance&videoId='. $youtube .'&key=AIzaSyDIXzmnJ_QPZg-eTtb7PB32OBG8PzA26TU"
                    }).done(function (data) {
                        console.log(data["items"]);
                            jQuery("#commentsDisplay").html("");
                            for (var comment in data["items"]) {
                                jQuery("#commentsDisplay").append(data["items"][comment]["snippet"]["topLevelComment"]["snippet"]["authorDisplayName"] + " : " + data["items"][comment]["snippet"]["topLevelComment"]["snippet"]["textDisplay"] + "<hr>");
                            }
                        });
                </script>';
        }

        echo $args['after_widget'];

    }

    public function form($instance){
        $title = isset($instance['title']) ? $instance['title'] : '';
        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        $width = isset($instance['width']) ? $instance['width'] : '';
        $height = isset($instance['height']) ? $instance['height'] : '';
        $comments = (!empty($instance[ 'comments' ])) ? $instance['comments'] : '';
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
            <label for="<?= $this->get_field_id('youtube') ?>">Id Youtube</label>
            <input 
                class="widefat" 
                type="text" 
                name="<?= $this->get_field_name('youtube') ?>"
                value="<?= esc_attr($youtube) ?>"
                id="<?= $this->get_field_name('youtube') ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'comments' ); ?>">
                    <?php esc_attr_e( 'Commentaires :', 'yts_domain' ); ?>
                </label>
                <input class="checkbox"
                       id="<?php echo $this->get_field_id( 'comments' ); ?>"
                       name="<?php echo $this->get_field_name( 'comments' ); ?>"
                       type="checkbox"
                    <?php checked( $instance[ 'comments' ], 'on' ); ?> />
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
        $instance = array();

        $instance['title'] = (!empty($newInstance['title'])) ? $newInstance['title'] : '';
        $instance['youtube'] = (!empty($newInstance['youtube'])) ? $newInstance['youtube'] : '';
        $instance['width'] = (!empty($newInstance['width'])) ? $newInstance['width'] : '';
        $instance['height'] = (!empty($newInstance['height'])) ? $newInstance['height'] : '';
        $instance['comments'] = $newInstance['comments'];

        return $instance;
    }
}