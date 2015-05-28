<?php
class flickrwidget extends WP_Widget {

    function flickrwidget() {
        $widget_ops = array(
            'classname' => 'flickr_widget',
            'description' => 'Images from your Flickr account.'
        );
        $control_ops = array('width' => 80, 'height' => 80);
        parent::WP_Widget(false, 'Themewaves flickr', $widget_ops, $control_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('flickr_title' => ''));
        $flickr_title = isset($instance['flickr_title']) ? strip_tags($instance['flickr_title']) : '';
        $flickr_type = isset($instance['flickr_type']) ? strip_tags($instance['flickr_type']) : '';
        $flickr_userid = isset($instance['flickr_userid']) ? strip_tags($instance['flickr_userid']) : '';
        $flickr_num = isset($instance['flickr_num']) ? strip_tags($instance['flickr_num']) : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('flickr_title'); ?>"><?php _e('Title:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('flickr_title'); ?>" name="<?php echo $this->get_field_name('flickr_title'); ?>" type="text" value="<?php echo esc_attr($flickr_title); ?>" /></p>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_type'); ?>">Type (user or group):</label>
            <select id="<?php echo $this->get_field_id('flickr_type'); ?>" name="<?php echo $this->get_field_name('flickr_type'); ?>" class="widefat">	
                <option <?php if ('user' == $flickr_type) echo 'selected="selected"'; ?>>user</option>
                <option <?php if ('group' == $flickr_type) echo 'selected="selected"'; ?>>group</option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id('flickr_userid'); ?>"><?php _e('Flickr user ID:', 'themewaves'); ?></label>
            <br>
            <input class="widefat" id="<?php echo $this->get_field_id('flickr_userid'); ?>" name="<?php echo $this->get_field_name('flickr_userid'); ?>" type="text" value="<?php echo esc_attr($flickr_userid); ?>" />
            <br>
            <small><em>Find ID <a href="http://idgettr.com/" target="_blank">http://idgettr.com/</a></em></small>
        </p>

        <p><label for="<?php echo $this->get_field_id('flickr_num'); ?>"><?php _e('How many pictures display:', 'themewaves'); ?></label>
            <input maxlength="3" class="widefat" id="<?php echo $this->get_field_id('flickr_num'); ?>" name="<?php echo $this->get_field_name('flickr_num'); ?>" type="text" value="<?php echo esc_attr($flickr_num); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['flickr_title'] = strip_tags($new_instance['flickr_title']);
        $instance['flickr_type'] = strip_tags($new_instance['flickr_type']);
        $instance['flickr_userid'] = strip_tags($new_instance['flickr_userid']);
        $instance['flickr_num'] = strip_tags($new_instance['flickr_num']);
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $flickr_title = apply_filters('widget_flickr_title', empty($instance['flickr_title']) ? '' : $instance['flickr_title'], $instance);
        $flickr_type = apply_filters('widget_flickr_type', empty($instance['flickr_type']) ? '' : $instance['flickr_type'], $instance);
        $flickr_userid = apply_filters('widget_flickr_userid', empty($instance['flickr_userid']) ? '' : $instance['flickr_userid'], $instance);
        $flickr_num = apply_filters('widget_flickr_num', empty($instance['flickr_num']) ? '' : $instance['flickr_num'], $instance);
        $class = apply_filters('widget_class', empty($instance['class']) ? '' : $instance['class'], $instance);

        echo $before_widget;

        $flickr_title = $flickr_title;
        
        if (!empty($flickr_title)) {
            echo $before_title . $flickr_title . $after_title;
        }
        echo '<div class="flickr-widget">';
            echo '<div class="flickr-channel">'; ?>
                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $flickr_num ?>&amp;size=s&amp;layout=v&amp;source=<?php echo $flickr_type ?>&amp;<?php echo $flickr_type ?>=<?php echo $flickr_userid ?>"></script><?php
            echo '</div>';
        echo '</div>';
        echo $after_widget;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("flickrwidget");'));
?>