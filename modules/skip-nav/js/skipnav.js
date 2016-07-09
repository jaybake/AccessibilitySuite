jQuery(document).ready(function(){
var img_path = skiplinker.plugin_path;

var imglink = "<div style='display:inline-block;position:relative;z-index:333333;clear:none;'><a href='#skiptome' title='Skip Navigation'><img src='" + img_path + "' width=1 height=1 alt='Skip Navigation' /></a></div>";
var mylink = "<div style='display:inline-block;position:relative;z-index:333333;clear:none;'><a href='#skiptome' title='Skip Navigation'>Skip Navigation</a></div>";
var skiptolink = "<a name='skiptome'></a>";

// skipnav type value
var nav_type = skiplinker.linkopt;

if(nav_type === "image"){
	jQuery("body").prepend(imglink);
}else{
	jQuery("body").prepend(mylink);
}
jQuery(".skipnav").prepend(skiptolink);
});