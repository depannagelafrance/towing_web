<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');
require_once(APPPATH . '/models/Dossier_model.php');

class Dossier extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
      $this->load->library('towing/Vocabulary_service');

      $this->load->library('table');
      $this->load->library('form_validation');

      $this->load->helper('form');
      $this->load->helper('url');

    }

  /**
   * Index Page for this controller.
   */
  public function view($number)
  {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);

    $this->_loadDossierView($token, $dossier);

  }

  public function save($number) {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);
    $this->form_validation->set_rules('direction', 'Richting', 'required');
    $this->form_validation->set_rules('indicator', 'KM Paal', 'required');
    $this->form_validation->set_rules('incident_type', 'Type incident', 'required');
    $this->form_validation->set_rules('call_number', 'Oproepnummer', 'required');
    $this->form_validation->set_rules('vehicule_type', 'Type wagen', 'required');
    $this->form_validation->set_rules('company_id', 'Takeldienst', 'required');

    if ($this->form_validation->run() === FALSE)
    {
      $this->_setDossierValuesFromPostRequest($dossier);
      $this->_loadDossierView($token, $dossier);
    }
    else
    {
      if($dossier && $dossier->dossier) {
        $this->_setDossierValuesFromPostRequest($dossier);

        $dossier = $this->dossier_service->updateDossier(new Dossier_model($dossier), $token);

        if($dossier) {
          redirect(sprintf("/fast_dispatch/dossier/%s", $dossier->dossier->dossier_number));
        }
      }
    }
  }

  private function _loadDossierView($token, $dossier) {
    $this->_add_content(
      $this->load->view(
        'fast_dispatch/dossier',
          array(
            'dossier'                 => $dossier,
            'vouchers'                => $this->dossier_service->fetchAllNewVouchers($token),
            'incident_types'          => $this->vocabulary_service->fetchAllIncidentTypes($token),
            'insurances'              => $this->vocabulary_service->fetchAllInsurances($token),
            'directions'              => $this->vocabulary_service->fetchAllDirections($token),
            'indicators'              => $this->vocabulary_service->fetchAllIndicatorsByDirection($dossier->dossier->allotment_direction_id, $token),
            'traffic_lanes'           => $this->vocabulary_service->fetchAllTrafficLanes($token),
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
    $dossier->dossier->allotment_direction_indicator_id = $this->input->post('indicator');
    $dossier->dossier->traffic_lane_id        = $this->input->post('traffic_lane_id');

    $dossier->dossier->towing_vouchers[0]->vehicule_type = $this->input->post('vehicule_type');
    $dossier->dossier->towing_vouchers[0]->vehicule_licenceplate = $this->input->post('vehicule_licenceplate');
    $dossier->dossier->towing_vouchers[0]->vehicule_country = $this->input->post('licence_plate_country');

    $dossier->dossier->towing_vouchers[0]->additional_info = $this->input->post('additional_info');

    $dossier->dossier->towing_vouchers[0]->insurance_id = $this->input->post('insurance_id');
    $dossier->dossier->towing_vouchers[0]->insurance_dossiernr = $this->input->post('insurance_dossiernr');
  }
}
