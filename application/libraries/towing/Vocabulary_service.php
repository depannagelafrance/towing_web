<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vocabulary_service {
  private $CI = null;

  public function __construct() {
    $this->CI = get_instance();

    $this->CI->load->spark('restclient/2.2.1');
    $this->CI->load->library('rest');

    // Set config options (only 'server' is required to work)

    $config = array('server'            => 'http://localhost:8443/vocab',
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

  public function fetchAllInsurances($token) {
    return $this->CI->rest->get(sprintf('/insurances/%s', $token));
  }

  public function fetchAllCollectors($token) {
    return $this->CI->rest->get(sprintf('/collectors/%s', $token));
  }

  public function fetchAllDirections($token) {
    return $this->CI->rest->get(sprintf('/directions/%s', $token));
  }

  public function fetchAllIndicatorsByDirections($direction, $token) {
    return $this->CI->rest->get(sprintf('/indicators/%s/%s', $direction, $token));
  }

  public function fetchAllTrafficLanes($token) {
    return $this->CI->rest->get(sprintf('/traffic_lanes/%s', $token));
  }

  public function fetchAllCountryLicencePlates($token) {
    return $this->CI->rest->get(sprintf('/country_licence_plates/%s', $token));
  }

  public function fetchAllIncidentTypes($token) {
    return $this->CI->rest->get(sprintf('/incident_types/%s', $token));
  }
}
