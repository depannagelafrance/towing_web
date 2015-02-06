<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Vehicle_model  {
  public $id              = null;
  public $name            = null;
  public $licence_plate   = null;
  public $type            = null;


  public function __construct($data = null) {
    if($data) {
      if(is_array ($data))
      {
        $this->initFromPost($data);
      }
      else
      {
        $this->id             = $data->id;
        $this->name           = $data->name;
        $this->licence_plate  = $data->licence_plate;
        $this->type           = $data->type;
      }
    }
  }

  public function initFromPost($data)
  {
    $this->id             = array_key_exists('id', $data) ? $data['id'] : null;
    $this->name           = $data['name'];
    $this->licence_plate  = $data['licence_plate'];
    $this->type           = $data['type'];
  }
}
