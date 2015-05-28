<?php
class dribbblewidget extends WP_Widget {

    function dribbblewidget() {
        $widget_ops = array(
            'classname' => 'dribbble_widget',
            'description' => 'Images from your dribbble account.'
        );
        $control_ops = array('width' => 80, 'height' => 80);
        parent::WP_Widget(false, 'Themewaves dribbble', $widget_ops, $control_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('dribbble_title' => ''));
        $dribbble_title = isset($instance['dribbble_title']) ? strip_tags($instance['dribbble_title']) : '';
        $dribbble_userid = isset($instance['dribbble_userid']) ? strip_tags($instance['dribbble_userid']) : '';
        $dribbble_num = isset($instance['dribbble_num']) ? strip_tags($instance['dribbble_num']) : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('dribbble_title'); ?>"><?php _e('Title:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('dribbble_title'); ?>" name="<?php echo $this->get_field_name('dribbble_title'); ?>" type="text" value="<?php echo esc_attr($dribbble_title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('dribbble_userid'); ?>"><?php _e('dribbble user ID:', 'themewaves'); ?></label>
            <br>
            <input class="widefat" id="<?php echo $this->get_field_id('dribbble_userid'); ?>" name="<?php echo $this->get_field_name('dribbble_userid'); ?>" type="text" value="<?php echo esc_attr($dribbble_userid); ?>" />
            <br>
            <small><em>Find ID <a href="http://dribbble.com/" target="_blank">http://dribbble.com/</a></em></small>
        </p>

        <p><label for="<?php echo $this->get_field_id('dribbble_num'); ?>"><?php _e('How many dribbble display:', 'themewaves'); ?></label>
            <input maxlength="3" class="widefat" id="<?php echo $this->get_field_id('dribbble_num'); ?>" name="<?php echo $this->get_field_name('dribbble_num'); ?>" type="text" value="<?php echo esc_attr($dribbble_num); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['dribbble_title'] = strip_tags($new_instance['dribbble_title']);
        $instance['dribbble_userid'] = strip_tags($new_instance['dribbble_userid']);
        $instance['dribbble_num'] = strip_tags($new_instance['dribbble_num']);
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $dribbble_title = apply_filters('widget_dribbble_title', empty($instance['dribbble_title']) ? '' : $instance['dribbble_title'], $instance);
        $dribbble_userid = apply_filters('widget_dribbble_userid', empty($instance['dribbble_userid']) ? '' : $instance['dribbble_userid'], $instance);
        $dribbble_num = apply_filters('widget_dribbble_num', empty($instance['dribbble_num']) ? '' : $instance['dribbble_num'], $instance);
        $class = apply_filters('widget_class', empty($instance['class']) ? '' : $instance['class'], $instance);
        echo $before_widget;        
            if (!empty($dribbble_title)) {echo $before_title . $dribbble_title . $after_title;}
            echo '<div class="dribbble-widget">';
                $shots=false;
                $response = wp_remote_get( 'http://api.dribbble.com/players/' . $dribbble_userid . '/shots/?per_page='.$dribbble_num );
                if( !is_wp_error( $response ) ){
                    $xml = wp_remote_retrieve_body( $response );
                    if( !is_wp_error( $xml ) ){
                        if( $response['headers']['status'] == 200 ) {
                            $json = json_decode( $xml );
                            $shots = $json->shots;
                        }
                    }
                }
                if( $shots ) {
                    foreach( $shots as $shot ){
                        echo '<a href="' . $shot->url . '" target="_blank">';
                            echo '<img src="' . $shot->image_teaser_url . '" alt="' . $shot->title . '" />';
                        echo '</a>';                        
                    }
                } else {
                    echo __('Error', 'themewaves');
                }
            echo '</div>';
        echo $after_widget;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("dribbblewidget");'));
?>