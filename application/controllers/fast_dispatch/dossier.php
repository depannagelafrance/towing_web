<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');
require_once(APPPATH . '/models/Dossier_Model.php');

class Dossier extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_Service');
      $this->load->library('towing/Vocabulary_Service');

      $this->load->library('table');
      $this->load->library('form_validation');

      $this->load->helper('form');
      $this->load->helper('url');

    }

  /**
   * Index Page for this controller.
   */
  public function view($number, $voucher_number)
  {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);

    if(property_exists($dossier, 'statusCode') && $dossier->statusCode===404) {
      redirect("/fast_dispatch/");
    } else {
      $this->_loadDossierView($token, $dossier, $voucher_number);
    }
  }

  public function save($number, $voucher_number) {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);
    $this->form_validation->set_rules('direction', 'Richting', 'required');
    $this->form_validation->set_rules('indicator', 'KM Paal', 'required');
    $this->form_validation->set_rules('incident_type', 'Type incident', 'required');
    $this->form_validation->set_rules('call_number', 'Oproepnummer', 'required');
    //$this->form_validation->set_rules('vehicule_type', 'Type wagen', 'required');
    $this->form_validation->set_rules('company_id', 'Takeldienst', 'required');

    if ($this->form_validation->run() === FALSE)
    {
      $this->_setDossierValuesFromPostRequest($dossier);
      $this->_loadDossierView($token, $dossier, $voucher_number);
    }
    else
    {
      if($dossier && $dossier->dossier) {
        $this->_setDossierValuesFromPostRequest($dossier);

        $dossier = $this->dossier_service->updateDossier(new Dossier_Model($dossier), $token);
        if($dossier) {
          redirect(sprintf("/fast_dispatch/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher_number));
        }
      }
    }
  }

  private function _loadDossierView($token, $dossier, $voucher_number) {
    $this->_add_content(
      $this->load->view(
        'fast_dispatch/dossier',
          array(
            'dossier'                 => $dossier,
            'voucher_number'          => $voucher_number,
            'vouchers'                => $this->dossier_service->fetchAllNewVouchers($token),
            'incident_types'          => $this->vocabulary_service->fetchAllIncidentTypes($token),
            'insurances'              => $this->vocabulary_service->fetchAllInsurances($token),
            'directions'              => $this->vocabulary_service->fetchAllDirections($token),
            'indicators'              => $this->vocabulary_service->fetchAllIndicatorsByDirection($dossier->dossier->allotment_direction_id, $token),
            'traffic_lanes'           => $this->dossier_service->fetchAllTrafficLanes($dossier->dossier->id, $token),
            'licence_plate_countries' => $this->vocabulary_service->fetchAllCountryLicencePlates($token)
          ),
          true
      )
    );

    $this->_render_page();
  }

  private function _setDossierValuesFromPostRequest($dossier) {
    $dossier->dossier->call_number            = $this->input->post('call_number');
    $dossier->dossier->company_id             =  $this->input->post('company_id');
    $dossier->dossier->incident_type_id       = $this->input->post('incident_type');
    $dossier->dossier->allotment_id           =  $this->input->post('allotment_id');
    $dossier->dossier->allotment_direction_id = $this->input->post('direction');
    $dossier->dossier->direction_id           = $this->input->post('direction');

    $dossier->dossier->allotment_direction_indicator_id = $this->input->post('indicator');
    $dossier->dossier->allotment_indicator_id = $this->input->post('indicator');
    $dossier->dossier->indicator_id           = $this->input->post('indicator');


    $dossier->dossier->traffic_lanes          = $this->input->post('traffic_lane_id');

    $dossier->dossier->towing_vouchers[0]->vehicule               = $this->input->post('vehicule');
    $dossier->dossier->towing_vouchers[0]->vehicule_type          = $this->input->post('vehicule_type');
    $dossier->dossier->towing_vouchers[0]->vehicule_licenceplate  = $this->input->post('vehicule_licenceplate');
    $dossier->dossier->towing_vouchers[0]->vehicule_country       = $this->input->post('licence_plate_country');

    $dossier->dossier->towing_vouchers[0]->additional_info = $this->input->post('additional_info');

    $dossier->dossier->towing_vouchers[0]->insurance_id = $this->input->post('insurance_id');
    $dossier->dossier->towing_vouchers[0]->insurance_dossiernr = $this->input->post('insurance_dossiernr');

    $dossier->dossier->towing_vouchers[0]->cic  = $this->input->post('cic') == '' ? null : DateTime::createFromFormat('d/m/Y H:i', $this->input->post('cic'))->getTimestamp();
  }
}
