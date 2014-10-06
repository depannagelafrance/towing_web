<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Voucher_model.php');

class Dossier_model  {
  public $id   = null;
  public $call_number = null;
  public $company_id = null;
  public $incident_type_id = null;
  public $allotment_id = null;
  public $allotment_direction_id = null;
  public $allotment_indicator_id = null;
  public $traffic_lane_id = null;
  public $police_traffic_post_id = null;
  public $towing_vouchers = array(); //array of Voucher_model


  public function __construct($data = null) {
    if($data) {
      $this->id                                    = $data->dossier->id;
      $this->call_number                           = $data->dossier->call_number;
      $this->company_id                            = $data->dossier->company_id;
      $this->incident_type_id                      = $data->dossier->incident_type_id;
      $this->allotment_id                          = $data->dossier->allotment_id;
      $this->direction_id                          = $data->dossier->allotment_direction_id;
      $this->indicator_id                          = $data->dossier->allotment_direction_indicator_id;
      $this->traffic_lane_id                       = $data->dossier->traffic_lane_id;
      $this->police_traffic_post_id                = $data->dossier->police_traffic_post_id;


      if($data->dossier->towing_vouchers && is_array($data->dossier->towing_vouchers)) {
        foreach($data->dossier->towing_vouchers as $voucher) {
          $this->towing_vouchers[] = new Voucher_model($voucher);
        }
      }
    }
  }
}
