<?php
/**
 * @file
 * druedu_qa_features.features.inc
 */

/**
 * Implements hook_views_api().
 */
function druedu_qa_features_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_flag_default_flags().
 */
function druedu_qa_features_flag_default_flags() {
  $flags = array();
  // Exported flag: "accepted".
  $flags['accepted'] = array(
    'entity_type' => 'node',
    'title' => 'accepted',
    'global' => 1,
    'types' => array(
      0 => 'answer',
    ),
    'flag_short' => '采纳为满意回答',
    'flag_long' => '',
    'flag_message' => '',
    'unflag_short' => '取消满意回答',
    'unflag_long' => '',
    'unflag_message' => '',
    'unflag_denied_text' => '已经接受该答案，不可更改！',
    'link_type' => 'toggle',
    'weight' => 0,
    'show_in_links' => array(
      'full' => 0,
      'teaser' => 0,
      'rss' => 0,
      'search_index' => 0,
      'search_result' => 0,
      'token' => 0,
    ),
    'show_as_field' => 0,
    'show_on_form' => 0,
    'access_author' => '',
    'show_contextual_link' => 0,
    'i18n' => 0,
    'module' => 'druedu_qa_features',
    'locked' => array(
      0 => 'name',
    ),
    'api_version' => 3,
  );
  return $flags;

}

/**
 * Implements hook_node_info().
 */
function druedu_qa_features_node_info() {
  $items = array(
    'answer' => array(
      'name' => t('Answer'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Answer'),
      'help' => '',
    ),
    'question' => array(
      'name' => t('问题'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Question'),
      'help' => '',
    ),
  );
  return $items;
}
