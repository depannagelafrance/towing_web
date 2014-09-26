<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

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

    $this->_add_content(
      $this->load->view(
        'fast_dispatch/dossier',
          array(
            'dossier'                 => $dossier,
            'incident_types'          => $this->vocabulary_service->fetchAllIncidentTypes($token),
            'insurances'              => $this->vocabulary_service->fetchAllInsurances($token),
            'directions'              => $this->vocabulary_service->fetchAllDirections($token),
            'traffic_lanes'           => $this->vocabulary_service->fetchAllTrafficLanes($token),
            'licence_plate_countries' => $this->vocabulary_service->fetchAllCountryLicencePlates($token)
          ),
          true
      )
    );

    $this->_render_page();
  }

}
