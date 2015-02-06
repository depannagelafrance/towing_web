<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

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
    $this->overview('new');
  }

  public function overview($status)
  {

    switch($status) {
      case 'to_check':
        $dossiers = $this->dossier_service->fetchAllToBeCheckedDossiers($this->_get_user_token());
        $title = 'Dossiers ter controle';
        break;
      case 'for_invoice':
        $dossiers = $this->dossier_service->fetchAllInvoicableDossiers($this->_get_user_token());
        $title = 'Dossiers voor facturatie';
        break;
      case 'done':
        $dossiers = $this->dossier_service->fetchAllClosedDossiers($this->_get_user_token());
        $title = 'Afgesloten dossiers';
        break;
      case 'not_collected':
        $dossiers = $this->dossier_service->fetchAllNotCollectedDossiers($this->_get_user_token());
        $title = 'Niet afgehaalde voertuigen';
        break;
      default:
        $dossiers = $this->dossier_service->fetchAllNewDossiers($this->_get_user_token());
        $title = 'Actieve dossiers';
    }

    $this->_add_content(
      $this->load->view(
        'fast_dossier/index',
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
