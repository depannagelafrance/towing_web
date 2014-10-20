<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('toMySQLDate')) {
  function toMySQLDate($date)
  {
    if(!$date || $date == "")
    {
      return null;
    } else {
      $_date = strtotime($date);
      return date("Y-m-d h:i:s",$_date);
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

if ( ! function_exists('toTimeValue')) {
  function toTimeValue($time)
  {
    if(!$time || $time == "" || $time === "") {
      return null;
    }
    else
    {
      return "2014-10-04T22:00:00.000Z";
    }
  }
}
?>
