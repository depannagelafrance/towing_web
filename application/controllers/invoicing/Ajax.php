<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Ajaxpage.php');

class Ajax extends AjaxPage
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('towing/Invoice_service');
  }

  public function createInvoiceForVoucher()
  {
    $voucher_id = $this->input->post('voucher_id');
    $message    = $this->input->post('message');

    $result = $this->invoice_service->createInvoiceForVoucher($voucher_id, $message, $this->_get_user_token());

    $this->_sendJson($result);
  }

  public function createStorageInvoiceForVoucher($voucher_id) {
    $result = $this->invoice_service->createStorageInvoiceForVoucher($voucher_id, $this->_get_user_token());

    $this->_sendJson($result);
  }
}
