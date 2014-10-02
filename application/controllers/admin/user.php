<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class User extends Page {
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
      $users = $this->admin_service->fetchAllUsers($this->_get_user_token());
      $this->_add_content(
        $this->load->view(
            'admin/user', 
            array(
                'users' => $users
                ),
            true
        )
      );
      $this->_render_page();
  }
  
  public function create(){
      $this->load->helper('form');
      
      if($this->input->post('submit')){
           
          $this->load->library("form_validation");
          if (!$this->form_validation->run())
          {
              die('valid');
              $this->_add_content($this->load->view('login', '', true));
          }
          else
          {
              //show validation error
              $this->data["status"]->message = validation_errors();
              $this->data["status"]->success = FALSE;
          }
      }
      
      else
      {
          $this->_add_content($this->load->view('admin/users/create', '', true));
      }
      
      $this->_render_page();
  }
}
