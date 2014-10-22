<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Depot_model.php');
require_once(APPPATH . '/models/TowingActivity_model.php');

class Voucher_model  {
  public $id                          = null;
  public $insurance_id                = null;
  public $insurance_dossiernr         = null;
  public $insurance_warranty_held_by  = null;
  public $collector_id                = null;
  public $police_signature_dt         = null;
  public $recipient_signature_dt      = null;
  public $vehicule_type               = null;
  public $vehicule_licenceplate       = null;
  public $vehicule_country            = null;
  public $vehicule_collected          = null;
  public $towed_by             = null;
  public $towed_by_vehicle     = null;
  public $towing_called        = null;
  public $towing_arrival       = null;
  public $towing_start         = null;
  public $towing_completed     = null;
  public $towing_depot         = null;
  public $signa_by             = null;
  public $signa_by_vehicle     = null;
  public $signa_arrival        = null;
  public $cic                  = null;
  public $additional_info      = null;

  public $depot = null; //instance of Depot_model

  public $towing_activities     = array(); //array of TowingActivy_model


  public function __construct($data = null) {
    if($data) {
      $this->id                           = $data->id;
      $this->insurance_id                 = $data->insurance_id;
      $this->insurance_dossiernr          = $data->insurance_dossiernr;
      $this->insurance_warranty_held_by   = $data->insurance_warranty_held_by;
      $this->collector_id                 = $data->collector_id;
      $this->police_signature_dt          = $data->police_signature_dt;
      $this->recipient_signature_dt       = $data->recipient_signature_dt;
      $this->vehicule_type                = $data->vehicule_type;
      $this->vehicule_licenceplate        = $data->vehicule_licenceplate;
      $this->vehicule_country             = $data->vehicule_country;
      $this->vehicule_collected           = $data->vehicule_collected;
      $this->towed_by                     = $data->towed_by;
      $this->towed_by_vehicle             = $data->towed_by_vehicle;
      $this->towing_called                = $data->towing_called;
      $this->towing_arrival               = $data->towing_arrival;
      $this->towing_start                 = $data->towing_start;
      $this->towing_completed             = $data->towing_completed;
      //$this->towing_depot                 = $data->towing_depot;
      $this->signa_by                     = $data->signa_by;
      $this->signa_arrival                = $data->signa_arrival;
      $this->signa_by_vehicle             = $data->signa_by_vehicle;
      $this->cic                          = $data->cic;
      $this->additional_info              = $data->additional_info;

      if($data->depot) {
        $this->depot = new Depot_model($data->depot);
      }

      if($data->towing_activities && is_array($data->towing_activities)) {
        foreach($data->towing_activities as $activity) {
          $this->towing_activities[] = new TowingActivity_model($activity);
        }
      }

    }
  }
}
