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

    public function change_password($username, $password, $new_password)
    {
        $result = $this->CI->rest->post('/login/change_password', array(
          "login" => $username,
          "password" => $password,
          "new_password" => $new_password
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
