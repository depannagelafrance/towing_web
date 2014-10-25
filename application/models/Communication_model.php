<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Communication_model  {
  public $dossier_id  = "";
  public $voucher_id  = "";
  public $subject     = "";
  public $message     = "";
  public $recipients  = array(); //array of Recipient_model
}
