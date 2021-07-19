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
        $fullscreen = ($instance['fullscreen'] == 'on') ? 'allowfullscreen' : '';
        $autoplay = ($instance['autoplay'] == 'on') ? 'autoplay;' : '';
        echo '<iframe width="'. esc_attr($width) .'" height="' . $height . '" src="https://www.youtube.com/embed/'. esc_attr($youtube) . '" title="YouTube video player" frameborder="0" allow="accelerometer; '. $autoplay .' clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                ' . $fullscreen . '></iframe>';

        if ($instance['likes'] == 'on') {
            ?>
            <p id="displayLikes"></p>
            <?php
            echo '<script type="text/javascript">
                    jQuery.ajax({
                       url: \'https://www.googleapis.com/youtube/v3/videos\',
                       method: \'GET\',
                       headers: {
                                "Authorization":"Bearer",
                           "Accept":"application/json"
                       },
                       data: "part=statistics&id='. $youtube .'&key=AIzaSyDIXzmnJ_QPZg-eTtb7PB32OBG8PzA26TU"
                    }).done(function (data) {
                        jQuery("#displayLikes").html("");
                        for (var likes in data["items"]) {
                            jQuery("#displayLikes").append("<img src=\"https://uxwing.com/wp-content/themes/uxwing/download/10-brands-and-social-media/blue-like-button.png\" width=\"25px\" height=\"25px\"> "
                             + data["items"][likes]["statistics"]["likeCount"] 
                             + " <img src=\"https://www.freeiconspng.com/uploads/free-youtube-dislike-pictures-15.png\" width=\"25px\" height=\"25px\"> " 
                             + data["items"][likes]["statistics"]["dislikeCount"]);
                        }
                    });
                </script>';
        }

        if ($instance['views'] == 'on') {
            ?>
            <p id="viewDisplay"></p>
            <?php
            echo '<script type="text/javascript">
                    jQuery.ajax({
                       url: \'https://www.googleapis.com/youtube/v3/videos\',
                       method: \'GET\',
                       headers: {
                                "Authorization":"Bearer",
                           "Accept":"application/json"
                       },
                       data: "part=statistics&id='. $youtube .'&key=AIzaSyDIXzmnJ_QPZg-eTtb7PB32OBG8PzA26TU"
                    }).done(function (data) {
                        jQuery("#viewDisplay").html("");
                        for (var likes in data["items"]) {
                            console.log(data["items"][likes]["statistics"]["viewCount"]);
                            jQuery("#viewDisplay").append("Vues : " + data["items"][likes]["statistics"]["viewCount"]);
                        }
                    });
                </script>';
        }

        if ($instance['comments'] == 'on') {
            ?>
            <p id="commentsDisplay"></p>
                <?php
            echo '<script type="text/javascript">
                    jQuery.ajax({
                       url: \'https://youtube.googleapis.com/youtube/v3/commentThreads\',
                       method: \'GET\',
                       headers: {
                                "Authorization":"Bearer",
                           "Accept":"application/json"
                       },
                       data: "part=id%2C%20snippet&maxResults='. $instance['commentsCount'] .'&order=relevance&videoId='. $youtube .'&key=AIzaSyDIXzmnJ_QPZg-eTtb7PB32OBG8PzA26TU"
                    }).done(function (data) {
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
        $likes = (!empty($instance[ 'likes' ])) ? $instance['likes'] : '';
        $views = (!empty($instance[ 'views' ])) ? $instance['views'] : '';
        $fullscreen = (!empty($instance[ 'fullscreen' ])) ? $instance['fullscreen'] : '';
        $autoplay = (!empty($instance[ 'autoplay' ])) ? $instance['autoplay'] : '';
        $commentsCount = (!empty($instance[ 'commentsCounts' ])) ? $instance['commentsCounts'] : '';
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
                <label for="<?= $this->get_field_id('commentsCount') ?>">Nombre de commentaires : </label>
                <input
                        class="widefat"
                        type="text"
                        name="<?= $this->get_field_name('commentsCount') ?>"
                        value="<?= esc_attr($commentsCount) ?>"
                        id="<?= $this->get_field_name('commentsCount') ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'likes' ); ?>">
                    <?php esc_attr_e( 'Likes :', 'yts_domain' ); ?>
                </label>
                <input class="checkbox"
                       id="<?php echo $this->get_field_id( 'likes' ); ?>"
                       name="<?php echo $this->get_field_name( 'likes' ); ?>"
                       type="checkbox"
                    <?php checked( $instance[ 'likes' ], 'on' ); ?> />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'views' ); ?>">
                    <?php esc_attr_e( 'views :', 'yts_domain' ); ?>
                </label>
                <input class="checkbox"
                       id="<?php echo $this->get_field_id( 'views' ); ?>"
                       name="<?php echo $this->get_field_name( 'views' ); ?>"
                       type="checkbox"
                    <?php checked( $instance[ 'views' ], 'on' ); ?> />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'fullscreen' ); ?>">
                    <?php esc_attr_e( 'fullscreen :', 'yts_domain' ); ?>
                </label>
                <input class="checkbox"
                       id="<?php echo $this->get_field_id( 'fullscreen' ); ?>"
                       name="<?php echo $this->get_field_name( 'fullscreen' ); ?>"
                       type="checkbox"
                    <?php checked( $instance[ 'fullscreen' ], 'on' ); ?> />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>">
                    <?php esc_attr_e( 'autoplay :', 'yts_domain' ); ?>
                </label>
                <input class="checkbox"
                       id="<?php echo $this->get_field_id( 'autoplay' ); ?>"
                       name="<?php echo $this->get_field_name( 'autoplay' ); ?>"
                       type="checkbox"
                    <?php checked( $instance[ 'autoplay' ], 'on' ); ?> />
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
        $instance['commentsCount'] = (!empty($newInstance['commentsCount'])) ? $newInstance['commentsCount'] : '';
        $instance['comments'] = $newInstance['comments'];
        $instance['likes'] = $newInstance['likes'];
        $instance['views'] = $newInstance['views'];
        $instance['fullscreen'] = $newInstance['fullscreen'];
        $instance['autoplay'] = $newInstance['autoplay'];

        return $instance;
    }
}