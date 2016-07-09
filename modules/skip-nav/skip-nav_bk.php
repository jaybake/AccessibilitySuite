<?


    function skipnav(){
          $data=get_option('sltype');
					
          $pluginpath=plugin_dir_url(__FILE__);
          wp_register_script('jQuery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
          wp_enqueue_script('jQuery');
					plugin_dir_path( $file);
          wp_enqueue_script('text_js', plugin_dir_url(__FILE__).'js/skipnav.js');

					$pi_path = plugins_url('images/skip-nav/transparent.png' , dirname(__FILE__)); 
					$data_pass = array('linkopt' => $data, 'plugin_path' => $pi_path);
          wp_localize_script('text_js','skiplinker', $data_pass);

    }
    add_action('wp_head','skipnav',30);

    function skipnavup(){
         add_option('sltype', 'image');
    }
    register_activation_hook(__FILE__, skipnavup); 


    function asuite(){
			   $as_rp=as_ze::rp();
         echo '
<div id="as_ui_wrapper">
    <div class="as_ui_title">Accessibility Suite</div>
    <div id="as_ui_tabs" class="style-tabs">
		';
		include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/tab_nav.inc');
		
		echo '
        <div id="contrast">
				';
				  include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/contrast.inc');
				echo '
				</div>


        <div id="font-changer">
				';
				  include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/fontchanger.inc');
				echo '
        </div>

        <div id="skip-nav"></div>

        <div id="text-only">
				';
				  include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/textonly.inc');
				echo '
        </div>

        <div id="transcript"></div>

        <div id="licensing"></div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(function () {
            $("#as_ui_tabs").tabs({
                collapsible: true
            });
            $("#as_ui_tabs").tabs({
                fx: [{
                    opacity: "toggle",
                    duration: "normal"
                }, {
                    opacity: "toggle",
                    duration: "fast"
                }]
            }).addClass("ui-tabs-vertical");

            //unbind license tab for absolute link
            $("li#li_license a").unbind("click").each(function () {
                this.href = "admin.php?page=accessibility-suite-license&aspv=ls";
            });
            //unbind skipnav tab for absolute link
            $("li#li_skipnav a").unbind("click").each(function () {
                this.href = "admin.php?page=as_skip_nav&aspv=sn";
            });
            //unbind transcript tab for absolute link
            $("li#li_transcript a").unbind("click").each(function () {
                this.href = "edit.php?post_type=transcripts&aspv=ts";
            });
						';
						 if($as_rp!==true): 
               echo '
						   $( "#as_ui_tabs").tabs( "disable", 0);
               $( "#as_ui_tabs").tabs( "disable", 1);
               $( "#as_ui_tabs").tabs( "disable", 4);
						';
						endif;
            echo '
            $("#as_ui_wrapper").show();
        });
    });
</script>
            ';
		}
    function plugin_admin_init(){
          register_setting( 'asuiteoptions', 'sltype' );
          add_settings_section('asplugin', 'Skip Navigation Settings', 'astext', 'as_skip_nav');
          add_settings_field('link-selection', 'Select the proper link for your site.', 'showme', 'asuiteoptions', 'asplugin');
    }
    add_action('admin_init', 'plugin_admin_init');

    function astext(){
echo "<p>You have the option to show a single pixel image link that will not show to users not using assistive technology, but will be caught by those using screen readers. Or you can provide a visible link that everyone will see.</p>";
    }
    function showme(){
?>

<?
    }

    function as_skip_nav(){
			 $as_rp=as_ze::rp();
?>




<div id="as_ui_wrapper">
    <div class="as_ui_title">Accessibility Suite</div>
    <div id="as_ui_tabs" class="style-tabs">
        <?php include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/tab_nav.inc'); ?>

        <div id="contrast"><?php include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/contrast.inc');?> </div>
        <div id="font-changer"><?php include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/fontchanger.inc'); ?></div>
        <div id="skip-nav">
<div class="as_ui_tab_content">
<?php //screen_icon("plugins"); ?> <H2>Skip Navigation Settings</H2>
<form method="POST" action="options.php">

<?php settings_fields( 'asuiteoptions' ); ?>
<?php do_settings_fields( 'asuiteoptions', 'asuiteoptions'  ); ?>
<label for="sltype">
What type of link do you want to show?
</label>
<select name="sltype">
<option value="">--Select One--</option>
<option value="image" <?php if(get_option('sltype') == 'image'): echo 'selected="selected"';  endif; ?>>Image</option>
<option value="link" <?php if(get_option('sltype') == 'link'): echo 'selected="selected"'; endif; ?>>Link</option>
</select>
<?php submit_button('Save Settings', 'primary', 'saveme'); ?>
</form>
</div>
</div>

        <div id="text-only"><?php include(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/textonly.inc'); ?></div>
        <div id="transcript"></div>

        <div id="licensing"></div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(function () {
            $("#as_ui_tabs").tabs({
                collapsible: true
            });
            $("#as_ui_tabs").tabs({
                fx: [{
                    opacity: "toggle",
                    duration: "normal"
                }, {
                    opacity: "toggle",
                    duration: "fast"
                }]
            }).addClass("ui-tabs-vertical");
						$("#as_ui_tabs").tabs("option", "active", 2);	
						$("#as_ui_wrapper").show();
						
						
            //unbind license tab for absolute link
            $("li#li_license a").unbind("click").each(function () {
                this.href = "admin.php?page=accessibility-suite-license&aspv=ls";
            });
            //unbind skipnav tab for absolute link
            $("li#li_skipnav a").unbind("click").each(function () {
                this.href = "admin.php?page=as_skip_nav&aspv=sn";
            });
            //unbind transcript tab for absolute link
            $("li#li_transcript a").unbind("click").each(function () {
                this.href = "edit.php?post_type=transcripts&aspv=ts";
            });
						
						<?php
						 if($as_rp!==true): 
               echo '
						   $( "#as_ui_tabs").tabs( "disable", 0);
               $( "#as_ui_tabs").tabs( "disable", 1);
               $( "#as_ui_tabs").tabs( "disable", 4);
						   ';
						endif;
            echo '
            $("#as_ui_wrapper").show();
        });
    });
</script>';


    }

    function skipnavdown(){
         delete_option('sltype');
    }
    register_deactivation_hook(__FILE__, skipnavdown);
    
    function skipNavPostClass($classes){
          $classes[] = 'skipnav';
          return $classes;
    }
    add_filter('post_class','skipNavPostClass');
?>