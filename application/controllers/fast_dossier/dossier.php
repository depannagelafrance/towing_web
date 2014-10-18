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
      $this->load->library('session');

      $this->load->helper('form');
      $this->load->helper('url');

    }

  /**
   * Index Page for this controller.
   */
  public function view($dossier_number, $voucher_number = null)
  {
    $token = $this->_get_user_token();

    //a dossier might be set in the flash data when and update occured. So no need to refetch.
    if($this->session->flashdata('dossier_cache')) {
      $dossier = $this->session->flashdata('dossier_cache');
    } else {
      $dossier = $this->dossier_service->fetchDossierByNumber($dossier_number, $token);
    }

    $this->_loadDossierView($token, $dossier, $voucher_number);

  }

  public function save($number) {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);
    $this->form_validation->set_rules('direction', 'Richting', 'required');
    $this->form_validation->set_rules('indicator', 'KM Paal', 'required');
    $this->form_validation->set_rules('incident_type', 'Type incident', 'required');
    $this->form_validation->set_rules('call_number', 'Oproepnummer', 'required');
    $this->form_validation->set_rules('vehicule_type', 'Type wagen', 'required');

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

        if($dossier)
        {
          //for performance improvements, put the dossier in the flash data cache
          $this->session->set_flashdata('dossier_cache', $dossier);

          //redirect to the view
          redirect(sprintf("/fast_dossier/dossier/%s", $dossier->dossier->dossier_number));
        }
      }
    }
  }


  public function voucher($dossier_id) {
    $dossier = $this->dossier_service->createTowingVoucherForDossier($dossier_id, $this->_get_user_token());

    if($dossier) {
      //for performance improvements, put the dossier in the flash data cache
      $this->session->set_flashdata('dossier_cache', $dossier);

      //redirect to the view
      redirect(sprintf("/fast_dossier/dossier/%s", $dossier->dossier->dossier_number));
    }
  }


  private function _loadDossierView($token, $dossier, $voucher_number = null) {
    $this->_add_content(
      $this->load->view(
        'fast_dossier/dossier',
          array(
            'dossier'                 => $dossier,
            'voucher_number'          => $voucher_number,
            'vouchers'                => $this->dossier_service->fetchAllNewVouchers($token),
            'traffic_posts'           => $this->dossier_service->fetchAllTrafficPostsByAllotment($dossier->dossier->allotment_id, $token),
            'insurances'              => $this->vocabulary_service->fetchAllInsurances($token),
            'collectors'              => $this->vocabulary_service->fetchAllCollectors($token),
            'licence_plate_countries' => $this->vocabulary_service->fetchAllCountryLicencePlates($token)
          ),
          true
      )
    );

    $this->_render_page();
  }

  private function _setDossierValuesFromPostRequest($dossier) {
    $dossier->dossier->call_number = $this->input->post('call_number');
    $dossier->dossier->company_id = 1;
    $dossier->dossier->incident_type_id = $this->input->post('incident_type');
    $dossier->dossier->allotment_id = 1;
    $dossier->dossier->allotment_direction_id = $this->input->post('direction');
    $dossier->dossier->allotment_direction_indicator_id = $this->input->post('indicator');

    $dossier->dossier->towing_vouchers[0]->vehicule_type = $this->input->post('vehicule_type');
    $dossier->dossier->towing_vouchers[0]->vehicule_licenceplate = $this->input->post('vehicule_licenceplate');
    $dossier->dossier->towing_vouchers[0]->vehicule_country = $this->input->post('licence_plate_country');

    $dossier->dossier->towing_vouchers[0]->additional_info = $this->input->post('additional_info');
  }
}
