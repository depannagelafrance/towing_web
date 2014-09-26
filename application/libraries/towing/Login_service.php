<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Login_service extends Rest_service {
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
}
