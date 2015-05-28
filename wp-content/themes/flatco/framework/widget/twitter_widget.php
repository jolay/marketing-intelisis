<?php
class twitterwidget extends WP_Widget {
    function twitterwidget() {
        $widget_ops = array('classname' => 'twitterwidget', 'description' => 'Displays your Tweets.');
        parent::WP_Widget(false, 'Themewaves Twitter', $widget_ops);
    }
    function form($instance){ ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>"  />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>">User Name:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo isset($instance['username']) ? $instance['username'] : ''; ?>"  />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tweetstoshow'); ?>">Tweets to display:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('tweetstoshow'); ?>" name="<?php echo $this->get_field_name('tweetstoshow'); ?>"><?php
                for($i=1;$i<=10;$i++){
                    echo '<option value="'.$i.'"'.(isset($instance['tweetstoshow'])&&$instance['tweetstoshow'] == $i?' selected="selected"':'').'>'.$i.'</option>';
                } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cachetime'); ?>">cachetime:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('cachetime'); ?>" name="<?php echo $this->get_field_name('cachetime'); ?>" value="<?php echo isset($instance['cachetime']) ? $instance['cachetime'] : ''; ?>"  />
        </p><?php
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance = $new_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
            if ($title){echo $before_title . $title . $after_title;}
            echo do_shortcode('[tw_twitter username="'.$instance['username'].'" tweetstoshow="'.$instance['tweetstoshow'].'" cachetime="'.$instance['cachetime'].'"]');
        echo $after_widget;
    }
}
add_action('widgets_init', create_function('', 'return register_widget("twitterwidget");'));
?>