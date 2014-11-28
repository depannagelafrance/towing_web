<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Search extends Page {
  public function __construct()
  {
    parent::__construct();

    $this->load->library('towing/Dossier_service');
    $this->load->library('table');
    $this->load->helper('url');
  }


  /**
  * Index Page for this controller.
  */
  public function index()
  {
    $call_number    = $this->input->post('call_number');
    $call_date      = $this->input->post('call_date');
    $type           = $this->input->post('type');
    $licence_plate  = $this->input->post('licence_plate');
    $name           = $this->input->post('customer_name');
    $token          = $this->_get_user_token();

    $dossiers = $this->dossier_service->searchTowingVouchers($call_number, $call_date, $type, $licence_plate, $name, $token)

    if(count($dossiers) == 1)
    {
      $dossier = array_pop($dossiers);

      redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier_number, $dossier->voucher_number));
    }
    else
    {
      $this->_displaySearchResults($dossiers);
    }
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
      $this->_displaySearchResults($dossiers);
    }
  }

  private _displaySearchResults($results)
  {
    $this->_add_content(
      $this->load->view(
        'fast_dossier/search_results',
        array(
          'vouchers' => $results
        ),
        true
      )
    );

    $this->_render_page();
  }
}
