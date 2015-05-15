<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Index extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
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

    switch($status) {
      case 'done':
        $dossiers = $this->dossier_service->fetchAllClosedDossiers($this->_get_user_token());
        $title = 'Afgesloten dossiers';
        break;
      case 'for_invoice':
      default:
        $dossiers = $this->dossier_service->fetchAllInvoicableDossiers($this->_get_user_token());
        $title = 'Dossiers voor facturatie';
        break;
    }

    $this->_add_content(
      $this->load->view(
        'invoicing/index',
        array(
          'dossiers' => $dossiers,
          'title' => $title
        ),
        true
      )
    );

    $this->_render_page();
  }
}
