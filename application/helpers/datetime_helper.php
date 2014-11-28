<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('asTime')) {
  function asTime($data)
  {
    if(!$data || trim($data) === "")
    {
      return "";
    }
    else
    {
      if(is_numeric($data))  //it can be a unixtimestamp
      {
        return date('H:i', $data);
      }
      else //or just a string
      {
        return mdate('%H:%i',strtotime($data));
      }
    }
  }
}
if ( ! function_exists('asJsonDateTime')) {
  function asJsonDateTime($data)
  {
    if(!$data || trim($data) === "")
    {
      return "";
    }
    else
    {
      if(is_numeric($data))  //it can be a unixtimestamp
      {
        return date('c', $data);
      }
      else //or just a string
      {
        return mdate('%H:%i',strtotime($data));
      }
    }
  }
}
?>
