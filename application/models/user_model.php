<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
  public $id            = "";
  public $login         = "";
  public $firstname     = "";
  public $lastname      = "";
  public $email         = "";
  public $is_signa      = false;
  public $is_towing     = false;
  public $vehicule      = "";
  public $licence_plate = "";

  public $user_roles  = array(); //array of Role_model

  public function __construct(){
      parent::__construct();
  }

  public function initialise($data = null) {
    if($data != null) {
      $this->id             = array_key_exists('id', $data) ? $data['id'] : "";
      $this->login          = array_key_exists('login', $data) ? $data['login'] : "";
      $this->firstname      = array_key_exists('firstname', $data) ? $data['firstname'] : "";
      $this->lastname       = array_key_exists('lastname', $data) ? $data['lastname'] : "";
      $this->email          = array_key_exists('email', $data) ? $data['email'] : "";
      $this->is_signa       = array_key_exists('is_signa', $data) ? $data['is_signa'] : "";
      $this->is_towing      = array_key_exists('is_towing', $data) ? $data['is_towing'] : "";
      $this->vehicule       = array_key_exists('vehicule', $data) ? $data['vehicule'] : '';
      $this->licence_plate  = array_key_exists('licence_plate', $data) ? $data['licence_plate'] : '';

      //$this->load->model('role_model');
      //$roles = array();
      if(array_key_exists('roles', $data) && is_array($data['roles'])) {
        foreach($data['roles'] as $role) {
            //array_push($roles, $role);
            $this->user_roles[] = $role;
        }
      }

      return $this;
    }
  }
}
