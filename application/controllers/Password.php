<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('Page.php');
//require_once(APPPATH . 'models/Vocabulary_Model.php');

class Password extends Page {

  public function __construct(){
    parent::__construct();

    $this->load->helper('form');
    $this->load->helper('url');

   	$this->load->library('form_validation');

    $this->load->library('towing/Login_service');
  }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
      $this->_renderChangePasswordPage();
	}

  private function _renderChangePasswordPage()
  {
    $data = array();
    $data['title'] = 'Wachtwoord aanpassen';

    $this->_add_content($this->load->view('password', $data, true));
    $this->_render_page('login_container');
  }

  public function perform()
  {
    	$this->form_validation->set_rules('login', 'Gebruikersnaam', 'required');
    	$this->form_validation->set_rules('current_pwd', 'Huidig wachtwoord', 'required');
    	$this->form_validation->set_rules('new_pwd_1', 'Nieuw wachtwoord', 'required|min_length[6]');
    	$this->form_validation->set_rules('new_pwd_2', 'Nieuw wachtwoord (2)', 'required|matches[new_pwd_1]');

    	if ($this->form_validation->run() === FALSE)
    	{
        $this->_add_content($this->load->view('password', '', true));
        $this->_render_page('login_container');
      }
    	else
    	{
        $login = $this->input->post('login');
        $password = $this->input->post('current_pwd');
        $new_password = $this->input->post('new_pwd_1');

        $result = $this->login_service->change_password($login, $password, $new_password);

        if(!$result || array_key_exists('statusCode', $result))
        {
          $this->_add_error('Authentication failed');
          $this->_add_content($this->load->view('password', '', true));
          $this->_render_page('login_container');
        }
        else
        {
          redirect("/login");
          exit;
        }
      }
  }
}
