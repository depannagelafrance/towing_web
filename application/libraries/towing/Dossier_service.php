<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dossier_service {
    private $CI = null;

    public function __construct() {
      $this->CI = get_instance();

      $this->CI->load->spark('restclient/2.2.1');
      $this->CI->load->library('rest');

      // Set config options (only 'server' is required to work)

      $config = array('server'            => 'http://localhost:8443/dossier',
                      //'api_key'         => 'Setec_Astronomy'
                      //'api_name'        => 'X-API-KEY'
                      //'http_user'       => 'username',
                      //'http_pass'       => 'password',
                      //'http_auth'       => 'basic',
                      //'ssl_verify_peer' => TRUE,
                      //'ssl_cainfo'      => '/certs/cert.pem'
                      );

      // Run some setup
      $this->CI->rest->initialize($config);
    }

    public function fetchAllDossiers($token) {
      return $this->CI->rest->get(sprintf('/%s', $token));
    }

    public function fetchAllNewDossiers($token) {
      return $this->CI->rest->get(sprintf('/list/new/%s', $token));
    }

    public function fetchAllCompletedDossiers($token) {
      return $this->CI->rest->get(sprintf('/list/completed/%s', $token));
    }

    public function fetchAllToBeCheckedDossiers($token) {
      return $this->CI->rest->get(sprintf('/list/check/%s', $token));
    }

    public function fetchAllInvoicableDossiers($token) {
      return $this->CI->rest->get(sprintf('/list/invoice/%s', $token));
    }

    public function fetchAllNewVouchers($token) {
      return $this->CI->rest->get(sprintf('/list/vouchers/new/%s', $token));
    }

    public function fetchAllCompletedVouchers($token) {
      return $this->CI->rest->get(sprintf('/list/vouchers/completed/%s', $token));
    }

    public function fetchAllAvailableActivitiesForVoucher($dossier, $voucher, $token) {
      return $this->CI->rest->get(sprintf('/list/available_activities/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchDossierById($dossier, $token) {
      return $this->CI->rest->get(sprintf('/%s/%s', $dossier, $token));
    }


    public function createDossier($token) {
      return $this->CI->rest->post(sprintf('/%s', $token));
    }


    public function updateDossier($dossier, $token) {

    }
}
