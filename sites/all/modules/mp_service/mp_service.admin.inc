<?php
function mp_service_settings_form($form, &$form_state) {
	global $user;
	// variable_del('mp_service_'.$user->uid);
	$default_value = variable_get('mp_service_'.$user->uid,NULL);
	if ($default_value) {
		$default_value = explode('/', $default_value);
		unset($default_value[2]);
		unset($default_value[3]);
		$default_value = implode($default_value, '/');
	}else{
		$default_value = $user->uid.'/gh_b945XXXXX7ec';
	}

	$form['mp_service_'.$user->uid] = array(
		'#type' => 'textfield', 
	  // '#title' => t('Token'), 
	  '#default_value' => variable_get('mp_service_'.$user->uid, $user->uid.'/gh_b945XXXXX7ec/login_name/password'), 
	  //http://wx.dev.camplus.hk/mp_services/
	  '#prefix' => '<b>Url:</b>'.url(NULL, array('absolute' => TRUE)) . (variable_get('clean_url', 0) ? '' : '?q=').'mp_services/'.$default_value,
	  '#size' => 60, 
	  '#maxlength' => 128, 
	  '#required' => TRUE,
	);
	return system_settings_form($form);
}