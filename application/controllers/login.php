<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('page.php');

class Login extends Page {

    public function __construct(){
        parent::__construct();
        $this->load->spark('restclient/2.2.1');
        $this->load->library('rest');
    }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->_add_content($this->load->view('login'));
		$this->_render_page();

    // Set config options (only 'server' is required to work)

    $config = array('server'            => 'http://localhost:8443/login',
                    //'api_key'         => 'Setec_Astronomy'
                    //'api_name'        => 'X-API-KEY'
                    //'http_user'       => 'username',
                    //'http_pass'       => 'password',
                    //'http_auth'       => 'basic',
                    //'ssl_verify_peer' => TRUE,
                    //'ssl_cainfo'      => '/certs/cert.pem'
                    );

    // Run some setup
    $this->rest->initialize($config);

//invalid login
    $params = array(
      "login" => "test",
      "password" => "test"
    );

    // Pull in an array of tweets
    $result = $this->rest->post('/',$params);
    var_dump($result);

//valid login
    $params = array(
      "login" => "admin",
      "password" => "T0w1nG"
    );

    // Pull in an array of tweets
    $result = $this->rest->post('/',$params);
    var_dump($result);
	}
}
