<?php

define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );







//clean up post type entries

add_action('admin_menu', 'navcleanup');



function navcleanup() {

		remove_menu_page('edit.php?post_type=transcripts');	

}

	

// admin css

function posttype_admin_css() {

    global $post_type;

    if($post_type == 'transcripts') {

    echo '<style type="text/css">.view{display: none;}.inside #edit-slug-box {display: none;}</style>';

    }

}



// post type options

function create_transcript() {

	register_post_type( 'transcripts',

		array(

			'labels' => array(

				'name' => 'Transcript',

				'singular_name' => 'Transcript',

				'add_new' => 'Add New',

				'add_new_item' => 'Add New Transcript Set',

				'edit' => 'Edit',

				'edit_item' => 'Edit Transcript Set',

				'new_item' => 'New Transcript Set',

				'view' => '',

				'view_item' => '',

				'search_items' => 'Search Transcript Sets',

				'not_found' => 'No Transcript Sets found',

				'not_found_in_trash' => 'No Transcript Sets found in Trash',

				'parent' => 'Parent Transcripts'

			),



			'public' => true,

			'menu_position' => null,

			'supports' => array( 'title' ),

			'taxonomies' => array( '' ),

			'capability_type' => 'post',

			//'menu_icon' => plugins_url( 'images/icon.png', __FILE__ ),

			'register_meta_box_cb' => 'transcripts_meta_boxes', // Callback function for custom metaboxes

			'has_archive' => true

		)

	);



}





//add css

add_action('admin_head', 'posttype_admin_css');

//create post type

add_action( 'init', 'create_transcript' );













//meta box

function transcripts_meta_boxes() {

	add_meta_box( 'transcripts_form', 'Set Details', 'transcripts_form', 'transcripts', 'normal', 'high' );

}



function transcripts_form() {

	$post_id = get_the_ID();

	$transcript_data = get_post_meta( $post_id, '_transcript', true );



	$videoEmbedCode = ( empty( $transcript_data['videoEmbedCode'] ) ) ? '' : $transcript_data['videoEmbedCode'];

	$documentTitle = ( empty( $transcript_data['documentTitle'] ) ) ? '' : $transcript_data['documentTitle'];

	$linkOfPDF = ( empty( $transcript_data['linkOfPDF'] ) ) ? '' : $transcript_data['linkOfPDF'];

	$whereToAdd_aboveVDO = ( empty( $transcript_data['whereToAdd_aboveVDO'] ) ) ? '' : $transcript_data['whereToAdd_aboveVDO'];

	$whereToAdd_underVDO = ( empty( $transcript_data['whereToAdd_underVDO'] ) ) ? '' : $transcript_data['whereToAdd_underVDO'];

	

	wp_nonce_field( 'transcripts', 'transcripts' );

	?>

	

	<div class="postbox">



		<div class="misc-pub-section">

			<h4>Video Embed Code</h4>

			<textarea rows="10" cols="50" class="full-width" name="transcript[videoEmbedCode]"><?php echo $videoEmbedCode; ?></textarea> 

		</div>



		<div class="misc-pub-section">

			<h4>Link Text for Transcript</h4>

			<input type="text" size="50" name="transcript[documentTitle]" value="<?php echo $documentTitle; ?>">



			<h4>Link of the document</h4>

			<input type="text" size="50" name="transcript[linkOfPDF]" value="<?php echo $linkOfPDF; ?>">

		</div>



		<div class="misc-pub-section">

			<h4>Where To show</h4>

			<p>

				<input type="checkbox" name="transcript[whereToAdd_aboveVDO]" <?php if($whereToAdd_aboveVDO) echo 'checked'; ?>> Above<br/>

				<input type="checkbox" name="transcript[whereToAdd_underVDO]" <?php if($whereToAdd_underVDO) echo 'checked'; ?>> Bellow

			</p>

		</div>

			



	</div>

	<?php

}











add_action( 'save_post', 'transcripts_save_post' );

