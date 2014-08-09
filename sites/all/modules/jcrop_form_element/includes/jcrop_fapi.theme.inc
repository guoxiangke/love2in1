<?php

function theme_jcrop_element($variables) {
  $element = $variables['element'];
  $output = '';
  
  if (isset($element['cropbox'])) {
    $state_class = drupal_html_class('state-' . $element['state']['#value']);
    $output .= '<div class="crop-image-wrap ' . $state_class . '">';
  }  
  
  if (isset($element['cropbox'])) {
    $output .= '<div class="jcrop-crop-cropbox">';
    $output .= drupal_render($element['cropbox']);
    $output .= '</div>';
  }

  $output .= drupal_render_children($element); 
  
  if (isset($element['cropbox'])) {
    $output .= '</div>';
  } 
  
  return $output;
}

