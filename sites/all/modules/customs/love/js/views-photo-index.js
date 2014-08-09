(function($){
	// $(document).bind("contextmenu",function(e){return false; });
Drupal.behaviors.PhotoAutoSubmit = {
  attach: function(context) {
    $('.t-field_photo a').each(function(){
    	// $(document).bind("contextmenu",function(e){return false; });
       //$(this).addClass('highslide').attr("onclick","return hs.expand(this)");;
       $(this).addClass('highslide').attr("onclick","return hs.expand(this,{wrapperClassName : 'highslide-white', spaceForCaption: 30,outlineType: 'rounded-white'})");
    }

  );
  }
}
})(jQuery);
