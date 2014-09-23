<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('page.php');

class Login extends Page {

    public function __construct(){
      parent::__construct();

    	$this->load->helper('form');
    	$this->load->library('form_validation');

      $this->load->library('towing/Login_service');
      $this->load->library('towing/Dossier_service');
      $this->load->library('towing/Vocabulary_service');
    }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->_add_content($this->load->view('login'));
		$this->_render_page();

    var_dump($this->vocabulary_service->fetchAllCountryLicencePlates('TOKEN1'));
	}

  public function perform()
  {
    	$this->form_validation->set_rules('login', 'Login', 'required');
    	$this->form_validation->set_rules('password', 'Password', 'required');

    	if ($this->form_validation->run() === FALSE)
    	{
    		$this->load->view('login');
    	}
    	else
    	{
          $login = $this->input->post('login');
          $password = $this->input->post('password');

          $result = $this->login_service->login($login, $password);

          if(array_key_exists('statusCode', $result)) {
            $this->load->view('login');
          } else {
            echo "<pre>";
            var_dump($result);
            echo "</pre>";
          }
    	}
  }
}
