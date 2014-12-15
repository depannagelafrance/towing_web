<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Depot_model.php');

class Depot_model  {
  public $id              = null;
  public $name            = null;
  public $street          = null;
  public $street_number   = null;
  public $street_pobox    = null;
  public $zip             = null;
  public $city            = null;

  public function __construct($data = null) {
    if($data) {

      if(is_array ($data)){
        $this->initFromPost($data);
      }else{
        $this->id             = $data->id;
        $this->name           = $data->name;
        $this->street         = $data->street;
        $this->street_number  = $data->street_number;
        $this->street_pobox   = $data->street_pobox;
        $this->zip            = $data->zip;
        $this->city           = $data->city;
      }

    }
  }

  public function initFromPost($data, $prefix = "depot_") {
    $this->id             = array_key_exists('id', $data) ? $data['id'] : null;
    $this->name           = $data[$prefix . 'name'];
    $this->street         = $data[$prefix . 'street'];
    $this->street_number  = $data[$prefix . 'street_number'];
    $this->street_pobox   = $data[$prefix . 'street_pobox'];
    $this->zip            = $data[$prefix . 'zip'];
    $this->city           = $data[$prefix . 'city'];
  }
}
