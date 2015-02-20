<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/ajaxpage.php');
require_once(APPPATH . '/models/Depot_model.php');
require_once(APPPATH . '/models/Causer_model.php');
require_once(APPPATH . '/models/Customer_model.php');
require_once(APPPATH . '/models/File_model.php');


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

    $depot = new Depot_model($this->input->post('depot'));
    $depot_id = $depot->id;

    $result = $this->dossier_service->updateTowingDepot($depot_id, $voucher_id, $depot, $token);

    $this->_sendJson($result);
  }

  public function updateDepotToDefault($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();
    $depot = new Depot_model($this->_get_company_depot());
    $depot->default_depot = 1;
    $depot_id = $depot->id;

    $result = $this->dossier_service->updateTowingDepot($depot_id, $voucher_id, $depot, $token);

    $this->_sendJson($result);
  }

  public function updateCauser($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $causer = new Causer_model($this->input->post('causer'));

    $result = $this->dossier_service->updateCauser($causer->id, $voucher_id, $causer, $token);

    $this->_sendJson($result);
  }

  public function updateCustomer($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $customer = new Customer_model($this->input->post('customer'));

    $result = $this->dossier_service->updateCustomer($customer->id, $voucher_id, $customer, $token);

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

    $model = new Communication_model($this->input->post('communication'));

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

    $model = new Communication_model($this->input->post('communication'));

    $result = $this->dossier_service->addEmailCommunication($model, $token);

    $this->_sendJson($result);
  }

  public function getEmailCommunication($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllEmailCommunications($dossier_id,$voucher_id, $token);

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
    $file = new File_model($this->input->post('file'));
    $result = $this->dossier_service->addAttachment($dossier_id, $voucher_id, $file, $token);
    $this->_sendJson($result);
  }

  public function getAttachments($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllAttachments($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

}