function transcripts_save_post( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )

		return;



	if ( ! empty( $_POST['transcripts'] ) && ! wp_verify_nonce( $_POST['transcripts'], 'transcripts' ) )

		return;

       

	if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) )

			return;

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) )

			return;

	}

	



	if ( ! empty( $_POST['transcript'] ) ) {

		$transcript_data['videoEmbedCode'] = ( empty( $_POST['transcript']['videoEmbedCode'] ) ) ? '' : $_POST['transcript']['videoEmbedCode'];

		$transcript_data['documentTitle'] = ( empty( $_POST['transcript']['documentTitle'] ) ) ? '' : $_POST['transcript']['documentTitle'];

		$transcript_data['linkOfPDF'] = ( empty( $_POST['transcript']['linkOfPDF'] ) ) ? '' : $_POST['transcript']['linkOfPDF'];

		$transcript_data['whereToAdd_aboveVDO'] = ( empty( $_POST['transcript']['whereToAdd_aboveVDO'] ) ) ? '' : $_POST['transcript']['whereToAdd_aboveVDO'];

		$transcript_data['whereToAdd_underVDO'] = ( empty( $_POST['transcript']['whereToAdd_underVDO'] ) ) ? '' : $_POST['transcript']['whereToAdd_underVDO'];

		

		update_post_meta( $post_id, '_transcript', $transcript_data );

	} else {

		delete_post_meta( $post_id, '_transcript' );

	}

}





//meta box









/* Display custom column */

function display_posts_shortcode( $column, $post_id ) {

    echo '[transcript id='.get_the_ID().']';

}

add_action( 'manage_posts_custom_column' , 'display_posts_shortcode', 10, 2 );



/* Add custom column to post list */

function add_shortcode_column( $columns ) {

    return array_merge( $columns, 

        array( 'Shortcode' => __( 'shortcode', 'your_text_domain' ) ) );

}

add_filter( 'manage_posts_columns' , 'add_shortcode_column' );





//creating the display

function get_transcript( $posts_per_page = 1, $orderby = 'none', $id = null ) {

    $args = array(

        'posts_per_page' => (int) $posts_per_page,

        'post_type' => 'transcripts',

        'orderby' => $orderby,

        'no_found_rows' => true,

    );

    if ( $id )

        $args['post__in'] = array( $id );

 

    $query = new WP_Query( $args  );

 

    $transcripts = '';

    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) : $query->the_post();

            $post_id = get_the_ID();

            $transcript_data = get_post_meta( $post_id, '_transcript', true );

			

			$videoEmbedCode = ( empty( $transcript_data['videoEmbedCode'] ) ) ? '' : $transcript_data['videoEmbedCode'];

			$documentTitle = ( empty( $transcript_data['documentTitle'] ) ) ? '' : $transcript_data['documentTitle'];

			$linkOfPDF = ( empty( $transcript_data['linkOfPDF'] ) ) ? '' : $transcript_data['linkOfPDF'];

			$whereToAdd_aboveVDO = ( empty( $transcript_data['whereToAdd_aboveVDO'] ) ) ? '' : $transcript_data['whereToAdd_aboveVDO'];

			$whereToAdd_underVDO = ( empty( $transcript_data['whereToAdd_underVDO'] ) ) ? '' : $transcript_data['whereToAdd_underVDO'];

			



			if($whereToAdd_aboveVDO=='on') $data  = '<a href="'.$linkOfPDF.'">'.$documentTitle.'</a>';

			

			$data .= '</br>'.$videoEmbedCode.'</br>';

			

			if($whereToAdd_underVDO=='on') $data .= '<a href="'.$linkOfPDF.'">'.$documentTitle.'</a>';

		

            $transcripts = $data;

 

        endwhile;

        wp_reset_postdata();

    }

 

    return $transcripts;

}





//adding shortcode to the theme



add_shortcode( 'transcript', 'transcript_shortcode' );



function transcript_shortcode( $atts ) {

    extract( shortcode_atts( array(

        'posts_per_page' => '1',

        'orderby' => 'none',

        'id' => '',

    ), $atts ) );

 

    return get_transcript( $posts_per_page, $orderby, $id );

}







//aside shortcode generator



add_action( 'add_meta_boxes', 'transcripts_add_custom_box' );





function transcripts_add_custom_box(){

	$id = 'transcript_shortcode';

	$title = 'Transcripts';

	$post_types = array( 'post', 'page' );

	$context = 'side';

	$priority = 'high';

	

	foreach ($post_types as $post_type) {

		add_meta_box( $id, $title, 'transcript_metabox_callback', $post_type, $context, $priority);

	}

}





