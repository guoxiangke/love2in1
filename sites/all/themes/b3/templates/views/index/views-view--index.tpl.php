<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>
<style type="text/css">
.t-user-info {
    width:100px;
    overflow: hidden;
}
.view-index {
  margin: 0 0 30px;
}





.view-index .views-row{
  padding: 15px 0;
  border-bottom: 1px dotted #CCC;
}
.view-status .views-row{
  padding: 15px 0;
  border-bottom: 1px dotted #CCC;
}
.view-status .filed_tags{
  margin-left: 10px;
}
.view-status .views-row a{
  color: #999;
}
.view-status .views-row a:hover{
  color: #666;
}
.view-status .views-row .t-footer{
  padding-top: 5px;
}
.view-index .views-row a:hover{
  color: #666;
}
.view-index .views-row .t-footer{
  padding-top: 5px;
}
.view-status .views-row .t-footer .float-l{
  padding-right: 10px;
}
.view-status .views-row .t-user-info li{
  list-style:none;
}
.view-status .views-row  .btn-mess,.view-status .views-row  .love-icon {
  background: #FFF;
}




.float-l {
  float: left;
}


/*views photo*/
.t-body {
  background-color:#FFF;
  padding: 10px 30px 15px;
  border-radius: 5px;
  box-shadow: 1px 1px 1px #ccc;
}
.t-footer {
  font-size:12px;
  color:#999;
}
.t-des {
  background: #F4F4EC;
  padding: 25px;
}
/*index views */
.love_vote,.love_vote ul,.love_vote ul li{
  display:inline-block;
}
.t-field_photo {
  position: relative;
}
.t-field_photo .photo{
  float:left;
  height: 225px;
  overflow: hidden;
}
.t-des{
  float: right;
  width: 50%;
}
/*.t-field_photo img:hover {
text-decoration: none;
opacity: .6;
-moz-opacity: .6;
-webkit-opacity: .6;
-khtml-opacity: .6;
-o-opacity: .6;
filter: alpha(opacity=60);
}*/
.t-field_photo .highslide img {
  border: 4px solid #DDD;
}
.t-field_photo .highslide:hover img {
  /*border: 4px solid #275973; 549DC0*/
}
.love_vote {
  position: absolute;
  left: 2px;
  top: 2px;
background-color: #FFF;
}
.love_vote ul{
  margin:0;
}
.rate-info {
  display:none;
}
.rate-number-up-down-btn-down,.rate-number-up-down-btn-up{
  overflow: visible;
  text-indent: 0;
  background: none;
}



.feedTagName {
position: relative;
top: -10px;
display: inline-block;
height: 25px;
padding-right: 12px;
background: url(http://simg.sinajs.cn/xblogstyle/images/common/ico_tagfeed.png) right -114px no-repeat;
_background: url(http://simg.sinajs.cn/xblogstyle/images/common/ico_tagfeed.gif) right -114px no-repeat;
}
.feedTagName span {
padding: 0 10px;
overflow: hidden;
width: 56px;
display: inline-block;
height: 25px;
line-height: 23px;
_line-height: 25px;
background: #77b3d5;
color: #fff;
font-size: 14px;
}


.love-icon{
background: #7092B9;
display: inline-block;
color: white;
height: 25px;
line-height: 25px;
padding: 0 8px;
}
.love-icon{
  font-size:12px;
}
.view-status .views-row  .love-icon {
  background: #FFF;
}




</style>
<div class="<?php print $classes; ?>" id="views-status">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content clearfix" id="views-photos-rows">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>