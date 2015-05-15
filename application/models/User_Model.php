<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Role_Model.php');

class User_Model {
  public $id            = "";
  public $login         = "";
  public $firstname     = "";
  public $lastname      = "";
  public $email         = "";
  public $is_signa      = false;
  public $is_towing     = false;
  public $vehicle_id    = null;

  public $user_roles  = array(); //array of Role_Model

  public function __construct(){
  }

  public function initialise($data = null) {
    if($data != null)
    {

      if(is_array($data)) {
        $this->id             = array_key_exists('id', $data) ? $data['id'] : "";
        $this->login          = array_key_exists('login', $data) ? $data['login'] : "";
        $this->firstname      = array_key_exists('firstname', $data) ? $data['firstname'] : "";
        $this->lastname       = array_key_exists('lastname', $data) ? $data['lastname'] : "";
        $this->email          = array_key_exists('email', $data) ? $data['email'] : "";
        $this->is_signa       = array_key_exists('is_signa', $data) ? $data['is_signa'] : "";
        $this->is_towing      = array_key_exists('is_towing', $data) ? $data['is_towing'] : "";
        $this->vehicle_id     = array_key_exists('vehicle_id', $data) ? $data['vehicle_id'] : '';

        if(array_key_exists('roles', $data)) {
          $this->user_roles = $data['roles'];
        }
      } else {
        $this->id             = $data->id;
        $this->login          = $data->login;
        $this->firstname      = $data->first_name;
        $this->lastname       = $data->last_name;
        $this->email          = $data->email;
        $this->is_signa       = $data->is_signa;
        $this->is_towing      = $data->is_towing;
        $this->vehicle_id     = $data->vehicle_id;

        if(property_exists($data, 'user_roles')) {
          $this->user_roles = $data->user_roles;
        }
      }

      return $this;
    }
  }
}
