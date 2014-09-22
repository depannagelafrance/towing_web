<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_service {
    private $CI = null;

    public function __construct() {
      $this->CI = get_instance();

      $this->CI->load->spark('restclient/2.2.1');
      $this->CI->load->library('rest');

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
      $this->CI->rest->initialize($config);
    }

    public function login($username, $password) {

      $params = array(
        "login" => $username,
        "password" => $password
      );

      // Pull in an array of tweets
      $result = $this->CI->rest->post('/',$params);

      return $result;
    }
}
