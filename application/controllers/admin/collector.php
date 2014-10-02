<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Collector extends Page {
    
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Admin_service');
      $this->load->library('table');
      $this->load->helper('url');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
      
      $this->_add_content($this->load->view('admin/index'));
  }
  
}
