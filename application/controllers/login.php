<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('page.php');

class Login extends Page {

    public function __construct(){
        parent::__construct();
    }
    
	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->_add_content($this->load->view('login'));
		$this->_render_page();
	}
}