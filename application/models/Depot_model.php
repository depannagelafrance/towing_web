<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Depot_Model  {
  public $id              = null;
  public $name            = null;
  public $street          = null;
  public $street_number   = null;
  public $street_pobox    = null;
  public $zip             = null;
  public $city            = null;
  public $default_depot   = null;

  public function __construct($data = null) {
    if($data) {

      if(is_array ($data)){
        $this->initFromPost($data);
      }else{
        $this->id             = property_exists($data, 'id') ? $data->id : null;
        $this->name           = $data->name;
        $this->street         = $data->street;
        $this->street_number  = $data->street_number;
        $this->street_pobox   = $data->street_pobox;
        $this->zip            = $data->zip;
        $this->city           = $data->city;
        $this->default_depot  = property_exists($data, 'default_depot') ? $data->default_depot : 0;
      }

    }
  }

  public function initFromPost($data, $pfx = "depot_") {
    $this->id             = array_key_exists('id', $data) ? $data['id'] : null;

    $prefix = "";

    if(array_key_exists($pfx . 'name', $data)){
      $prefix = $pfx;
    }

    $this->name           = $data[$prefix . 'name'];
    $this->street         = $data[$prefix . 'street'];
    $this->street_number  = $data[$prefix . 'street_number'];
    $this->street_pobox   = $data[$prefix . 'street_pobox'];
    $this->zip            = $data[$prefix . 'zip'];
    $this->city           = $data[$prefix . 'city'];

    if(array_key_exists('default_depot', $data))
      $this->default_depot  = $data['default_depot'];
  }
}
