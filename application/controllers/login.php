<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('page.php');
require_once(APPPATH . '/models/Vocabulary_model.php');

class Login extends Page {

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
		$this->_add_content($this->load->view('login', '', true));
		$this->_render_page();
	}

  public function perform()
  {
    	$this->form_validation->set_rules('login', 'Login', 'required');
    	$this->form_validation->set_rules('password', 'Password', 'required');

    	if ($this->form_validation->run() === FALSE)
    	{
        $this->_add_content($this->load->view('login', '', true));
    	}
    	else
    	{
          $login = $this->input->post('login');
          $password = $this->input->post('password');

          $result = $this->login_service->login($login, $password);

          if(!$result || array_key_exists('statusCode', $result)) {
            $this->_add_error('Authentication failed');
            $this->_add_content($this->load->view('login', '', true));
          } else {
            $this->_set_authenticated_user($result);
            //$this->_add_content($this->load->view('login', '', true));

            $modules = $this->_get_available_modules();

            if($modules && ($module = array_pop($modules))) {
              redirect(sprintf("/%s/index",strtolower($module->code)));
              exit;
            }
          }
    	}

      $this->_render_page();
  }
}
