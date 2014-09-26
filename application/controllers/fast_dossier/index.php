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
    $new_vouchers = $this->dossier_service->fetchAllNewVouchers($this->_get_user_token());

    $this->_add_content(
      $this->load->view(
        'fast_dispatch/index',
        array(
          'vouchers' => $new_vouchers
        ),
        true
      )
    );

    $this->_render_page();
  }
}
