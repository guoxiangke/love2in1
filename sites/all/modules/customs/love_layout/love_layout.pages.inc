<?php

function love_anonymous_welcome() {
  return '123';
}

//page of my focus of current user...
function love_layout_my_focus() {
	// global $user;
	// $urs = user_relationships_load(array('rtid' => array(1),'requester_id' => array($user->uid)));
	// $output = '123456';
	// dpm($urs);
	// foreach ($urs as $rid => $value) {
	// 	$focus_uid = $value->requestee_id;
	// 	$account = user_load($focus_uid);
	// 	if($account)
	// 	$output .= '<div>'.$account->name.'</div>';
	// }
	return '';
}
