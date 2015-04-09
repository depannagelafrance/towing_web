<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_Model
{
  public $id              = null;
  public $name            = null;
  public $street          = null;
  public $street_number   = null;
  public $street_pobox    = null;
  public $zip             = null;
  public $city            = null;
  public $code            = null;
  public $vat             = null;
  public $phone           = null;
  public $fax             = null;
  public $email           = null;
  public $website         = null;

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
        $this->code           = $data->code;
        $this->vat            = $data->vat;
        $this->phone          = $data->phone;
        $this->fax            = $data->fax;
        $this->email          = $data->email;
        $this->website        = $data->website;
      }

    }
  }

  public function initFromPost($data, $prefix='company_') {
    //$this->id             = $data['id'];
    $this->name           = $data[$prefix . 'name'];
    $this->street         = $data[$prefix . 'street'];
    $this->street_number  = $data[$prefix . 'street_number'];
    $this->street_pobox   = $data[$prefix . 'street_pobox'];
    $this->zip            = $data[$prefix . 'zip'];
    $this->city           = $data[$prefix . 'city'];
    $this->code           = $data[$prefix . 'code'];
    $this->vat            = $data[$prefix . 'vat'];
    $this->phone          = $data[$prefix . 'phone'];
    $this->fax            = $data[$prefix . 'fax'];
    $this->email          = $data[$prefix . 'email'];
    $this->website        = $data[$prefix . 'website'];

  }
}
