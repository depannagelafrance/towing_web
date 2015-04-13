<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_Model  {
  public $id   = null;
  public $name = null;
  public $date = null;

  public function __construct($data = null) {
    if($data) {
      $this->id = array_key_exists('id', $data) ? $data['id'] : null;
      $this->name = array_key_exists('name', $data) ? $data['name'] : null;
      $this->date = array_key_exists('date', $data) ? $data['date'] : null;
    }
  }
}