function transcript_metabox_callback(){

	$transcripts = get_transcripts();

	echo '<select style="width:100%;" id="tech_transcripts" onchange="put_short_code(this)">';

	echo '<option value="">---SELECT---</option>';

	foreach( $transcripts as $transcript ):?>

		<option value="[transcript id=<?php echo $transcript->ID; ?>]"><?php echo $transcript->post_title; ?></option>

    <?php endforeach;?>

    </select>

    

    <script type="text/javascript">

    	function put_short_code(sel){

    		//alert("working");

    		var value = sel.options[sel.selectedIndex].value;

    		//insertAtCursor(document.post.content, value);

    		send_to_editor(value);

    		

    	}

    </script>	

    

<?php    

}







//getting all shortcodes

function get_transcripts() {

    $args = array(

	'posts_per_page'  => 999999999,

	'offset'          => 0,

	'category'        => '',

	'orderby'         => 'post_date',

	'order'           => 'DESC',

	'include'         => '',

	'exclude'         => '',

	'meta_key'        => '',

	'meta_value'      => '',

	'post_type'       => 'transcripts',

	'post_mime_type'  => '',

	'post_parent'     => '',

	'post_status'     => 'publish',

	'suppress_filters' => true ); 

	

	$posts_array = get_posts( $args );

		 

    return $posts_array;

}



function transcript_nav_inject() {

	

	global $typenow;

	

	if($typenow=='transcripts'):

	  $as_rp=as_ze::rp();

   

		

	  if($as_rp===true):

		echo '<script type="text/javascript">



        $("div#wpcontent > div#wpbody > div#wpbody-content > div.wrap > h2").prepend(\'<div id="as_ui_wrapper_transcript"><div class="as_ui_title">Accessibility Suite - Transcripts</div> <div id="as_ui_tabs" class="style-tabs"> <ul class="ui-tabs-nav"> <li id="li_contrast"> <a href="#contrast"> <div class="icon contrast-icon" id="as_contrast">Contrast Changer</div> </a> </li> <li id="li_fontchanger"> <a href="#font-changer"> <div class="icon font-changer-icon" id="as_fontchanger">Font Changer</div> </a> </li> <li id="li_skipnav"> <a href="#skip-nav"> <div class="icon skip-nav-icon" id="as_skipnav">Skip Navigation</div> </a> </li> <li id="li_textonly"> <a href="#text-only"> <div class="icon text-only-icon" id="as_textonly">Text Only</div> </a> </li> <li id="li_transcript"> <a href="#transcript"> <div class="icon transcript-icon" id="as_transcript">Transcripts</div> </a> </li> <li id="li_training"> <a href="#training"> <div class="icon training-icon" id="as_training">Training</div> </a> </li> <li id="li_recommendations"> <a href="#recommendations"> <div class="icon recommendations-icon" id="as_recommendations">Recommendations</div> </a> </li> <li id="li_license"> <a href="#licensing"> <div class="icon licensing-icon" id="as_license">Licensing</div> </a> </li> </ul> <div id="contrast"></div> <div id="font-changer"></div> <div id="skip-nav"></div> <div id="text-only"></div> <div id="transcript"></div> <div id="training"></div><div id="recommendations"></div> <div id="licensing"></div></div></div><br><br>\');






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

						

			$("#as_ui_tabs").tabs("option", "active", 4);

			$("#as_ui_wrapper_transcript").show();

						

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

            //unbind contrast tab for absolute link

            $("li#li_contrast a").unbind("click").each(function () {

                this.href = "admin.php?page=accessibilitysuite/modules/loader.php&aspv=cc";

            });

            //unbind fontchanger tab for absolute link

            $("li#li_fontchanger a").unbind("click").each(function () {

                this.href = "admin.php?page=accessibilitysuite/modules/loader.php&aspv=fc";

            });

            //unbind textonly tab for absolute link

            $("li#li_textonly a").unbind("click").each(function () {

                this.href = "admin.php?page=accessibilitysuite/modules/loader.php&aspv=to";

            });

            //unbind training tab for absolute link

            $("li#li_training a").unbind("click").each(function () {

                this.href = "admin.php?page=accessibilitysuite/modules/loader.php&aspv=tn";

            });

            //unbind recomm tab for absolute link

            $("li#li_recommendations a").unbind("click").each(function () {

                this.href = "admin.php?page=accessibilitysuite/modules/loader.php&aspv=rn";

            });

    </script>';

		endif;

	else:

		die();

	endif;

}

add_action( "admin_footer", 'transcript_nav_inject' );



?>