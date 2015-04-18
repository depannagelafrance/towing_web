<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insurance_Model {
  public $id            = null;
  public $name          = null;
  public $vat           = null;
  public $street        = null;
  public $street_number = null;
  public $street_pobox  = null;
  public $zip           = null;
  public $city          = null;


  public function __construct($data = null)
  {
    if($data) {
      $this->id = array_key_exists('id', $data) ? $data['id'] : null;
      $this->name = array_key_exists('name', $data) ? $data['name'] : "";
      $this->vat = array_key_exists('vat', $data) ? $data['vat'] : "";
      $this->street = array_key_exists('street', $data) ? $data['street'] : "";
      $this->street_number = array_key_exists('street_number', $data) ? $data['street_number'] : "";
      $this->street_pobox= array_key_exists('street_pobox', $data) ? $data['street_pobox'] : "";
      $this->zip = array_key_exists('zip', $data) ? $data['zip'] : "";
      $this->city = array_key_exists('city', $data) ? $data['city'] : "";
    }

    return $this;
  }
}