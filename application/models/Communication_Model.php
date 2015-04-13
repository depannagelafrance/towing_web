<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Communication_Model  {
  public $dossier_id  = "";
  public $voucher_id  = "";
  public $subject     = "";
  public $message     = "";
  public $recipients  = array(); //array of Recipient_Model

  public function __construct($data = null) {
    if($data) {
      if(is_array ($data)){
        $this->dossier_id     = $data['dossier_id'];
        $this->voucher_id     = $data['voucher_id'];
        $this->subject        = isset($data['subject']) ? $data['subject'] : '';
        $this->message        = $data['message'];
        $this->recipients     = isset($data['recipients']) ? explode(',', $data['recipients']) : array();
      }else{
        $this->dossier_id     = $this->dossier_id;
        $this->voucher_id     = $this->voucher_id;
        $this->subject        = $this->subject;
        $this->message        = $this->message;
        $this->recipients     = explode(',', $this->recipients);
      }
    }
  }

}
