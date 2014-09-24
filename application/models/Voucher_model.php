<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
  public $towed_by_vehicule    = null;
  public $towing_called        = null;
  public $towing_arrival       = null;
  public $towing_start         = null;
  public $towing_completed     = null;
  public $towing_depot         = null;
  public $signa_by             = null;
  public $signa_by_vehicule    = null;
  public $signa_arrival        = null;
  public $cic                  = null;
  public $additional_info      = null;


  public function __construct($data = null) {
    if($data) {
      $this->id                           = array_key_exists('id', $data) ? $data['id'] : null;
      $this->insurance_id                 = array_key_exists('insurance_id', $data) ? $data['insurance_id'] : null;
      $this->insurrance_dossiernr         = array_key_exists('insurance_dossiernr', $data) ? $data['insurance_dossiernr'] : null;
      $this->insurrance_warranty_held_by  = array_key_exists('insurance_warranty_held_by', $data) ? $data['insurance_warranty_held_by'] : null;
      $this->collector_id                 = array_key_exists('collector_id', $data) ? $data['collector_id'] : null;
      $this->police_signature_dt          = array_key_exists('police_signature_dt', $data) ? $data['police_signature_dt'] : null;
      $this->recipient_signature_dt       = array_key_exists('recipient_signature_dt', $data) ? $data['recipient_signature_dt'] : null;
      $this->vehicule_type                = array_key_exists('vehicule_type', $data) ? $data['vehicule_type'] : null;
      $this->vehicule_licenceplate        = array_key_exists('vehicule_licenceplate', $data) ? $data['vehicule_licenceplate'] : null;
      $this->vehicule_country             = array_key_exists('vehicule_country', $data) ? $data['vehicule_country'] : null;
      $this->vehicule_collected           = array_key_exists('vehicule_collected', $data) ? $data['vehicule_collected'] : null;
      $this->towed_by                     = array_key_exists('towed_by', $data) ? $data['towed_by'] : null;
      $this->towed_by_vehicule            = array_key_exists('towed_by_vehicule', $data) ? $data['towed_by_vehicule'] : null;
      $this->towing_called                = array_key_exists('towing_called', $data) ? $data['towing_called'] : null;
      $this->towing_arrival               = array_key_exists('towing_arrival', $data) ? $data['towing_arrival'] : null;
      $this->towing_start                 = array_key_exists('towing_start', $data) ? $data['towing_start'] : null;
      $this->towing_completed             = array_key_exists('towing_completed', $data) ? $data['towing_completed'] : null;
      $this->towing_depot                 = array_key_exists('towing_depot', $data) ? $data['towing_depot'] : null;
      $this->signa_by                     = array_key_exists('signa_by', $data) ? $data['signa_by'] : null;
      $this->signa_arrival                = array_key_exists('signa_arrival', $data) ? $data['signa_arrival'] : null;
      $this->cic                          = array_key_exists('cic', $data) ? $data['cic'] : null;
      $this->additional_info              = array_key_exists('additional_info', $data) ? $data['additional_info'] : null;
    }
  }
}
