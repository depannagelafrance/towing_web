<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/Ajaxpage.php');
require_once(APPPATH . '/models/Depot_Model.php');
require_once(APPPATH . '/models/Causer_Model.php');
require_once(APPPATH . '/models/Customer_Model.php');
require_once(APPPATH . '/models/File_Model.php');


class Ajax extends AjaxPage
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('towing/Dossier_service');
    $this->load->library('towing/Vocabulary_service');
  }

  public function updateDepot($dossier_id, $voucher_id)
  {

    $token = $this->_get_user_token();

    $depot = new Depot_Model($this->input->post('depot'));
    $depot_id = $depot->id;

    $result = $this->dossier_service->updateTowingDepot($depot_id, $voucher_id, $depot, $token);

    $this->_sendJson($result);
  }

  public function updateDepotToDefault($dossier_id, $voucher_id)
  {
    $_depot = $this->input->post('depot');

    $token = $this->_get_user_token();
    $depot = new Depot_Model($this->_get_company_depot());
    $depot->default_depot = 1;
    $depot->id = $_depot['id'];
    $depot_id = $depot->id;

    $result = $this->dossier_service->updateTowingDepot($depot_id, $voucher_id, $depot, $token);

    $this->_sendJson($result);
  }

  public function updateDepotToAgency($dossier_id, $voucher_id)
  {
    $_depot = $this->input->post('depot');

    $token = $this->_get_user_token();
    $result = $this->dossier_service->updateTowingDepotToAgency($_depot['id'], $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function updateCauser($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $causer = new Causer_Model($this->input->post('causer'));

    $result = $this->dossier_service->updateCauser($causer->id, $voucher_id, $causer, $token);

    $this->_sendJson($result);
  }

  public function updateCustomer($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $customer = new Customer_Model($this->input->post('customer'));

    $result = $this->dossier_service->updateCustomer($customer->id, $voucher_id, $customer, $token);

    $this->_sendJson($result);
  }

  public function searchCustomer()
  {
    $token = $this->_get_user_token();

    $find = $this->input->post('search');
    $result = $this->dossier_service->searchCustomer($find, $token);

    $this->_sendJson($result);
  }

  public function updateAgencyCustomer($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->updateCustomerToAgency($voucher_id, $token);

    $this->_sendJson($result);
  }

  public function depot($dossier_id, $voucher_id)
  {
    return $this->_sendJson($this->dossier_service->fetchVoucherDepot($dossier_id, $voucher_id, $this->_get_user_token()));
  }

  public function customer($dossier_id, $voucher_id)
  {
    return $this->_sendJson($this->dossier_service->fetchVoucherCustomer($dossier_id, $voucher_id, $this->_get_user_token()));
  }

  public function causer($dossier_id, $voucher_id)
  {
    return $this->_sendJson($this->dossier_service->fetchVoucherCauser($dossier_id, $voucher_id, $this->_get_user_token()));
  }

  public function activities($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();
    $result = $this->dossier_service->fetchActivitiesForVoucher($dossier_id, $voucher_id, $token);
    $this->_sendJson($result);
  }

  public function additionalCosts($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();
    $result = $this->dossier_service->fetchAllVoucherAdditionalCosts($dossier_id, $voucher_id, $token);
    $this->_sendJson($result);
  }

  public function paymentDetails($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();
    $result = $this->dossier_service->fetchVoucherPaymentDetails($dossier_id, $voucher_id, $token);
    $this->_sendJson($result);
  }




  public function availableActivities($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllAvailableActivitiesForVoucher($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function insurances() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllInsurances($token);

    $this->_sendJson($result);
  }

  public function collectors() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllCollectors($token);

    $this->_sendJson($result);
  }

  public function directions() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllDirections($token);

    $this->_sendJson($result);
  }

  public function indicators($direction) {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllIndicatorsByDirection($direction, $token);

    $this->_sendJson($result);
  }

  public function licencePlateCountries() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllCountryLicencePlates($token);

    $this->_sendJson($result);
  }

  public function signaDrivers() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllSignaDrivers($token);

    $this->_sendJson($result);
  }

  public function towingDrivers() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllTowingDrivers($token);

    $this->_sendJson($result);
  }

  public function towingVehicles() {
    $token = $this->_get_user_token();

    $result = $this->vocabulary_service->fetchAllTowingVehicles($token);

    $this->_sendJson($result);
  }

  public function removeActivityFromVoucher($voucher_id, $activity_id)
  {

    $activity_id = intval ($activity_id);

    $this->_sendJson(
      $this->dossier_service->removeActivityFromVoucher(
        $voucher_id,
        $activity_id,
        $this->_get_user_token()
      )
    );
  }

  public function removeAdditionalCostFromVoucher($voucher_id, $cost_id)
  {

    $_cost_id = intval ($cost_id);

    $this->_sendJson(
      $this->dossier_service->removeVoucherAdditionalCost(
        $_cost_id,
        $voucher_id,
        $this->_get_user_token()
      )
    );
  }

  public function addActivitiesToVoucher($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    //array of ids
    $activities = $this->input->post('activities');

    $result = $this->dossier_service->addActivitiesToVoucher($dossier_id, $voucher_id, $activities, $token);
    $this->_sendJson($result);
  }

  public function addInternalCommunication()
  {
    $token = $this->_get_user_token();

    $model = new Communication_Model($this->input->post('communication'));

    $result = $this->dossier_service->addInternalCommunication($model, $token);

    $this->_sendJson($result);
  }

  public function getInternalCommunication($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllInternalCommunications($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function addEmailCommunication()
  {
    $token = $this->_get_user_token();

    $model = new Communication_Model($this->input->post('communication'));

    $result = $this->dossier_service->addEmailCommunication($model, $token);

    $this->_sendJson($result);
  }

  public function getEmailCommunication($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllEmailCommunications($dossier_id,$voucher_id, $token);

    $this->_sendJson($result);
  }

  public function sendVoucherEmailToAWV($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->sendVoucherEmailToAWV($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function requestCollectorSignature($dossier_id, $voucher_id) {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->requestCollectorSignature($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function requestCauserSignature($dossier_id, $voucher_id) {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->requestCauserSignature($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function requestTrafficPostSignature($dossier_id, $voucher_id) {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->requestTrafficPostSignature($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }


  public function addAttachment($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();
    $file = new File_Model($this->input->post('file'));
    $result = $this->dossier_service->addAttachment($dossier_id, $voucher_id, $file, $token);
    $this->_sendJson($result);
  }

  public function getAttachments($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllAttachments($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function fetchValidationMessages($voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllVoucherValidationMessages($voucher_id, $token);

    $this->_sendJson($result);
  }
}
