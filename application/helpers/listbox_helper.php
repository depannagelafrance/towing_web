<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('listbox')) {
  function listbox($name, $data, $selected_value, $attributes = null) {
    $_attributes = array(
          'value_key' => 'id',
          'label_key' => 'name',
        );


    if($attributes) {
      if(array_key_exists('value_key', $attributes)) {
        $_attributes['value_key'] = $attributes['value_key'];
      }

      if(array_key_exists('label_key', $attributes)) {
        $_attributes['label_key'] = $attributes['label_key'];
      }
    }

    $valueKey = $_attributes['value_key'];
    $labelKey = $_attributes['label_key'];



    $open_select = sprintf('<select name="%s" id="list_%s">', $name, $name);

    $select_data = "";

    if($data && sizeof($data) > 0) {
      $select_data .= sprintf('<option value="">--</option>');

      foreach($data as $item) {
        if($item->$valueKey == $selected_value) {
          $select_data .= sprintf('<option value="%s" selected>%s</option>', $item->$valueKey, $item->$labelKey);
        } else {
          $select_data .= sprintf('<option value="%s">%s</option>', $item->$valueKey, $item->$labelKey);
        }
      }
    }

    $close_select = '</select>';

    return $open_select . $select_data . $close_select;
  }
}

if ( ! function_exists('listbox_ajax')) {
  function listbox_ajax($name, $selected_value) {
    $open_select = sprintf('<select name="%s" id="list_%s" data-selected-id="%s">', $name, $name, $selected_value);

    $close_select = '</select>';

    return $open_select . $close_select;
  }
}
?>
