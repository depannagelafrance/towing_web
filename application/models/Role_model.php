<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_model {
  private $id   = null;
  private $code = "";
  private $name = "";

  public function __construct($data) {
    if($data) {
      $this->id = array_key_exists('id', $data) ? $data['id'] : null;
      $this->code = array_key_exists('code', $data) ? $data['code'] : "";
      $this->name = array_key_exists('name', $data) ? $data['name'] : "";
    }
  }
}
