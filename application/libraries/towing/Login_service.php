<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_Service.php');

class Login_Service extends Rest_Service {
    public function __construct() {
      parent::__construct();
    }

    public function login($username, $password) {
      $result = $this->CI->rest->post('/login/', array(
        "login" => $username,
        "password" => $password
      ));

      return $result;
    }

    public function authenticateToken($token) {
      $result = $this->CI->rest->post('/login/token', array(
        "token" => $token
      ));

      return $result;
    }
}
