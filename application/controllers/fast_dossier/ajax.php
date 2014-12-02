<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/ajaxpage.php');
require_once(APPPATH . '/models/Depot_model.php');
require_once(APPPATH . '/models/Causer_model.php');
require_once(APPPATH . '/models/Customer_model.php');

class Ajax extends AjaxPage
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('towing/Dossier_service');
  }

  public function updateDepot($dossier_id, $voucher_id)
  {

    $token = $this->_get_user_token();

    $depot = new Depot_model($this->input->post('depot'));

    $result = $this->dossier_service->updateTowingDepot($dossier_id, $voucher_id, $depot, $token);

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

  public function depot($dossier, $voucher_id)
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

  public function availableActivities($dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->fetchAllAvailableActivitiesForVoucher($dossier_id, $voucher_id, $token);

    $this->_sendJson($result);
  }

  public function addInternalCommunication()
  {
    $token = $this->_get_user_token();

    $model = new Communication_model($this->input->post('communication'));

    $result = $this->dossier_service->addInternalCommunication($model, $token);

    $this->_sendJson($result);
  }

  public function addEmailCommunication()
  {
    $token = $this->_get_user_token();

    $model = new Communication_model($this->input->post('communication'));

    $result = $this->dossier_service->addEmailCommunication($model, $token);

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

}
