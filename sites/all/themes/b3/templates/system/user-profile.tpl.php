<?php

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */
global $user;
if(arg(0) == 'user'){
  $account = user_load(arg(1));
  $account = $account->uid?$account:$user;
}else {
  $account = $user;
}
$account = $account->uid?$account:$user;
$profile= profile2_load_by_user($account, $type_name = NULL);
// dpm($profile);
$real_name = isset($profile['main']->field_name[LANGUAGE_NONE][0]['value'])?$profile['main']->field_name[LANGUAGE_NONE][0]['value']:$account->name;
$sex = $profile['main']->field_sex[LANGUAGE_NONE][0]['value']?'男':'女';
$field_birthday = $profile['main']->field_birthday[LANGUAGE_NONE][0]['value'];

$field_birthday_temp = field_get_items('user', $account, 'field_birthday');

if($field_birthday_temp){
	$field_birthday = $field_birthday_temp;
}
$field_birthday = strtotime($field_birthday);
$age = date('Y')-date('Y',$field_birthday);
$marriage_status = array(
	'1'=>'单身求交往',
	'0'=>'交往中，暂停征友',
	'-6'=>'郁闷中，暂停征友',
	'-1'=>'感谢主，关系确立',
	'-2'=>'已订婚',
	'-3'=>'已婚',
	'-4'=>'丧偶',
	'-5'=>'离异',
	);
$field_marriage = $profile['main']->field_marriage[LANGUAGE_NONE][0]['value'];
$marriage_status = $marriage_status[$field_marriage];


$focus_num = user_relationships_load(array('rtid' => array(1),'requester_id' => array($account->uid)),array('count'=>TRUE));
$follow_num = user_relationships_load(array('rtid' => array(1),'requestee_id' => array($account->uid)),array('count'=>TRUE));
$friends_num = user_relationships_load(array('rtid' => array(2),'approved'=>array(1),'user' => array($account->uid)),array('count'=>TRUE));


$photo_nodes = love_get_nodes_by_type('photo',$account);
if(isset( $photo_nodes['node']))
	$photo_nodes = $photo_nodes['node']; 

?>

<?php if($logged_in):?>

