<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Vocabulary_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

  public function fetchAllInsurances($token) {
    return $this->CI->rest->get(sprintf('/vocab/insurances/%s', $token));
  }

  public function fetchAllCollectors($token) {
    return $this->CI->rest->get(sprintf('/vocab/collectors/%s', $token));
  }

  public function fetchAllDirections($token) {
    return $this->CI->rest->get(sprintf('/vocab/directions/%s', $token));
  }

  public function fetchAllIndicatorsByDirection($direction, $token) {
    if($direction && trim($direction) !== "")
      return $this->CI->rest->get(sprintf('/vocab/indicators/%s/%s', $direction, $token));

    return array();
  }

  public function fetchAllTrafficLanes($token) {
    return $this->CI->rest->get(sprintf('/vocab/traffic_lanes/%s', $token));
  }

  public function fetchAllCountryLicencePlates($token) {
    return $this->CI->rest->get(sprintf('/vocab/country_licence_plates/%s', $token));
  }

  public function fetchAllIncidentTypes($token) {
    return $this->CI->rest->get(sprintf('/vocab/incident_types/%s', $token));
  }
}
