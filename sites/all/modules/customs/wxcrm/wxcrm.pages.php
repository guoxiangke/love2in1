<?php
/**
 * wxcrm_response
 */
function wxcrm_response($uid,$AppID){
	$wxcrm_appid = variable_get('wxcrm_appid_'.$uid,NULL);
  if($wxcrm_appid !== $AppID) {
  	return 'error';
  	exit;
  }
  $weObj = _wechatObj_init($uid,$AppID);
  $weObj->valid();
  $type = $weObj->getRev()->getRevType();
  // module_invoke_all('wxcrm_message', $weObj);
  // module_invoke_all('wxcrm_message_alter', $weObj);
  if(!is_array($weObj->Message(''))){ // add default option
    $type = $weObj->getRev()->getRevType();
    switch($type) {
  	  case Wechat::MSGTYPE_EVENT:
  	    $event = $weObj->getRevEvent();
        if(!$event){
          break;
        }
  	    else if($event['event']=='subscribe'){
  	      $weObj->text(variable_get("wechat_follow_message", variable_get("wechat_default_message", 'Hi, WeChat!')));
  	    }
        else if($event['event']=='CLICK'){
          $message = _wechat_menu_default_message($event);
          $message && $weObj->text($message);
        }
  		  break;
    }
  }
  if(!is_array($weObj->Message(''))){
  	$musicurl ='http://fm77.u.qiniudn.com/xiaomin/mama20140503.mp3';
    $desc = "公众号:永不止息";
    $weObj->music('小敏诗歌分享：我有一个好妈妈', $desc, $musicurl);
    $news[] = array(
              'Title'=> '玩转永不止息,良友一起来！',
              'Description'=>'永不止息时光机，会员尊贵待遇！',
              'PicUrl'=>'http://mmsns.qpic.cn/mmsns/0fV5QBhibUJh4BDj8puTVpBPibdMnlp7YYX5ibib87W7KACey1qpTmN0Rw/0.jpg',
              'Url'=>'http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5ODQ4NjU4MA==&appmsgid=10000352&itemidx=1&sign=f99612d4cfd626d8649dbe6a59faff75#wechat_redirect'
            );
    $weObj->news($news); 
    $weObj->text("开发测试中，请搜索关注：永不止息-主内婚恋网 微信号 <a href='weixin://contacts/profile/love_yongbuzhixi'>love_yongbuzhixi</a>. [微笑]");
  }
  $weObj->reply();
  exit;
}

/**
 * User config for wxcrm
 */
function wxcrm_settings_form($form, &$form_state) {
	global $user;
	// variable_del('mp_service_'.$user->uid);
	//'#prefix' => '<b>Your Url is:</b>'.url(NULL, array('absolute' => TRUE)) . (variable_get('clean_url', 0) ? '' : '?q=').'mp_services/'.$default_value,
	$form['wxcrm_information']['#markup'] = "欢迎使用微信CRM,您可以到微信公众平台-》开发者中心 获取下面的配置。\n";

	$wxcrm_appid = variable_get('wxcrm_appid_'.$user->uid, variable_get('wxcrm_appid_'.$user->uid,NULL));
	if($wxcrm_appid){
		$form['wxcrm_information']['#markup'] = "您的URL(服务器地址)为： ".url(NULL, array('absolute' => TRUE)) . (variable_get('clean_url', 0) ? '' : '?q=').'wxcrm/'.$user->uid.'/'.$wxcrm_appid;
	}

	$form['wxcrm_token_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('Token'), //填写你设定的key
	  '#default_value' => variable_get('wxcrm_token_'.$user->uid, variable_get('wxcrm_token_'.$user->uid,NULL)),
	  '#description' =>'填写您在公众平台设置的Token',
	  '#size' => 60, 
	  '#maxlength' => 128, 
	  '#required' => TRUE,
	);
	$form['wxcrm_encode_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('EncodingAESKey'), //填写加密用的EncodingAESKey
	  '#default_value' => variable_get('wxcrm_encode_'.$user->uid, variable_get('wxcrm_encode_'.$user->uid,NULL)),
	  '#description' =>'填写您在公众平台设置的消息加密密钥',
	  '#size' => 60, 
	  '#maxlength' => 128, 
	  '#required' => TRUE,
	);
	////
	$form['wxcrm_appid_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('App ID'), //填写加密用的EncodingAESKey
	  '#default_value' => variable_get('wxcrm_appid_'.$user->uid, variable_get('wxcrm_appid_'.$user->uid,NULL)),
	  '#description' =>'填写您的公众号AppID(应用ID) 一般为gh_bxxx开头',
	  '#size' => 60, 
	  '#maxlength' => 128, 
	  '#required' => TRUE,
	);
	$form['wxcrm_appsecret_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('App Secret'), //填写高级调用功能的应用密钥
	  '#default_value' => variable_get('wxcrm_appsecret_'.$user->uid, variable_get('wxcrm_appsecret_'.$user->uid,NULL)),
	  '#description' =>'填写您的公众号的AppSecret(应用密钥)',
	  '#size' => 60, 
	  '#maxlength' => 128,
	  '#required' => TRUE,
	);

	$form['wxcrm_partnerid_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('partnerid'),
	  '#default_value' => variable_get('wxcrm_partnerid_'.$user->uid, variable_get('wxcrm_partnerid_'.$user->uid,NULL)),
	  '#description' =>'填写您的公众号的partnerid(财付通商户身份标识)',
	  '#size' => 60, 
	  '#maxlength' => 128,
	  '#attributes' => array('disabled' => 'disabled'),
	);

	$form['wxcrm_partnerkey_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('partnerkey'),
	  '#default_value' => variable_get('wxcrm_partnerkey_'.$user->uid, variable_get('wxcrm_partnerkey_'.$user->uid,NULL)),
	  '#description' =>'填写您的公众号的partnerkey(财付通商户权限密钥Key)',
	  '#size' => 60, 
	  '#maxlength' => 128,
	  '#attributes' => array('disabled' => 'disabled'),
	);

	$form['wxcrm_paysignkey_'.$user->uid] = array(
		'#type' => 'textfield', 
	  '#title' => t('Token'),
	  '#default_value' => variable_get('wxcrm_appsecret_'.$user->uid, variable_get('wxcrm_paysignkey_'.$user->uid,NULL)),
	  '#description' =>'填写您的公众号的paysignkey(商户签名密钥Key)',
	  '#size' => 60, 
	  '#maxlength' => 128, 
	  '#attributes' => array('disabled' => 'disabled'),
	);
	return system_settings_form($form);
}