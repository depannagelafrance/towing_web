<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('toMySQLDate')) {
  function toMySQLDate($date)
  {
    if(!$date || $date == "")
    {
      return null;
    } else {
      return $date;
    }
  }
}

if ( ! function_exists('toIntegerValue')) {
  function toIntegerValue($value)
  {
    if(!$value || $value == "" || $value === "")
    {
      return null;
    }
    else
    {
      return $value;
    }
  }
}
?>
