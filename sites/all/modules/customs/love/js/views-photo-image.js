(function($){
Drupal.behaviors.PhotoAutoSubmit = {
  attach: function(context) {
    $('.hs-img a').each(function(){
    	$(this).attr('rel','lightbox');
       //$(this).addClass('highslide').attr("onclick","return hs.expand(this)");;
       // $(this).addClass('highslide').attr("onclick","return hs.expand(this,{wrapperClassName : 'highslide-white', spaceForCaption: 30,outlineType: 'rounded-white'})");
    }

  );
  }
}
})(jQuery);
