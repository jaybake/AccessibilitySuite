jQuery(document).ready(function($){
      // Resets text Size
  var originalSize = $('.asFontChanged').css('font-size');
    $(".resetfontchanger").click(function(){
      $('.asFontChanged').css('font-size', originalSize);
  });
  
      // Increases text size
  $(".increase").click(function(){
      var currentSize = $('.asFontChanged').css('font-size');
      var csNum = parseFloat(currentSize);
      var newSize = csNum+1;
      $('.asFontChanged').css('font-size', newSize);
      return false;
  });
  
        // Decreases text size
  $(".decrease").click(function(){
      var currentSize = $('.asFontChanged').css('font-size');
      var csNum = parseFloat(currentSize);
      var newSize = csNum-1;
      $('.asFontChanged').css('font-size', newSize);
      return false;
  });
  
});