jQuery(document).ready(function(){
  
  var originalfontcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color');
  var originalbgcolor = $(".asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li").css('background');
    $(".resetme").click(function(){
      $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color', '');
      $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background', '');
  });


  $(".yob").click(function(){
      var currentfontcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color');
      var currentbgcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background');
      var newbgcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color', '#FFFF00');
      var newfontcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background', '#000000');
      $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color', newfontcolor);
      $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background', newbgcolor);
      return false;
  });
  

  $(".wob").click(function(){

      var currentfontcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color');
      var currentbgcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background');
      var newbgcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color', '#FFFFFF');
      var newfontcolor = $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background', '#000000');
      $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('color', newfontcolor);
      $('.asContrastChanged, #sidebar, h1, h2, h3, h4, h5, h6, blockquote, div, p, ul, ol, li').css('background', newbgcolor);
      return false;
  });
  
});