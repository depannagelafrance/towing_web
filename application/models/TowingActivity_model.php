<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TowingActivity_Model  {
  public $activity_id   = null;
  public $amount        = null;

  public function __construct($data = null) {
    if($data) {
      $this->activity_id     = $data->activity_id;
      $this->amount          = $data->amount;
    }
  }
}
