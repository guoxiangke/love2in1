<?php
/**
 * resouce form 
 * http://portal.swtychina.com/web/guest/new
 * $keyword 
 */

function wx_swty_resource_response($wechatObj,$keyword) {
	$offset = 0;
	if(substr($keyword, 0,2) == 'ty' || substr($keyword, 0,4) == 'swty' || $keyword == '世外桃源') {
		if(strlen($keyword)>2) {
          $offset = substr($keyword, 2,1);
          if(!is_numeric($offset)) $offset = 0;
        }

        $url = 'http://swtychina.com/gb/portal/audio.aspx?category=swty';
        $html = file_get_html($url);
        $i = 0;
        $offset = 0;
		foreach($html->find('#GridView1 tr') as $tr) {

		    foreach($tr->find('td') as $td) {
		    	$i++;
		    	//uri
		    	if($i == ($offset+1)*5 + 3 ){
		    		// dpm($td->outertext);
		    		$url = $td->find('a',0)->href;
		    		$musicurl = 'http://swtychina.com/gb/'. str_replace('../', '', $url);
	    		    $live_radio = unserialize(drupal_http_request("http://yongbuzhixi.duapp.com/get_headers.php?url=$musicurl")->data);
	    		    
    				$musicurl = $live_radio['Location'];
		    		// ../audio/20140724/2363/download.aspx
		    		//http://swtychina.com/gb/audio/20140731/2369/download.aspx
				}
				//date
				if($i == ($offset+1)*5 + 1 ){
		    		$week_day = $td->plaintext;

				}
				//title
				if($i == ($offset+1)*5 + 5 ){
		    		// dpm($td->plaintext);
		    		$title = $td->plaintext;
        			$title = "【ty】".$title;
				}
		   	}
	}       
						watchdog('$musicurl', $musicurl, array(), WATCHDOG_NOTICE, 'link');
	        $desc = "公众号:永不止息 ".$week_day;
	        $hgmusicurl = $musicurl;
	        $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
	        exit;
        
	}
}

