<?php
class sociallinkswidget extends WP_Widget {

    function sociallinkswidget() {
        $widget_ops = array('classname' => 'sociallinkswidget', 'description' => 'Displays your social profile.');

        parent::WP_Widget(false, 'Themewaves Social', $widget_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
            if ($title){echo $before_title . $title . $after_title;}
            global $tw_socials;
            echo '<div class="tw-social-icon clearfix">';
            foreach ($tw_socials as $key => $social) {
                if(!empty($instance[$social['name']])){
                    echo '<a href="'.str_replace('*',$instance[$social['name']],$social['link']).'" target="_blank" title="'.$key.'" class="'.$key.'"><span class="tw-icon-'.$key.'"></span></a>';
                }
            }
            echo '</div>';
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance = $new_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form($instance) {
        global $tw_socials; ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>"  />
        </p> <?php
        foreach ($tw_socials as $key => $social) { ?>
            <p>
                <label for="<?php echo $this->get_field_id($social['name']); ?>"><?php echo $key; if($key==='linkedin'){echo ' URL';} ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id($social['name']); ?>" name="<?php echo $this->get_field_name($social['name']); ?>" value="<?php echo isset($instance[$social['name']]) ? $instance[$social['name']] : ''; ?>"  />
            </p><?php
        }
    }
}

add_action('widgets_init', create_function('', 'return register_widget("sociallinkswidget");'));
?>
