<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Create extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->helper('url');
      $this->load->library('towing/Dossier_service');
    }

  public function index()
  {
    $dossier = $this->dossier_service->createDossier($this->_get_user_token());
    if($dossier) {
      redirect(sprintf("/fast_dispatch/dossier/%s/%s", $dossier->dossier->dossier_number, $dossier->dossier->towing_vouchers[0]->voucher_number));
    }
  }
}
