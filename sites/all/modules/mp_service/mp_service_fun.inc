<?php



function _mp_node_create($keyword, $nodetype = 'love_diary', $uid = 1) {
  $title = truncate_utf8($keyword, 15, $wordsafe = FALSE, $add_ellipsis = FALSE, $min_wordsafe_length = 1);

  $node = new stdClass();
  $node->title = $title;
  $node->type = $nodetype;
  node_object_prepare($node); // Sets some defaults. Invokes hook_prepare() and hook_node_prepare().
  $node->language = LANGUAGE_NONE; // Or e.g. 'en' if locale is enabled
  $node->uid = $uid;
  $node->status = 1; //(1 or 0): published or not
  $node->promote = 0; //(1 or 0): promoted to front page
  $node->comment = 0; // 0 = comments disabled, 1 = read only, 2 = read/write
  $node->path['pathauto'] = false;
  $node->body[$node->language][0]['value']   = $keyword.'<div class="love-source"><span class="ll-date-details">'.date('l H:i').'</span> 【微信发布】</div>';
  // $node->body[$node->language][0]['summary'] = text_summary($keyword);
  $node->body[$node->language][0]['format']  = 'full_html';
  if($nodetype == 'love_diary') {
    $last_diary = db_query("SELECT node.created AS node_created, node.nid AS nid
FROM 
{node} node
WHERE (( (node.status = '1') AND (node.type IN  ('love_diary')) ))
ORDER BY node_created DESC
LIMIT 10 OFFSET 0")->fetchAssoc();
    if(date('Y-m-d', $last_diary['node_created']) == date('Y-m-d', strtotime('now'))) {
      $node = node_load($last_diary['nid']);
      $node->title = date('n月j日');
      $node->body[$node->language][0]['value']   .= '<div class="ll-diary-added"><br/></div>'.$keyword.'<div class="love-source"><span class="ll-date-details">'.date('l H:i').'</span> 【微信发布】</div>';
    }
    node_save($node);//\n".$tip."
    return $contentStr = "恭喜您【".$node->title."】\n日志更新成功，http://wx.dev.camplus.hk/node/$node->nid";

    $node->field_date[LANGUAGE_NONE][0]['value'] =  date('Y-m-d H:i:s', strtotime('now'));
  }

  // 【201】无主情话(随便说点情话)-38
  // 【202】时光隧道(分享我的过去)-39
  // 【203】独居生活(记录现在的生活)-40
  // 【204】想对你说(写给喜欢的人)-41

  // $node->field_status_topic[$node->language][0]['tid'] = $menukey-163;
  ////////begin @see love_layout_node_presave($node)
   // $pattern = '/#([^\\#|.]+)#|＃([^\\＃|.]+)＃/';
   // preg_match_all($pattern, $node->title, $matches, PREG_SET_ORDER);
   // $node->field_status_tags[LANGUAGE_NONE] = array();
   // foreach ($matches as $key => $value) {

   //    $term_name = $value[1];
   //    $term = taxonomy_get_term_by_name($term_name);
   //    //new one
   //    if(!count($term)){
   //     $term = new stdClass();
   //     $term->vid = 1;
   //     $term->name = $term_name;
   //     taxonomy_term_save($term);
   //     //$term = taxonomy_get_term_by_name($term_name);
   //     foreach ($term as $value) {
   //        //dpm($value,$key);
   //        $node->field_status_tags[LANGUAGE_NONE][$term->tid]['tid'] = $term->tid;
   //      }
   //    }else{
   //      foreach ($term as $tid => $value) {
   //        // dpm($value,$tid);
   //        $node->field_status_tags[LANGUAGE_NONE][$tid]['tid'] = $tid;
   //      }
   //    }
   // }
  ///////////end
  if($node = node_submit($node)) { // Prepare node for saving
      node_save($node);//\n".$tip."
      $contentStr = "恭喜您【".$keyword."】\n发布成功，http://wx.dev.camplus.hk/node/$node->nid";
  }
  return $contentStr;
}


function _mp_get_mp_node($type = 'grace365', $counts = 1) {
  
  $query = db_select('node', 'n');
  $query->fields('n', array('nid'));
  $query->condition('n.status', 1,'=');
  $query->condition('n.type', $type,'=');
  $query->orderBy('n.created', 'DESC');
  $query->range(0, $counts);
  $results = $query->execute()->fetchAll();

  $default_image = ybzx_get_default_image_field_value($type, $field_name = 'field_image', $type = 'default_image', $entity_type = 'node');
  $second_image = 'http://wx.dev.camplus.hk/sites/default/files/pictures/picture-172-1356487827.jpg';

  if(count($results))
    foreach ($results as $key => $value) {
      $node = node_load($value->nid);

      $des = decode_entities(check_markup($node->body[LANGUAGE_NONE][0]['value']));
      $des = strip_tags($des);
      $des = str_replace('&nbsp;&nbsp;',"\n",$des);
      $des = str_replace('&nbsp;',' ',$des);
      $des = truncate_utf8($des, 300, $wordsafe = FALSE, $add_ellipsis = TRUE, $min_wordsafe_length = 1);

      if($node->field_image) {
        $default_uri = $node->field_image[LANGUAGE_NONE][0]['uri'];
        $default_image = file_create_url($default_uri);
      }
      $img = array(
          'Title'=> $node->title,
          'Description'=>$des,
          'PicUrl'=>$default_image,
          'Url'=> url(NULL, array('absolute' => TRUE)) . (variable_get('clean_url', 0) ? '' : '?q=').'node/'.$node->nid,
        );
      $news[] = $img;
      return $news;
    }
}


function _mp_provide($keyword) {
  // switch ($keyword) {
    
  //       case '1224':
  //         $title = '耶稣全貌';
  //         $desc = '序言-公众号:永不止息，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-00.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122501':
  //         $title = '耶稣全貌-第一章 道成肉身';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-01.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122502':
  //         $title = '耶稣全貌-第二章 圣婴降生';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-02.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122503':
  //         $title = '耶稣全貌-第三章 预备道路';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-03.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122504':
  //         $title = '耶稣全貌--第四章 传道之始';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-04.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122505':
  //         $title = '耶稣全貌--第五章 知难而进';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-05.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122506':
  //         $title = '耶稣全貌--第六章 登山宝训';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-06.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122507':
  //         $title = '耶稣全貌--第七章  是非分明';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-07.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122508':
  //         $title = '耶稣全貌--第八章  命令风浪';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-08.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122509':
  //         $title = '耶稣全貌--第九章  五饼二鱼';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-09.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122510':
  //         $title = '耶稣全貌--第十章  荣耀显现';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-10.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122511':
  //         $title = '耶稣全貌--第11章';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-11.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '122512':
  //         $title = '耶稣全貌--第12章';
  //         $desc = '公众号:永不止息 ，每日更新';
  //         $musicurl = 'http://s3.amazonaws.com/ysqm/ch-12.mp3';
  //         $hgmusicurl = $musicurl;
  //         $wechatObj->music($title, $desc, $musicurl, $hgmusicurl)->reply();
  //         break;
  //       case '1225':
  //             $img = array(
  //                 'Title'=> '良友串流广播【试听】',
  //                 'Description'=>'点击查看全文收听！回复【11+您的建议反馈内容】，回复1225给love_yongbuzhixi获取本消息！永不止息，需要有你！',
  //                 'PicUrl'=>'http://farm2.staticflickr.com/1275/4700591844_7010757842_b.jpg',
  //                 'Url'=>'http://stream.liangyou.net/channel/65837e3587'
  //               );
  //               $news[] = $img; 
  //           $wechatObj->news($news)->reply();
  //            break;
  //   default:
  //     # code...
  //     break;
  // }
  
        // case '114':
        // case '40':
        //   // $contentStr =  "必须回复911+至少一句感恩的话(5个字)\n才可以得到今天的炼爱哦！\n回复【5】进入良友广播";
        //   $img = array(
        //       'Title'=> '第18天 爱寻求理解',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/18'
        //     );
        //   $news[] = $img;
        //   $img = array(
        //       'Title'=> '第17天 爱提升亲密',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/17'
        //     );
        //   $news[] = $img;
        //   $img = array(
        //       'Title'=> '第16天 爱是为他祷告',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/16'
        //     );
        //   $news[] = $img;
        //   $img = array(
        //       'Title'=> '第15天 爱是敬重对方',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/15'
        //     );
        //   $news[] = $img;
        //   $img = array(
        //       'Title'=> '第14天 爱是公平地争吵',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/14'
        //     );
        //   $news[] = $img;
        //   $img = array(
        //       'Title'=> '第13天 爱是公平地争吵',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/13'
        //     );
        //   // $news[] = $img;
        //   // $contentStr =  "必须回复911+至少一句感恩的话(5个字)\n才可以得到今天的炼爱哦！\n回复【5】进入良友广播";
        //   $img = array(
        //       'Title'=> '第12天 爱是谦让',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/12'
        //     );
        //   // $news[] = $img;
        //    $img = array(
        //       'Title'=> '第11天 爱是珍惜',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/11'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第10天 爱是无条件的',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/10'
        //     );
        //   // $news[] = $img;
        //    $img = array(
        //       'Title'=> '第9天 爱是制造好印象',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/09'
        //     );
        //   // $news[] = $img;
        //    $img = array(
        //       'Title'=> '第8天 爱是不嫉妒',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/08'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第7天 爱相信最美好的',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/07'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第6天 爱是不轻易动怒',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/06'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第5天 爱是不粗鲁',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/05'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第4天 爱是恩慈',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/04'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第3天 爱是不自私',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/03'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第2天 爱是恩慈',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/02'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '第1天 爱是恒久忍耐',
        //       'Description'=>'',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/love40/01'
        //     );
        //   // $news[] = $img;
        //   $img = array(
        //       'Title'=> '《炼爱》序言-我们的心灵渴望爱，就象我们的身体需要氧气',
        //       'PicUrl'=>'http://love.yongbuzhixi.org/sites/default/files/love40/s4568837.jpg',
        //       'Url'=>'http://love.yongbuzhixi.org/node/15'
        //     );
        //     $news[] = $img;  

        //   // $img = array(
        //   //   'Title'=>'用手机，登录【永不止息】^_^',
        //   //   'Description'=>'单图文 标题15字 摘要60字',
        //   //   'PicUrl'=>'http://www.yongbuzhixi.com/sites/default/files/pictures/picture-172-1356487827.jpg',
        //   //   'Url'=>'http://yongbuzhixi.com'
        //   // );
        //   //单图文 标题15字 摘要60字
        //   //多图文 1标题16字 2标题15字
        //   $wechatObj->news($news)->reply();
        //   break;
}