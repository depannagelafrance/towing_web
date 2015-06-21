<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/Ajaxpage.php');

class Ajax extends AjaxPage
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('towing/Dossier_service');
  }

  public function approveVoucher($voucher_id)
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->approveVoucher($voucher_id, $token);

    $this->_sendJson($result);
  }

  public function startRender()
  {
    $token = $this->_get_user_token();

    $result = $this->dossier_service->startLetterRenderingOfAWVApprovedVouchers($token);

    $this->_sendJson($result);
  }
}
