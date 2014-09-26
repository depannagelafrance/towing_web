<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Voucher_model.php');

class Dossier_model  {
  public $id   = null;
  public $call_number = null;
  public $company_id = null;
  public $incident_type_id = null;
  public $allotment_id = null;
  public $direction_id = null;
  public $indicator_id = null;
  public $traffic_lane_id = null;
  public $traffic_post_id = null;
  public $towing_vouchers = array(); //array of Voucher_model

  public function __construct($data = null) {
    if($data) {
      $this->id                 = array_key_exists('id', $data) ? $data['id'] : null;
      $this->call_number        = array_key_exists('call_number', $data) ? $data['call_number'] : null;
      $this->company_id         = array_key_exists('company_id', $data) ? $data['company_id'] : null;
      $this->incident_type_id   = array_key_exists('incident_type_id', $data) ? $data['incident_type_id'] : null;
      $this->allotment_id       = array_key_exists('allotment_id', $data) ? $data['allotment_id'] : null;
      $this->direction_id       = array_key_exists('direction_id', $data) ? $data['direction_id'] : null;
      $this->indicator_id       = array_key_exists('indicator_id', $data) ? $data['indicator_id'] : null;
      $this->traffic_lane_id    = array_key_exists('traffic_lane_id', $data) ? $data['traffic_lane_id'] : null;
      $this->traffic_post_id    = array_key_exists('traffic_post_id', $data) ? $data['traffic_post_id'] : null;

      if(array_key_exists('towing_vouchers', $data) && is_array($data['towing_vouchers'])) {
        foreach($data['towing_vouchers'] as $voucher) {
          $this->towing_vouchers[] = new Voucher_model($voucher);
        }
      }
    }
  }
}
