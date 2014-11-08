<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('asTime')) {
  function asTime($data) {
    if(!$data || trim($data) === "") {
      return "";
    } else {
      return mdate('%H:%i',strtotime($data));
    }
  }
}
?>
