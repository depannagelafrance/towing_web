<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Voucher_Model.php');

class Dossier_Model  {
  public $id   = null;
  public $call_number = null;
  public $company_id = null;
  public $incident_type_id = null;
  public $allotment_id = null;
  public $allotment_direction_id = null;
  public $allotment_indicator_id = null;
  public $direction_id = null;
  public $indicator_id = null;
  public $traffic_lanes = array();
  public $police_traffic_post_id = null;
  public $towing_vouchers = array(); //array of Voucher_Model


  public function __construct($data = null) {
    if($data) {
      $this->id                                    = $data->dossier->id;
      $this->call_number                           = $data->dossier->call_number;
      $this->company_id                            = $data->dossier->company_id;
      $this->incident_type_id                      = $data->dossier->incident_type_id;
      $this->allotment_id                          = $data->dossier->allotment_id;
      $this->direction_id                          = $data->dossier->allotment_direction_id;
      $this->allotment_direction_id                = $data->dossier->allotment_direction_id;

      if(property_exists($data->dossier, 'allotment_indicator_id')) {
        $this->indicator_id                          = $data->dossier->allotment_indicator_id;
        $this->allotment_indicator_id                = $data->dossier->allotment_indicator_id;
      } else {
        $this->indicator_id                          = null;
        $this->allotment_indicator_id                = null;
      }

      $this->traffic_lanes                         = $data->dossier->traffic_lanes;
      $this->police_traffic_post_id                = $data->dossier->police_traffic_post_id;


      if($data->dossier->towing_vouchers && is_array($data->dossier->towing_vouchers)) {
        foreach($data->dossier->towing_vouchers as $voucher) {
          $this->towing_vouchers[] = new Voucher_Model($voucher);
        }
      }
    }
  }
}
