<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<?php
// dpm($fields);
  foreach ($fields as $id => $field) {
    $$id = $field->wrapper_prefix.$field->label_html.$field->content.$field->wrapper_suffix;
    if (!empty($field->separator)){
      $$id = $field->separator.$$id;
    }
  }
  if(isset($ops))
  $accept_link = $ops;
  // $node = node_load($nid);//answer node /q-node
  global $base_url, $user;
  // $share_a_node = $base_url.'/node/'.$row->nid.'/share/'.$user->uid.'/nojs';

  //field_ask_anonymous
      // $q_author = $name;
    if($fields['field_ask_anonymous']->content == 1) {
      $name = '<a href="###">匿名用户</a>';
    }  
  //user pic default
  if(!strlen($picture)) {
    $account = user_load($fields['nid']->raw);
    $picture = variable_get('user_picture_default', '');
    $picture = theme('image_style',array('style_name' => 'profile_small', 'path' => $picture));
  }
  // dpm($fields['field_mark_question_resolved']);
	$resolved = ($fields['field_mark_question_resolved']->content ==0)?'open':'closed';
	$resolved_alt = ($fields['field_mark_question_resolved']->content ==0)?'未解决':'已解决';
  // dpm($resolved);
?>
    <div class="love-qa-list row">
        <div class="qa-list-l col-md-2 col-sm-2 clearfix">            
        	<a href="node/<?php echo $nid;?>" title="查看详情">
	        	<div class="meta-answers" title="Number of Answers">
	        		<span class="glyphicon glyphicon-question-sign"></span>
	            	<span class="counts"><?php echo $field_computed_answers;?></span>               </div>
	            
	        	<div class="meta-votes" title="Number of Votes">
	        		<span class="glyphicon glyphicon-thumbs-up"></span>
	            	<span class="counts"><?php echo $value;?></span>                </div>
	            
	        	<div class="meta-views" title="Number of this Question views">
	        		<span class="glyphicon glyphicon-eye-open"></span>
	            	<span class="counts"><?php echo $totalcount;?></span>             </div>
          </a>
        </div>
        <div class="qa-list-c col-md-10 col-sm-10">
            <div class="qa-list-title qa-list-title-<?php echo $resolved;?>"><?php echo $title;?></div>
            <div class="qa-list-body-summary"><?php echo $body;?></div>
            <div class="qa-list-contributes row">
            	<div class="qa-list-author-img  col-md-2 col-sm-2">
            		<?php echo $picture ;?>
            	</div>
            	<div class="qa-list-author-info col-md-9 col-sm-9">
            		<div class="qa-list-author-name">
            		 	<?php echo $name;?>在<span class="qa-list-region">General</span>模块发布
            		</div>
	            	<div class="qa-list-time">
	            		时间:<span><?php echo $created;?></span>            
	            	</div>

                <div class="qa-list-tags">  
                  <span class="glyphicon glyphicon-tags"></span>
                  <?php echo $field_tags;?>
                </div>
                
            	</div>
              
              <!-- <div class="entry-status status-<?php echo $resolved;?> col-md-1 col-sm-1" title="已解决"></div> -->
              <div class="clearfix"></div>
            </div>
        </div>
    </div>