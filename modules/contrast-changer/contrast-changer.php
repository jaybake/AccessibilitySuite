<?php


    function asCChange(){
          $pluginpath=plugin_dir_url(__FILE__);
          wp_enqueue_script('contrastchanger-script', $pluginpath.'/js/cchanger.js','jquery');
    }
    add_action('wp_head','asCChange',4);

    function asCChangeBodyClass($classes){
          $classes[] = 'asContrastChanged';
          return $classes;
    }
    add_filter('body_class','asCChangeBodyClass');
    
    function asCChanger(){ 
        if(empty($_GET['text-only'])) {
      ?>
         <div title='Change Contrasts' class='asCChangeControls' style='background-color:transparent;padding:3px;width:75px; padding-top:10px;padding-bottom:10px;'><a class='wob' title='White Text Black Background' style='color:#FFFFFF;background-color: #000000; padding: 5px;cursor:pointer;' >A</a><a class='resetme' title='Resets Text To Original Look and Feel' style='padding:5px;cursor:pointer;'>A</a><a class='yob' title='Yellow Text Black Background' style='color:#FFFF00;background-color:#000000;padding:5px;cursor:pointer;'>A</a></div>
<?php
        }//empty $_GET['text-only']
    }
    add_shortcode('ascontrast','asCChanger');

class ascChange extends WP_Widget {
    function __construct(){
          $widgetargs = array('classname' => 'asCChange', 'description' => 'Adds contrast controls for low vision visitors.' );
          $this->WP_Widget('asCChange', 'asContrastChange', $widgetargs);
    }
    
        function form($instance){
          $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
          $title = $instance['title'];
?>
          <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
    }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;

    asCChanger();

    echo $after_widget;
  }     

}
add_action( 'widgets_init', create_function('', 'return register_widget("asCChange");') );

?>