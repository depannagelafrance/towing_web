<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Dossier_model.php');
require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Dossier_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

    public function fetchAllDossiers($token) {
      return $this->CI->rest->get(sprintf('/dossier/%s', $token));
    }

    public function fetchAllNewDossiers($token) {
      return $this->CI->rest->get(sprintf('/dossier/list/new/%s', $token));
    }

    public function fetchAllCompletedDossiers($token) {
      return $this->CI->rest->get(sprintf('/dossier/list/completed/%s', $token));
    }

    public function fetchAllToBeCheckedDossiers($token) {
      return $this->CI->rest->get(sprintf('/dossier/list/check/%s', $token));
    }

    public function fetchAllInvoicableDossiers($token) {
      return $this->CI->rest->get(sprintf('/dossier/list/invoice/%s', $token));
    }

    public function fetchAllNewVouchers($token) {
      return $this->CI->rest->get(sprintf('/dossier/list/vouchers/new/%s', $token));
    }

    public function fetchAllCompletedVouchers($token) {
      return $this->CI->rest->get(sprintf('/dossier/list/vouchers/completed/%s', $token));
    }

    public function fetchAllAvailableActivitiesForVoucher($dossier, $voucher, $token) {
      return $this->CI->rest->get(sprintf('/dossier/list/available_activities/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchDossierById($dossier, $token) {
      return $this->CI->rest->get(sprintf('/dossier/%s/%s', $dossier, $token));
    }

    public function fetchDossierByNumber($dossier, $token) {
      return $this->CI->rest->get(sprintf('/dossier/find/dossier_number/%s/%s', $dossier, $token));
    }

    public function fetchAvailableAllotments($direction, $indicator, $token) {
      if($indicator && trim($indicator) != "") {
        return $this->CI->rest->get(sprintf('/dossier/list/available_allotments/direction/%s/indicator/%s/%s', $direction, $indicator, $token));
      } else {
        return $this->CI->rest->get(sprintf('/dossier/list/available_allotments/direction/%s/%s', $direction, $token));
      }
    }

    public function createDossier($token) {
      return $this->CI->rest->post(sprintf('/dossier/%s', $token));
    }

    public function updateDossier(Dossier_model $dossier, $token) {

      $_dossier = new stdClass();
      $_dossier->dossier = $dossier;

      return $this->CI->rest->put(
          sprintf('/dossier/%s/%s', $dossier->id, $token),
          json_encode($_dossier),
          'application/json');
    }
}
