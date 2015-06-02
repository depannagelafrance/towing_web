<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Export extends Page
{
  public function __construct(){
    parent::__construct();

    $this->load->library('towing/Invoice_service');

    $this->load->helper('form');
  }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
    //ignore
  }

  public function expertm()
  {
    $invoice_ids = $this->input->post('selected_invoice_id');

    if($invoice_ids != null && is_array($invoice_ids) && count($invoice_ids) > 0)
      $this->invoice_service->createExpertMInvoiceExport($invoice_ids, $this->_get_user_token());
    else
      redirect("/invoicing/overview/batch", 302);
  }
}
