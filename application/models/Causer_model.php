<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Causer_model  {
  public $id              = null;
  public $first_name      = null;
  public $last_name       = null;
  public $company_name    = null;
  public $company_vat     = null;
  public $street          = null;
  public $street_number   = null;
  public $street_pobox    = null;
  public $zip             = null;
  public $city            = null;
  public $email           = null;
  public $phone           = null;

  public function __construct($data = null) {
    if($data) {
      if(is_array ($data)){
        $this->id             = $data['id'];
        $this->first_name     = $data['first_name'];
        $this->last_name      = $data['last_name'];
        $this->company_name   = $data['company_name'];
        $this->company_vat    = $data['company_vat'];
        $this->street         = $data['street'];
        $this->street_number  = $data['street_number'];
        $this->street_pobox   = $data['street_pobox'];
        $this->zip            = $data['zip'];
        $this->city           = $data['city'];
        $this->email          = $data['email'];
        $this->phone          = $data['phone'];
      }else{
        $this->id             = $data->id;
        $this->first_name     = $data->first_name;
        $this->last_name      = $data->last_name;
        $this->company_name   = $data->company_name;
        $this->company_vat    = $data->company_vat;
        $this->street         = $data->street;
        $this->street_number  = $data->street_number;
        $this->street_pobox   = $data->street_pobox;
        $this->zip            = $data->zip;
        $this->city           = $data->city;
        $this->email          = $data->email;
        $this->phone          = $data->phone;
      }
    }
  }
}
