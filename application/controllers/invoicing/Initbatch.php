<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Initbatch extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Invoice_service');
      $this->load->library('table');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
    $result = $this->invoice_service->createInvoiceBatch($this->_get_user_token());

    redirect("/invoicing/overview/batch/?id=" . $result->invoice_batch_id, 302);
  }
}
