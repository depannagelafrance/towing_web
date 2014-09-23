<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vocabulary_model {
  private $id   = null;
  private $name = "";

  public function __construct($data) {
    if($data) {
      $this->id = array_key_exists('id', $data) ? $data['id'] : null;
      $this->name = array_key_exists('name', $data) ? $data['name'] : "";
    }
  }
}
