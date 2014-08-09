<?php
/**
 * 微信扩展接口测试
 */
	include("wechatext.class.php");
	
	function logdebug($text){
		file_put_contents('data/log.txt',$text."\n",FILE_APPEND);		
	};
	
	// $options = array(
	// 	'account'=>'',
	// 	'password'=>'',
	// 	'datapath'=>'./data/cookie_' ,
	// 		'debug'=>FALSE,
	// 		'logcallback'=>'logdebug'	
	// ); 

	// $wechat = new Wechatext($options);
	// if ($wechat->checkValid()) {
	// 	// 获取用户信息
	// 	$data = $wechat->getInfo('3773415');
	// 	var_dump($data);
		
	// 	$getMsg = $wechat->getMsg($lastid=0,$offset=0,$perpage=5,$day=0,$today=0,$star=0) ;//($lastid='');
	// 		echo "<br/>";
	// 	var_dump($getMsg);

	// 	foreach ($getMsg as $key => $Msg) {
	// 		if($Msg['content'] == '小永还在努力学习中') {
	// 			echo "<br/>";
	// 			$fakeId = $Msg['fakeid'];
	// 			$data = $wechat->getInfo($fakeId);
	// 			$wechat_name = $data['Username'];
	// 			$wechat_nickname = $data['NickName'];
	// 			$wechat_Signature = $data['Signature'];
	// 			$wechat_Country = $data['Country'];
	// 			$wechat_Province = $data['Province'];
	// 			$wechat_City = $data['City'];
	// 			$wechat_Sex = $data['Sex'];
				
				
	// 			var_dump($wechat_name);
	// 			var_dump($wechat_nickname);
	// 		}
	// 	}
		
	// 	// 获取最新一条消息
	// 	$topmsg = $wechat->getTopMsg();
	// 	// var_dump($topmsg);
	// 	// 主动回复消息
	// 	// if ($topmsg && $topmsg['hasReply']==0)
	// 	// $wechat->send($topmsg['fakeId'],'hi '.$topmsg['nickName'].',rev:'.$topmsg['content']);	
	// } else {
	// 	echo "login error";
	// }