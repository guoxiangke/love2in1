	
(function($) {

/**
 * Live preview of Administration menu components.
 */
Drupal.behaviors.tiger = {
  attach: function (context, settings) {

    $('#user-profile-form .user-picture a').click(function(){
        $('#edit-picture-upload').click();
        return false;
      });

    $('#user-register-form .form-type-textfield .description').hide();
    $('#user-register-form .form-type-textfield ').click(function(){
      $(this).children('.description').show();
    });
    $('#user-register-form .form-type-textfield input').blur(function(){
      var warning_str = '必须填写'+$(this).prev('label').text().replace('*','');
      if($(this).val() == '' && $(this).hasClass('required')) {
        $(this).parent('.form-type-textfield').children('.description').wrap('<span class="register_error"/>').text(warning_str);
      }else{
        $(this).parent('.form-type-textfield').children('.description').hide();
      };
    });

    $('#user-register-form .form-type-password input').blur(function(){
      var warning_str = '必须填写'+$(this).prev('label').text().replace('*','');
      if($(this).val() == '' && $(this).hasClass('required')) {
        //<span class="register_error"><div class="description" style="display: block;">必须填写邮箱 </div></span>
        if($(this).parent('.form-type-password').find('.description').length == 0) {
          $(this).parent('.form-type-password').wrap('<span class="register_error"/>').append('<div class="description" style="display: block;">'+warning_str+'</div>');
        }
        $(this).parent('.form-type-password').children('.register_error').show();
      }else{
        $(this).parent('.form-type-password').children('.register_error').hide();
      };
    });

    $('#user-register-form input').blur(function(){
      if(!($(this).val() == '')) {
        $(this).parent('.form-item').children('.register_error').hide();
        $(this).parent('.form-item').children('.description').hide();
      }else {
        $(this).parent('.form-item').children('.register_error').show();
        $(this).parent('.form-item').children('.description').show();
      }
    });

    $('#user-register-form .form-item-pass .description').hide();
    $('#user-register-form .password-field').blur(function(){
      $('#user-register-form .password-suggestions').hide();
    });

    //username min length 2
    //email

    $('#user-register-form .form-item-mail input').blur(function(){
      if(!($(this).val() == '')) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test($(this).val())) {
          $(this).parent('.form-item').find('.description').addClass('error_message').html('邮箱格式不正确');
          $(this).parent('.form-item').find('.description').show();
        }
      }
    });

    $('#user-register-form input.username').blur(function(){
      if($(this).val() != '' && $(this).val().length<2) {
        $(this).parent('.form-item').find('.description').addClass('error_message').html('用户名至少2个字符');
        $(this).parent('.form-item').find('.description').show();
      }
    });
    //form behaviors
    $('form .form-submit').click(function(e){
      $('input.required').each(function(){
        if($(this).val()==''){
          $(this).focus();
          e.preventDefault()
          return false;
        }
      });
    });

    //go to top
		$("body").append("<a href='#' id='sbq_gototop'></a>");

		$(function() {
			//F5
			if ($(window).scrollTop() > 100) {
				$("#sbq_gototop").show();
			} else {
				$("#sbq_gototop").hide();
			}
			//scroll show hide
			$(window).scroll(function() {
				if ($(window).scrollTop() > 100) {
					$("#sbq_gototop").fadeIn(100);
				} else {
					$("#sbq_gototop").fadeOut(50);
				}
			});
			//btn
			$("#sbq_gototop").click(function() {
				$('body,html').animate({
					scrollTop : 0
				}, 500);
				return false;
			});
		});


  }
};


})(jQuery);