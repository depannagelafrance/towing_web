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
      $this->load->helper('restdata');
    }

  /**
   * Index Page for this controller.
   */
  public function view($dossier_number, $voucher_number = null)
  {
    $token = $this->_get_user_token();

    //a dossier might be set in the cached data when an update occured. So no need to refetch.
    $dossier = $this->_pop_Dossier_cache();

    if(!$dossier) {
      $dossier = $this->dossier_service->fetchDossierByNumber($dossier_number, $token);
    }

    $this->_loadDossierView($token, $dossier, $voucher_number);

  }

  public function save($number, $voucher_number) {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);
    // $this->form_validation->set_rules('direction', 'Richting', 'required');
    // $this->form_validation->set_rules('indicator', 'KM Paal', 'required');
    // $this->form_validation->set_rules('incident_type', 'Type incident', 'required');
    // $this->form_validation->set_rules('call_number', 'Oproepnummer', 'required');
    // $this->form_validation->set_rules('vehicule_type', 'Type wagen', 'required');

    // if ($this->form_validation->run() === FALSE)
    // {
    //
    //   $this->_setDossierValuesFromPostRequest($dossier);
    //   $this->_loadDossierView($token, $dossier);
    // }
    // else
    // {
      if($dossier && $dossier->dossier) {
        $this->_setDossierValuesFromPostRequest($dossier, $voucher_number);

        $dossier = $this->dossier_service->updateDossier(new Dossier_model($dossier), $token);

        if($dossier)
        {
          //for performance improvements, put the dossier in the flash data cache
          $this->_cache_Dossier($dossier);

          //redirect to the view
          redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher_number));
        }
      }
    // }
  }


  public function voucher($dossier_id) {
    $dossier = $this->dossier_service->createTowingVoucherForDossier($dossier_id, $this->_get_user_token());

    if($dossier) {
      //for performance improvements, put the dossier in the flash data cache
      $this->session->set_user_data('dossier_cache', $dossier);

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

  private function _setDossierValuesFromPostRequest($dossier, $voucher_number) {

    $dossier->dossier->police_traffic_post_id = toIntegerValue($this->input->post('traffic_post_id'));

    for($i = 0; $i < sizeof($dossier->dossier->towing_vouchers); $i++) {

      $voucher = $dossier->dossier->towing_vouchers[$i];

      if($voucher->voucher_number == $voucher_number) {

        $voucher->vehicule_type = $this->input->post('vehicule_type');
        $voucher->vehicule_licenceplate = $this->input->post('vehicule_licenceplate');
        $voucher->vehicule_country = $this->input->post('licence_plate_country');

        $voucher->additional_info = $this->input->post('additional_info');

        $voucher->insurance_id = $this->input->post('insurance_id');
        $voucher->insurance_dossiernr = $this->input->post('insurance_dossiernr');

        $voucher->collector_id = toIntegerValue($this->input->post('collector_id'));
        $voucher->vehicule_collected = toMySQLDate($this->input->post('vehicule_collected'));

        $dossier->dossier->towing_vouchers[$i] = $voucher;
      }
    }
  }
}
