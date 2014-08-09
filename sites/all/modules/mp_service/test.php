<?php
/**
 * 微信扩展接口测试
 */
	include("wechatext.class.php");
	
	function logdebug($text){
		file_put_contents('data/log.txt',$text."\n",FILE_APPEND);		
	};
	
  $options = array(
    'account'=>'love_yongbuzhixi',
    'password'=>'mjk5nj',
    'datapath'=>'./data/cookie_' ,
      'debug'=>FALSE,
      'logcallback'=>'logdebug' 
  );
	$wechat = new Wechatext($options);
	if ($wechat->checkValid()) {
		// 获取用户信息
		$data = $wechat->getInfo('3773415');
		unset($data['groups']);
		var_dump($data);
		echo '<br/>';
		// 获取最新一条消息
        $topmsg = $wechat->getTopMsg();
        var_dump($topmsg);
        // 主动回复消息
        // if ($topmsg && $topmsg['has_reply']==0)
        // $wechat->send('1622296600','hi~'); 
	} else {
		echo "login error";
	}