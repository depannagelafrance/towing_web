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

    $customer_amount = $this->input->post('invoice_payment_amount_customer');
    $customer_ptype  = $this->input->post('invoice_payment_type_customer');

    $collector_amount = $this->input->post('invoice_payment_amount_collector');
    $collector_ptype  = $this->input->post('invoice_payment_type_collector');

    $assurance_amount = $this->input->post('invoice_payment_amount_assurance');
    $assurance_ptype  = $this->input->post('invoice_payment_type_assurance');

    $result = $this->invoice_service->createInvoiceForVoucher(
          $voucher_id,
          $customer_amount, $customer_ptype,
          $collector_amount, $collector_ptype,
          $assurance_amount, $assurance_ptype,
          $message, $this->_get_user_token());

    $this->_sendJson($result);
  }

  public function createStorageInvoiceForVoucher($voucher_id) {
    $result = $this->invoice_service->createStorageInvoiceForVoucher($voucher_id, $this->_get_user_token());

    $this->_sendJson($result);
  }
}
