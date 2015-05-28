<?php
class contactinfo extends WP_Widget {

    function contactinfo() {
        $widget_ops = array(
            'classname' => 'flickr_widget',
            'description' => 'Contact info.'
        );
        $control_ops = array('width' => 80, 'height' => 80);
        parent::WP_Widget(false, 'Themewaves contact info', $widget_ops, $control_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('contact_title' => ''));
        $contact_title = isset($instance['contact_title']) ? strip_tags($instance['contact_title']) : '';
        $contact_address = isset($instance['contact_address']) ? strip_tags($instance['contact_address']) : '';
        $contact_phone = isset($instance['contact_phone']) ? strip_tags($instance['contact_phone']) : '';
        $contact_email_url = isset($instance['contact_email_url']) ? strip_tags($instance['contact_email_url']) : '';
        $contact_email = isset($instance['contact_email']) ? strip_tags($instance['contact_email']) : '';
        $contact_web_url = isset($instance['contact_web_url']) ? strip_tags($instance['contact_web_url']) : '';
        $contact_web = isset($instance['contact_web']) ? strip_tags($instance['contact_web']) : '';
        $contact_facebook_url = isset($instance['contact_facebook_url']) ? strip_tags($instance['contact_facebook_url']) : '';
        $contact_facebook = isset($instance['contact_facebook']) ? strip_tags($instance['contact_facebook']) : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('contact_title'); ?>"><?php _e('Title:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_title'); ?>" name="<?php echo $this->get_field_name('contact_title'); ?>" type="text" value="<?php echo esc_attr($contact_title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_address'); ?>"><?php _e('Content address:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_address'); ?>" name="<?php echo $this->get_field_name('contact_address'); ?>" type="text" value="<?php echo esc_attr($contact_address); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_phone'); ?>"><?php _e('Contact phone number:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_phone'); ?>" name="<?php echo $this->get_field_name('contact_phone'); ?>" type="text" value="<?php echo esc_attr($contact_phone); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_email_url'); ?>"><?php _e('Contact email link url:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_email_url'); ?>" name="<?php echo $this->get_field_name('contact_email_url'); ?>" type="text" value="<?php echo esc_attr($contact_email_url); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_email'); ?>"><?php _e('Contact email:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_email'); ?>" name="<?php echo $this->get_field_name('contact_email'); ?>" type="text" value="<?php echo esc_attr($contact_email); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_web_url'); ?>"><?php _e('Contact web link url:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_web_url'); ?>" name="<?php echo $this->get_field_name('contact_web_url'); ?>" type="text" value="<?php echo esc_attr($contact_web_url); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_web'); ?>"><?php _e('Contact web:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_web'); ?>" name="<?php echo $this->get_field_name('contact_web'); ?>" type="text" value="<?php echo esc_attr($contact_web); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_facebook_url'); ?>"><?php _e('Contact facebook link url:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_facebook_url'); ?>" name="<?php echo $this->get_field_name('contact_facebook_url'); ?>" type="text" value="<?php echo esc_attr($contact_facebook_url); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('contact_facebook'); ?>"><?php _e('Contact facebook:', 'themewaves'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_facebook'); ?>" name="<?php echo $this->get_field_name('contact_facebook'); ?>" type="text" value="<?php echo esc_attr($contact_facebook); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['contact_title'] = strip_tags($new_instance['contact_title']);
        $instance['contact_address'] = strip_tags($new_instance['contact_address']);
        $instance['contact_phone'] = strip_tags($new_instance['contact_phone']);
        $instance['contact_email'] = strip_tags($new_instance['contact_email']);
        $instance['contact_email_url'] = strip_tags($new_instance['contact_email_url']);
        $instance['contact_web'] = strip_tags($new_instance['contact_web']);
        $instance['contact_web_url'] = strip_tags($new_instance['contact_web_url']);
        $instance['contact_facebook'] = strip_tags($new_instance['contact_facebook']);
        $instance['contact_facebook_url'] = strip_tags($new_instance['contact_facebook_url']);
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $contact_title = apply_filters('widget_contact_title', empty($instance['contact_title']) ? '' : $instance['contact_title'], $instance);
        $contact_address = apply_filters('widget_contact_address', empty($instance['contact_address']) ? '' : $instance['contact_address'], $instance);
        $contact_phone = apply_filters('widget_contact_phone', empty($instance['contact_phone']) ? '' : $instance['contact_phone'], $instance);
        $contact_email = apply_filters('widget_contact_email', empty($instance['contact_email']) ? '' : $instance['contact_email'], $instance);
        $contact_email_url = apply_filters('widget_contact_email_url', empty($instance['contact_email_url']) ? '' : $instance['contact_email_url'], $instance);
        $contact_web = apply_filters('widget_contact_web', empty($instance['contact_web']) ? '' : $instance['contact_web'], $instance);
        $contact_web_url = apply_filters('widget_contact_web_url', empty($instance['contact_web_url']) ? '' : $instance['contact_web_url'], $instance);
        $contact_facebook = apply_filters('widget_contact_facebook', empty($instance['contact_facebook']) ? '' : $instance['contact_facebook'], $instance);
        $contact_facebook_url = apply_filters('widget_contact_facebook_url', empty($instance['contact_facebook_url']) ? '' : $instance['contact_facebook_url'], $instance);
        $class = apply_filters('widget_class', empty($instance['class']) ? '' : $instance['class'], $instance);

        echo $before_widget;

        $contact_title = $contact_title;
        
        if (!empty($contact_title)) {
            echo $before_title . $contact_title . $after_title;
        }
        echo '<div class="contact-info-widget">';
            echo '<ul>';
                if(!empty($contact_address)){
                    echo '<li><i class="fa fa-map-marker"></i><div>'.$contact_address.'</div></li>';
                }
                if(!empty($contact_phone)){
                    echo '<li><i class="fa fa-phone"></i><div>'.$contact_phone.'</div></li>';
                }
                if(!empty($contact_email)){
                    echo '<li><i class="fa fa-envelope-o"></i><div><a href="'.  $contact_email_url.'">'.$contact_email.'</a></div></li>';
                }
                if(!empty($contact_web)){
                    echo '<li><i class="fa fa-globe"></i><div><a target="_blank" href="'.  to_url($contact_web_url).'">'.$contact_web.'</a></div></li>';
                }
                if(!empty($contact_facebook)){
                    echo '<li><i class="fa fa-facebook"></i><div><a target="_blank" href="'.  to_url($contact_facebook_url).'">'.$contact_facebook.'</a></div></li>';
                }
            echo '</ul>';
        echo '</div>';
        ?>

        <?php
        echo $after_widget;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("contactinfo");'));
?>