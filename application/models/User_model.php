<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model {
//   var $login      = ju.requires('login', $req.body);
  //   var $firstname  = ju.requires('firstname', $req.body);
  //   var $lastname   = ju.requires('lastname', $req.body);
  //   var $email      = ju.requires('email', $req.body);
  //   var $roles      = ju.requires('user_roles', $req.body);

  public $id          = "";
  public $login       = "";
  public $firstname   = "";
  public $lastname    = "";
  public $email       = "";
  public $user_roles  = array(); //array of Role_model

  public function __construct($data = null) {
    if($data != null) {
      $this->id         = array_key_exists('id', $data) ? $data['id'] : "";
      $this->login      = array_key_exists('login', $data) ? $data['login'] : "";
      $this->firstname  = array_key_exists('firstname', $data) ? $data['firstname'] : "";
      $this->lastname   = array_key_exists('lastname', $data) ? $data['lastname'] : "";
      $this->email      = array_key_exists('email', $data) ? $data['email'] : "";

      if(array_key_exists('user_roles', $data) && is_array($data['user_roles'])) {
        foreach($role as $data['user_roles']) {
          $this->user_roles[] = new Role_model($role);
        }
      }
    }
  }
}
