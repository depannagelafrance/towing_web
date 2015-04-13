<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rest_Service {
    protected $CI = null;

    public function __construct() {
      $this->CI =& get_instance();

      $this->CI->load->spark('restclient/2.2.1');
      $this->CI->load->library('rest');

      // Set config options (only 'server' is required to work)

      $config = array('server'            => $this->CI->config->item('towing_api'),
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
}
