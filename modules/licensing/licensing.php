<?php

$license_key = trim( get_option( 'license_key' ) );


// updater
$edd_updater = new Accessibility_Suite_Licensing( L_U, __FILE__, array(
		'version' 	=> AS_VERSION,
		'license' 	=> $license_key,
		'item_name' => PRODUCT_N,
		'author' 	=> AS_AUTHOR
	)
);

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

// data to send in our API request
$api_params = array(
	'edd_action' => 'deactivate_license',
	'license'    => trim( $_POST['license_key'] ),
	'item_name'  => urlencode( PRODUCT_N ) // the name of our product in EDD
);

// Send the remote request
$response = wp_remote_get( add_query_arg( $api_params, L_U ), array( 'timeout' => 15, 'sslverify' => false ) );

	}


function license_page() {
	$license 	= get_option( 'license_key' );
	$status 	= get_option( 'license_status' );
	//$as_rp=as_ze::rp();
	?>

<div id="as_ui_wrapper">
    <div class="as_ui_title">Accessibility Suite</div>
    <div id="as_ui_tabs" class="style-tabs">
        <?php require_once(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/tab_nav.inc'); ?>
        <div id="contrast"><?php trailingslashit(require_once(realpath(dirname(__FILE__)).'/../../') . '/inc/contrast.inc');?> </div>
        <div id="font-changer"><?php require_once(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/fontchanger.inc'); ?></div>
        <div id="skip-nav"></div>
        <div id="text-only"><?php require_once(trailingslashit(realpath(dirname(__FILE__)).'/../../') . '/inc/textonly.inc'); ?></div>
        <div id="transcript"></div>

        <div id="licensing">
	<div class="as_ui_tab_content">
    <h2>Active your Accessibility Suite License to access all features</h2>

		<form method="post" action="options.php">

			<?php settings_fields('license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>

							<input id="license_key" name="license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="license_key">
                  <?php
		  if(!empty($license) && $status == false || $status == 'invalid'):
			  echo '<div style="display:inline;color:red;">Invalid License Key</div>';
			elseif($status == 'valid'):
			  echo '<div style="display:inline;color:green;">Valid License Key</div>';
			else:
			   _e('Enter your license key');
			endif;
			?>
              </label>
						</td>
					</tr>
					<?php if($license !== false && strlen($license) > 10) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>

								<?php if(!empty($license) && $status == 'valid' ) {  ?>

									<?php wp_nonce_field( 'nonce', 'nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'nonce', 'nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
			</div>

        </div>

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
						$("#as_ui_tabs").tabs("option", "active", 5);
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
						$as_rp=as_ze::rp();
						/* if($as_rp!==true):
               echo '
						   $( "#as_ui_tabs").tabs( "disable", 0);
               $( "#as_ui_tabs").tabs( "disable", 1);
               $( "#as_ui_tabs").tabs( "disable", 4);
						   ';
						endif;*/
						?>
        });
    });
</script>

	<?php
}




function reg_op() {
	// creates our settings in the options table
	register_setting('license', 'license_key', 'sanitize_license' );
}
add_action('admin_init', 'reg_op');

function sanitize_license( $new ) {
	$old = get_option( 'license_key' );
	if( $old && $old != $new ) {
		delete_option( 'license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

//do not remove
$X= 'LyogLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCgkJCQkJCUF1dGhvcjogICAgIEFiZHVsIFJhaG1hbiBTaGVyemFkICh3d3cuYWZnaGFuY3liZXJzb2Z0LmNvbSkKCQkJCQkJRW1haWw6CQlpbmZvQGFmZ2hhbmN5YmVyc29mdC5jb20KCQkJCQkJQmlvZ3JhcGh5OglBYmR1bCBSYWhtYW4gU2hlcnphZCB3YXMgYm9ybiBhbmQgYnJvdWdodCB1cCBpbiBIZXJhdC1BZmdoYW5pc3RhbiBhbmQgY29tcGxldGVkIG15IHVuZGVyLWdyYWR1YXRlIHN0dWRpZXMgaW4gQ29tcHV0ZXIgU2NpZW5jZSBGYWN1bHR5IG9mIEhlcmF0IFVuaXZlcnNpdHkgaW4gMjAwNiBvYnRhaW5pbmcgbXkgQi5DLlMgZGVncmVlIGFzIHRoZSBiZXN0IG91dGdvaW5nIHNlbmlvciBzdHVkZW50IGZyb20gdGhpcyBmYWN1bHR5LgoKCQkJCQkJCQkJSGF2aW5nIGludGVsbGVjdHVhbGl0eSBpbiBDb21wdXRlciBQcm9ncmFtbWluZyBhbmQgSW5mb3JtYXRpb24gRGF0YWJhc2UgTWFuYWdlbWVudCBTeXN0ZW0sIEkgd2FzIG9mZmVyZWQgdG8gY29tbWVuY2UgdGVhY2hpbmcgaW4gQ29tcHV0ZXIgU2NpZW5jZSBGYWN1bHR5IG9mIEhlcmF0IFVuaXZlcnNpdHkuIEFmdGVyIGEgd2hpbGUgSSBqb2luZWQgQ1JTIHRvIHdvcmsgYXMgdGhlIERhdGFiYXNlIE1hbmFnZXIgZm9yIHRoZSBBREEgcHJvZ3JhbS4gSSB3b3JrZWQgZm9yIENSUyBmb3IgYSBjb3VwbGUgb2YgeWVhcnMgYWZ0ZXIgd2hpY2ggSSB3YXMgYXdhcmRlZCBhIHNjaG9sYXJzaGlwIGJ5IHRoZSBnb3Zlcm5tZW50IG9mIEdlcm1hbnkgdG8gcHVyc3VlIG15IE1hc3RlciBpbiBJbmZvcm1hdGlvbiBEYXRhYmFzZSBNYW5hZ2VtZW50IGFuZCBTb2Z0d2FyZSBFbmdpbmVlcmluZyBpbiBCZXJsaW4gYXQgVFUtQmVybGluIFVuaXZlcnNpdHkuCgoJCQkJCQkJCQlJIGFtIGN1cnJlbnRseSBhbHNvIHRlYWNoaW5nIGF0IHRoZSBIZXJhdCBVbml2ZXJzaXR5IGFzIHdlbGwgYXMgYWN0aW5nIGFzIHRoZSBoZWFkIG9mIEluZm9ybWF0aW9uIFN5c3RlbXMgTWFuYWdlciBib3RoIGluIENSUyBhbmQgSGVyYXQgVW5pdmVyc2l0eSB0byBzdXBwb3J0IHRoZSBlZHVjYXRpb25hbCBuZWVkcy4KCQkJCQkJCQktLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi8=';

include_once('licensing.inc');




function activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {


	 	if( ! check_admin_referer( 'nonce', 'nonce' ) )
			return;

		$license = trim( get_option( 'license_key' ) );


		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( PRODUCT_N )
		);

		$response = wp_remote_get( add_query_arg( $api_params, L_U ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );


		update_option( 'license_status', $license_data->license );

	}
}
add_action('admin_init', 'activate_license');




function deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

	 	if( ! check_admin_referer( 'nonce', 'nonce' ) )
			return;


		$license = trim( get_option( 'license_key' ) );

		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( PRODUCT_N )
		);


		$response = wp_remote_get( add_query_arg( $api_params, L_U ), array( 'timeout' => 15, 'sslverify' => false ) );


		if ( is_wp_error( $response ) )
			return false;


		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if( $license_data->license == 'deactivated' )
			delete_option( 'license_status' );

	}
}
add_action('admin_init', 'deactivate_license');



function check_license() {

	global $wp_version;

	$license = trim( get_option( 'license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( PRODUCT_N )
	);

	$response = wp_remote_get( add_query_arg( $api_params, L_U ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
	} else {
		echo 'invalid'; exit;
	}
}
if(!isset($_POST)) {
// if license was saved, try to activate it..
if($_GET['page']=='accessibility-suite-license' && $_GET['settings-updated']=='true'):


		$license = trim( get_option( 'license_key' ) );


		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( PRODUCT_N )
		);

		$response = wp_remote_get( add_query_arg( $api_params, L_U ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );


		update_option( 'license_status', $license_data->license );


endif;
}
