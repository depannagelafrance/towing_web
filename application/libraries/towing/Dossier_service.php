<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Dossier_model.php');
require_once(APPPATH . '/models/Depot_model.php');
require_once(APPPATH . '/models/File_model.php');
require_once(APPPATH . '/models/Causer_model.php');
require_once(APPPATH . '/models/Customer_model.php');
require_once(APPPATH . '/models/Communication_model.php');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Dossier_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

    public function fetchAllDossiers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/%s', $token));
    }

    public function fetchAllNewDossiers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/new/%s', $token));
    }

    public function fetchAllToBeCheckedDossiers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/check/%s', $token));
    }

    public function fetchAllInvoicableDossiers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/invoice/%s', $token));
    }

    public function fetchAllClosedDossiers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/done/%s', $token));
    }

    public function fetchAllNewVouchers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/vouchers/new/%s', $token));
    }

    public function fetchAllCompletedVouchers($token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/vouchers/completed/%s', $token));
    }

    public function fetchAllAvailableActivitiesForVoucher($dossier, $voucher, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/available_activities/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchDossierById($dossier, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/%s/%s', $dossier, $token));
    }

    public function fetchDossierByNumber($dossier, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/find/dossier_number/%s/%s', $dossier, $token));
    }

    public function fetchAvailableAllotments($direction, $indicator, $token)
    {
      if($indicator && trim($indicator) != "") {
        return $this->CI->rest->get(sprintf('/dossier/list/available_allotments/direction/%s/indicator/%s/%s', $direction, $indicator, $token));
      } else {
        return $this->CI->rest->get(sprintf('/dossier/list/available_allotments/direction/%s/%s', $direction, $token));
      }
    }

    public function fetchVoucherDepot($dossier, $voucher, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/depot/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchVoucherCauser($dossier, $voucher, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/causer/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchVoucherCustomer($dossier, $voucher, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/customer/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchAllTrafficPostsByAllotment($allotment, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/traffic_posts/allotment/%s/%s', $allotment, $token));
    }

    public function fetchAllTrafficLanes($dossier_id, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/list/traffic_lanes/%s/%s', $dossier_id, $token));
    }

    public function createDossier($token)
    {
      return $this->CI->rest->post(sprintf('/dossier/%s', $token));
    }

    public function createTowingVoucherForDossier($dossier_id, $token)
    {
      return $this->CI->rest->post(sprintf('/dossier/voucher/%s/%s', $dossier_id, $token));
    }

    public function updateDossier(Dossier_model $dossier, $token)
    {
      $_dossier = new stdClass();
      $_dossier->dossier = $dossier;

      return $this->CI->rest->put(
          sprintf('/dossier/%s/%s', $dossier->id, $token),
          json_encode($_dossier),
          'application/json'
      );
    }

    public function removeActivityFromVoucher($voucher_id, $activity_id, $token)
    {
      return $this->CI->rest->delete(
        sprintf('/dossier/voucher/%s/activity/%s/%s', $voucher_id, $activity_id, $token)
      );
    }

    public function updateTowingDepot($depot_id, $voucher_id, Depot_model $depot, $token)
    {
      $_depot = new stdClass();
      $_depot->depot = $depot;

      return $this->CI->rest->put(
          sprintf('/dossier/depot/%s/%s/%s', $depot_id, $voucher_id, $token),
          json_encode($_depot),
          'application/json'
      );
    }

    public function updateCustomer($customer_id, $voucher_id, Customer_model $data, $token)
    {
      $_value = new stdClass();
      $_value->customer = $data;

      return $this->CI->rest->put(
          sprintf('/dossier/customer/%s/%s/%s', $customer_id, $voucher_id, $token),
          json_encode($_value),
          'application/json'
      );
    }

    public function updateCauser($causer_id, $voucher_id, Causer_model $data, $token)
    {
      $_value = new stdClass();
      $_value->causer = $data;

      return $this->CI->rest->put(
          sprintf('/dossier/causer/%s/%s/%s', $causer_id, $voucher_id, $token),
          json_encode($_value),
          'application/json'
      );
    }

    //TODO: remove $voucher_id from query string and place into file_model
    public function addInsuranceDocumentToVoucher($voucher_id, File_model $file, $token)
    {
      return $this->CI->rest->post(
          sprintf('/voucher/attachment/insurance_document/%s/%s', $voucher_id, $token),
          json_encode($file),
          'application/json'
      );
    }

    public function fetchAllInternalCommunications($dossier_id, $voucher_id, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/communication/internal/%s/%s/%s', $dossier_id, $voucher_id, $token));
    }

    public function fetchAllEmailCommunications($dossier_id, $voucher_id, $token)
    {
      return $this->CI->rest->get(sprintf('/dossier/communication/email/%s/%s/%s', $dossier_id, $voucher_id, $token));
    }

    public function addInternalCommunication(Communication_model $model, $token)
    {
      return $this->CI->rest->post(
          sprintf('/dossier/communication/internal/%s', $token),
          json_encode($model),
          'application/json'
      );
    }

    public function addEmailCommunication(Communication_model $model, $token)
    {
      $result = $this->CI->rest->post(
          sprintf('/dossier/communication/email/%s', $token),
          json_encode($model),
          'application/json'
      );

      return $result;
    }

    public function requestCollectorSignature($dossier_id, $voucher_id, $token)
    {
      $result = $this->CI->rest->post(
          sprintf('/dossier/signature/collector/%s/%s/%s', $dossier_id, $voucher_id, $token),
          json_encode(array("dossier" => $dossier_id, "voucher" => $voucher_id)),
          'application/json'
      );

      return $result;
    }

    public function requestCauserSignature($dossier_id, $voucher_id, $token)
    {
      $result = $this->CI->rest->post(
        sprintf('/dossier/signature/causer/%s/%s/%s', $dossier_id, $voucher_id, $token),
        json_encode(array("dossier" => $dossier_id, "voucher" => $voucher_id)),
        'application/json'
      );

      return $result;
    }

    public function requestTrafficPostSignature($dossier_id, $voucher_id, $token)
    {
      $result = $this->CI->rest->post(
        sprintf('/dossier/signature/police/%s/%s/%s', $dossier_id, $voucher_id, $token),
        json_encode(array("dossier" => $dossier_id, "voucher" => $voucher_id)),
        'application/json'
      );

      return $result;
    }

    public function searchTowingVouchers($call_number, $call_date, $type, $licence_plate, $name, $token)
    {
      $result = $this->CI->rest->post(
              sprintf('/search/%s', $token),
              json_encode(array(
                "call_number"   => $call_number,
                "call_date"     => $call_date,
                "type"          => $type,
                "licence_plate" => $licence_plate,
                "name"          => $name
              )),
              'application/json'
    );

    return $result;
  }

  public function searchTowingVoucherByNumber($number, $token)
  {
    $result = $this->CI->rest->post(
          sprintf('/search/towing_voucher/%s', $token),
          json_encode(array("number" => $number)),
          'application/json'
    );

    return $result;
  }


}
