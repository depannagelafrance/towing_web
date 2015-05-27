<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Ajaxpage.php');

class Ajax extends AjaxPage
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('towing/Invoice_service');
  }

  /**
   * Index Page for this controller.
   */
  public function createInvoiceForVoucher($voucher_number)
  {
    $result = $this->invoice_service->createInvoiceForVoucher($voucher_number, $this->_get_user_token());

    $this->_sendJson($result);
  }
}
