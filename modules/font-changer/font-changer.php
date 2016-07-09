<?php


    function asFontChange()
    {
        $pluginpath = plugin_dir_url(__FILE__);
        wp_enqueue_script('fontchanger-script', $pluginpath . '/js/fontchanger.js', 'jquery');
    }
    add_action('wp_head', 'asFontChange', 4);

    function asFontChangeBodyClass($classes)
    {
        $classes[] = 'asFontChanged';
        return $classes;
    }
    add_filter('body_class', 'asFontChangeBodyClass');

    function asFontChanger()
    {
        // if text only module isn't enabled, then show font changer option
        if(empty($_GET['text-only'])) {
?>
         <div title='Resize All Text' class='asFontChangeControls' style='background-color:transparent;padding:3px;width:77spx;padding-top:10px;padding-bottom:10px;'><a class='increase' title='Makes Text Bigger' style='font-size:18px;cursor:pointer;' >A +</a><a class='resetfontchanger' title='Resets Text To Original Size' style='font-size:13px;padding-left:10px;cursor:pointer;'><strike>A</strike></a><a class='decrease' title='Makes Text Smaller' style='font-size:10px;padding-left:10px;cursor:pointer;'>A -</a></div>
<?php
        }//empty $_GET['text-only']
    }
    add_shortcode('asfont', 'asFontChanger');

    class asfontChange extends WP_Widget
    {
        function __construct()
        {
            $widgetargs = array(
                'classname' => 'asFontChange',
                'description' => 'Adds font resizing controls for low vision visitors.'
            );
            $this->WP_Widget('asFontChange', 'asFontChange', $widgetargs);
        }

        function form($instance)
        {
            $instance = wp_parse_args((array) $instance, array(
                'title' => ''
            ));
            $title    = $instance['title'];
            ?>
          <p><label for="<?php
            echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php
            echo $this->get_field_id('title'); ?>" name="<?php
            echo $this->get_field_name('title'); ?>" type="text" value="<?php
            echo attribute_escape($title); ?>" /></label></p>
        <?php
        }

        function update($new_instance, $old_instance)
        {
            $instance          = $old_instance;
            $instance['title'] = $new_instance['title'];
            return $instance;
        }

        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);

            echo $before_widget;
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

            if (!empty($title))
                echo $before_title . $title . $after_title;
            ;

            asFontChanger();

            echo $after_widget;
        }

    }
    add_action('widgets_init', create_function('', 'return register_widget("asFontChange");'));

?>