<div class="bbb-page-user clearfix">
  <div class="header">
    <div class="username">@<?php echo $account->name;?></div>
  </div>
  
  <div class="bbb-user">
  	<?php print render($user_profile['user_picture']); ?>
   <!--  <div class="picture">
      <a href="#" class="">
        <img data-src="holder.js/140x140" class="img-circle" alt="140x140" src="https://avatars2.githubusercontent.com/u/1160703?s=460" style="width: 140px; height: 140px;">
      </a>
    </div> -->
    <div class="username"> 
    	<h3>
    		<span><?php echo $real_name;?></span> 
	    	<span><?php echo $sex;?></span> 
	    	<span><?php echo $age;?></span> 
	    	<span><?php echo $marriage_status;?></span>
    	</h3>
    </div>
    <div class="usersignatures">
      <p><?php echo $account->signature?$account->signature:'这家伙很懒^_^';?></p>
    </div>
    <?php

  if($account->uid != $user->uid){
   $my_space = FALSE;
   $ur = love_ur_between($account);
   if($ur == 'friends'){//<->
    $ur = user_relationships_load(array('rtid' => array(1),'between' => array($user->uid,$account->uid)));
    $rid = array_keys($ur);$rid =$rid[0];
    $ur_output = '<i class="icon-retweet"></i>互相关注';
    $ur_action =l('<i class="icon-minus"></i>取消关注',"user/{$user->uid}/relationships/$rid/remove",array('html'=>TRUE,'query' => drupal_get_destination(),'attributes'=>array('class' => array('love-icon','love-icon-action','btn-fav', 'mess-trigger'),'title'=>'取消关注')));
   }elseif($ur == 'follow'){//->
      $ur = user_relationships_load(array('rtid' => array(1),'between' => array($user->uid,$account->uid)));
     $rid = array_keys($ur);$rid =$rid[0];
    $ur_output = '<i class="icon-arrow-left"></i>你关注了Ta';

    $ur_action =l('<i class="icon-minus"></i>取消关注',"user/{$user->uid}/relationships/$rid/remove",array('html'=>TRUE,'query' => drupal_get_destination(),'attributes'=>array('class' => array('love-icon','love-icon-action','btn-fav', 'mess-trigger'),'title'=>'取消关注')));
   }elseif($ur == 'follower'){//<-
    $ur_output = '<i class="icon-arrow-right"></i>Ta关注了你';
    $ur_action =l('<i class="icon-plus"></i>关注Ta',"ajax/relationship/$account->uid/request/1",array('html'=>TRUE,'query' => drupal_get_destination(),'attributes'=>array('class' => array('love-icon','love-icon-action','btn-fav', 'mess-trigger'),'title'=>'关注Ta')));
   }else{
    $ur_action =l('<i class="icon-plus"></i>关注Ta',"ajax/relationship/$account->uid/request/1",array('html'=>TRUE,'query' => drupal_get_destination(),'attributes'=>array('class' => array('love-icon','love-icon-action','btn-fav', 'mess-trigger'),'title'=>'关注Ta')));
    $ur_output = '<a href="#" rel="tooltip" data-placement="right" title="暂无关系"><i class="icon-eye-close"></i></a>';
   }
   $privite_msg = '<a class="btn-mess mess-trigger" href="/messages/new/'.$account->uid.'">
           <span class="btn-mess-txt"><i class="icon-envelope"></i>私信</span>
          </a> ';
  }else{
    $ur_action =l('<i class="icon-cogs"></i>完善信息',"user/$account->uid/edit/believes",array('html'=>TRUE,'query' => drupal_get_destination(),'attributes'=>array('class' => array('love-icon','love-icon-action','btn-fav', 'mess-trigger'),'title'=>'关注Ta')));
    $privite_msg = '<a class="btn-mess mess-trigger" href="/messages/recent">
           <span class="btn-mess-txt"><i class="icon-envelope"></i>私信</span>
          </a> ';
    $ur_output = '';

  }

    ?>
    <div class="ops">
      <a href="#" class="btn btn-primary" role="button">
        <span class="glyphicon glyphicon-plus"></span>关 注</a> 
        <?php echo $privite_msg.' '. $ur_output.' '. $ur_action;
        $variables['account'] = $account;
        echo _love_user_relationships_link($variables);?>
    </div>
    <div class="status clearfix">
      <a href="user/<?php echo $account->uid;?>/relationships/2" class="tooltip-count" data-toggle="tooltip" data-placement="top" title="代表可信度">
        <span class="item"><div class="count"><?php echo $friends_num;?></div><div class="s-name">熟人</div></span>
      </a>
      <a href="user/<?php echo $account->uid;?>/relationships/1" class="tooltip-count" data-toggle="tooltip" data-placement="top" title="代表努力度">
        <span class="item"><div class="count"><?php echo $focus_num;?></div><div class="s-name">关注</div></span>
      </a>
      <a href="/timeline" class="tooltip-count active" data-toggle="tooltip" data-placement="bottom" title="代表真诚度">
        <span class="item"><div class="count"><?php echo count($photo_nodes);?></div><div class="s-name">照片</div></span>
      </a>
      <a href="#" class="tooltip-count" data-toggle="tooltip" data-placement="top" title="代表活跃度">
        <span class="item"><div class="count">52</div><div class="s-name">心语</div></span>
      </a>
      <a href="user/<?php echo $account->uid;?>/relationships/1" class="tooltip-count" data-toggle="tooltip" data-placement="top" title="代表受欢迎度">
        <span class="item"><div class="count"><?php echo $follow_num;?></div><div class="s-name">粉丝</div></span>
      </a>
      
    </div>

  <style type="text/css">
    div.gallery-row:after { clear: both; content: "."; display: block; height: 0; visibility: hidden; }
    div.gallery-item { float: left; width: 33.33333333%; }
    div.gallery-item a { display: block; margin: 5px; border: 1px solid #3c3c3c; }
    div.gallery-item img { display: block; width: 100%; height: auto; }


    .view-user-photos 
  </style>
  
  <link href="<?php echo drupal_get_path('theme', 'b3');?>/photoswipe/1.0.11/photoswipe.css" type="text/css" rel="stylesheet" />
  
  <script type="text/javascript" src="<?php echo drupal_get_path('theme', 'b3');?>/photoswipe/1.0.11/lib/simple-inheritance.min.js"></script>
  <script type="text/javascript" src="<?php echo drupal_get_path('theme', 'b3');?>/photoswipe/1.0.11/code-photoswipe-1.0.11.min.js"></script>
  
  
  <script type="text/javascript">
    
    // Set up PhotoSwipe with all anchor tags in the Gallery container 
    document.addEventListener('DOMContentLoaded', function(){
      
      Code.photoSwipe('a', '#Gallery');
      
    }, false);
  </script>
    <div id="Gallery">
      <div class="gallery-row">
        <div class="gallery-item"><a href="http://photoswipe.com/latest/examples/images/full/001.jpg"><img src="http://photoswipe.com/latest/examples/images/thumb/001.jpg" alt="Image 01" /></a></div>
        <div class="gallery-item"><a href="http://photoswipe.com/latest/examples/images/full/002.jpg"><img src="http://photoswipe.com/latest/examples/images/thumb/002.jpg" alt="Image 02" /></a></div>
        <div class="gallery-item"><a href="http://photoswipe.com/latest/examples/images/full/003.jpg"><img src="http://photoswipe.com/latest/examples/images/thumb/003.jpg" alt="Image 03" /></a></div>
      </div>
      <div class="gallery-row">
        <div class="gallery-item"><a href="http://photoswipe.com/latest/examples/images/full/004.jpg"><img src="http://photoswipe.com/latest/examples/images/thumb/004.jpg" alt="Image 04" /></a></div>
        <div class="gallery-item"><a href="http://photoswipe.com/latest/examples/images/full/005.jpg"><img src="http://photoswipe.com/latest/examples/images/thumb/005.jpg" alt="Image 05" /></a></div>
        <div class="gallery-item"><a href="http://photoswipe.com/latest/examples/images/full/006.jpg"><img src="http://photoswipe.com/latest/examples/images/thumb/006.jpg" alt="Image 06" /></a></div>
      </div>
    </div>

    <div class="demo" >



      <?php 
        echo views_embed_view('user_photos', 'visit');
      ?>

    </div>
  </div>
</div>
<?php endif;?>

<div class="profile"<?php print $attributes; ?>>
  <?php print render($user_profile); ?>
</div>
