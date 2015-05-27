<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Index extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
      $this->load->library('towing/Invoice_service');
      $this->load->library('table');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
    $this->overview('all');
  }

  public function overview($status)
  {

    $data = array();
    $template = 'invoicing/index';

    switch($status) {
      case 'done':
        $data['dossiers'] = $this->dossier_service->fetchAllClosedDossiers($this->_get_user_token());
        $data['title'] = 'Afgesloten dossiers';
        break;
      case 'batch':
        $template = 'invoicing/index_invoices';
        $data['invoices'] = $this->invoice_service->fetchAllInvoices($this->_get_user_token());
        $data['title'] = 'Facturen';
        break;
      case 'for_invoice':
      default:
        $data['dossiers'] = $this->dossier_service->fetchAllInvoicableDossiers($this->_get_user_token());
        $data['title'] = 'Dossiers voor facturatie';
        break;
    }

    $this->_add_content(
      $this->load->view(
        $template,
        $data,
        true
      )
    );

    $this->_render_page();
  }
}
