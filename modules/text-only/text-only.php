<?php

/* 
 * Shortcode Text Only Link/Button Hooks
 */
function as_text_only_shortcode()
{
    
    global $post;
    
    // set $_GET array, if set
    isset($_GET) ? $g = $_GET : $g = NULL;
    
    
    // show text only link if shortcode is set
    if ((has_shortcode($post->post_content, 'astextonly') && !$_GET['text-only'] == '1')):
    // if current url has a GET param attached, add it and append text only param to current url
        if ((strpos($_SERVER["REQUEST_URI"], "?") !== false) && (!empty($g))):
            echo '<div title="Text Only"  style="background-color:transparent;padding:3px;width:75px; padding-top:10px;padding-bottom:10px;""><a href="' . get_permalink() . '?' . http_build_query($g) . '&text-only=1">Text Only version</a></div>';
        // append text only param to current url
        else:
            echo '<div title="Text Only"  style="background-color:transparent;padding:3px; padding-top:10px;padding-bottom:10px;""><a href="' . get_permalink() . '?text-only=1">Text Only version</a></div>';
        endif;
    // show full site link if we're in text-only mode
    else:
        // remove text-only url param for full site link
        unset($g["text-only"]);
        
        
        // full site link position
        $s = 'position: relative; top:5px;left:0;clear:both;left:5px;';
        
        // build query params if set
        !empty($g) ? $n = '?' . http_build_query($g) : $n = NULL;
        
        // display link back to full site
        echo '<div style="' . $s . '; display:block; clear:both;"><a href="' . get_permalink() . $n . '">View Full Site</a></div><br><br>';
    endif;
}

add_shortcode('astextonly', 'as_text_only_shortcode');
/* _END_ Shortcode / "Text Only" Link/Button Hooks*/



/*
 * Generates Text Only Content to Wordpress 
 */
function generate_as_content()
{
    
    if (isset($_GET['text-only']) && $_GET['text-only'] == '1'):
        the_post();
        
        echo '<html><head><meta name="robots" value="noindex,nofollow" />';
        build_as_content();
        echo '</body></html>';
        die();
    endif;
}
add_action('wp', 'generate_as_content');
/* _END_ Generates Text Only Content to Wordpress */



/**
 * Ouput the content
 */
function build_as_content()
{
    // set post-page content
    $c = as_retrieve_post_content();
    // add hook
    $c = apply_filters('the_content', $c);
    
		// remove script, style, head, link, object tags before strip_tags (strip tags is missing some inline CSS)
    $c = cleanTags($c);
    
    // strip tags excluding h3,h4,h5,h6,b,br,p
    $c = strip_tags($c, '<h3><h4><h5><h6><b><br><p>');
    
    // post title
    $t  = '<b>' . single_post_title($prefix, $display) . '</b>'; //page title
    // page wrapper
    $wa = '</head><body><div style="width:80%;font-size:16px;">';
    $wa .= $t;
    
    // end wrapper
    $we = '</div>';
    
    // output the content
    echo $wa . $c . $we;
}
/* _END_ Ouput the content */


function cleanTags($c)
{
    $a = array(
        "'<script[^>]*?>.*?</script>'si",
        "'<style[^>]*?>.*?</style>'si",
        "'<head[^>]*?>.*?</head>'si",
        "'<link[^>]*?>.*?</link>'si",
        "'<object[^>]*?>.*?</object>'si"
    );
    $b = array(
        "",
        "",
        "",
        "",
        ""
    );
    return preg_replace($a, $b, $c);
}


/**
 * Get the post-page content
 */
function as_retrieve_post_content()
{
    global $id, $post, $page, $pages, $pagenow;
    
    
    if (post_password_required($post)):
        $op = get_the_password_form();
        return $op;
    endif;
    
    
    if ($page > count($pages))
        $page = count($pages);
    
    $c = $pages[$page - 1];
    
    $c = array(
        $c
    );
    
    $d = $c[0];
    
    $op .= $d;
    
    if (count($c) > 1):
        $op = force_balance_tags($op);
        $op = strip_tags($op);
    endif;
    
    $op = do_shortcode($op);
    
    return $op;
}
/* _END_ Get the post-page content */
?>