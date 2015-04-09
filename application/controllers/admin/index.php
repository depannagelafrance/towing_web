<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Index extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Admin_Service');
      $this->load->library('table');
      $this->load->helper('url');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
      $this->_add_content($this->load->view('admin/index', '', true));
      $this->_render_page();
  }
  
}
