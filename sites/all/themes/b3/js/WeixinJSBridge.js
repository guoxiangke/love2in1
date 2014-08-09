document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	// WeixinJSBridge.call('hideOptionMenu');
	(function ($){
		// $('body').append('<a href="weixin://contacts/profile/gh_b945c807e7ec" title="关注微信" style="position: fixed;bottom: 0px;right: 0px;">关注<br/><img src="http://wx.dev.camplus.hk/sites/default/files/styles/user_profile_sc_100/public/pictures/picture-172-1356487827.jpg" class="img-circle" style="width:50px;"/></a>');

		$('.wx-id-replace').each(function(){
			wxid = $(this).attr('data-mpid');
			$(this).attr('href','weixin://contacts/profile/'+wxid);
		});

	}(jQuery));
});