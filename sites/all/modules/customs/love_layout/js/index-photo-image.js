(function($){
/**
 * To make a form auto submit, all you have to do is 3 things:
 *
 * ctools_add_js('auto-submit');
 *
 * Currently only 'select', 'radio', 'checkbox' and 'textfield' types are supported. We probably
 * could use additional support for HTML5 input types.
 */

Drupal.behaviors.LoveInit = {
  attach: function(context) {
      $('.views-photos-image').imagesLoaded(function() {
        // Prepare layout options.
        var options = {
          itemWidth: 200, // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('.views-photos-image'), // Optional, used for some extra CSS styling
          offset: 5, // Optional, the distance between grid items
          flexibleWidth: 310 // Optional, the maximum width of a grid item
        };

        // Get a reference to your grid items.
        var handler = $('.views-photos-image li');

        // Call the layout function.
        handler.wookmark(options);
        // Init lightbox
        $('a', handler).colorbox({
          rel: 'lightbox',
          width:'800px',
          loop:false,
        });
      });
 
  }
}
})(jQuery);

   