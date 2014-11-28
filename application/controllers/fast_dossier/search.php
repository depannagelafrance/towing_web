<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Search extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
      $this->load->library('table');
      $this->load->helper('url');
    }

  /**
   * Index Page for this controller.
   */
  public function voucher()
  {
    $dossiers = $this->dossier_service->searchTowingVoucherByNumber($this->input->post('searchVoucherNumber'), $this->_get_user_token());

    if(count($dossiers) == 1)
    {
      $dossier = array_pop($dossiers);

      redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier_number, $dossier->voucher_number));
    }
    else
    {
      $this->_add_content(
        $this->load->view(
          'fast_dossier/search_results',
          array(
            'vouchers' => $dossiers
          ),
          true
        )
      );
      $this->_render_page();
    }
  }
}
