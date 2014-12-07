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

  public function initFromPost($data) {
    $this->id             = $data['id'];
    $this->name           = $data['name'];
    $this->street         = $data['street'];
    $this->street_number  = $data['street_number'];
    $this->street_pobox   = $data['street_pobox'];
    $this->zip            = $data['zip'];
    $this->city           = $data['city'];
  }
}
