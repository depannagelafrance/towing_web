<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vocabulary_service {
  private $CI = null;

  public function __construct() {
    $this->CI = get_instance();

    $this->CI->load->spark('restclient/2.2.1');
    $this->CI->load->library('rest');

    // Set config options (only 'server' is required to work)

    $config = array('server'            => 'http://localhost:8443/admin',
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

  public function fetchAllUsers($token) {
    return $this->CI->rest->get(sprintf('/users/%s', $token));
  }

  public function fetchUserById($id, $token) {
    return $this->CI->rest->get(sprintf('/users/%s/%s', $id, $token));
  }

  public function createUser(User_model $user, $token) {
    $json = json_encode($user);

    return $this->CI->rest->post(sprintf('/users/%s', $token), $json);
  }

  public function updateUser(User_model $user, $token) {
    $json = json_encode($user);

    return $this->CI->rest->post(sprintf('/users/%s/%s', $user->id, $token), $json);
  }

  public function deleteUser($user_id, $token) {
    return $this->CI->rest->delete(sprintf('/users/%s/%s', $user_id, $token));
  }

  public function reactivateUser($user_id, $token) {
    return $this->CI->rest->put(sprintf('/users/reactivate/%s/%s', $user_id, $token));
  }

  public function unlockUser($user_id, $token) {
    return $this->CI->rest->put(sprintf('/users/unlock/%s/%s', $user_id, $token));
  }

// -- -------------------------------------------------
// -- CALENDAR MANAGEMENT
// -- -------------------------------------------------
  public function fetchCalendarByYear($year, $token) {
    return $this->CI->rest->get(sprintf('/calendar/year/%s/%s', $year, $token));
  }

  public function fetchCalendaryById($id, $token) {
    return $this->CI->rest->get(sprintf('/calendar/id/%s/%s', $id, $token));
  }

  public function createCalendar(Calendar_model $calendar, $token) {
    $json = json_encode($calendar);

    return $this->CI->rest->post(sprintf('/calendar/%s', $token), $json);
  }

  public function updateCalendar(Calendar_model $calendar, $token) {
    $json = json_encode($calendar);

    return $this->CI->rest->put(sprintf('/calendar/%s/%s', $calendar->id, $token), $json);
  }

  public function deleteCalendar($calendar_id, $token) {
    return $this->CI->rest->delete(sprintf('/calendar/%s/%s', $calendar_id, $token));
  }


// -- -------------------------------------------------
// -- INSURANCE MANAGEMENT
// -- -------------------------------------------------
  public function fetchAllInsurances($token) {
    return $this->CI->rest->get(sprintf('/insurance/%s', $token));
  }

  public function fetchInsuranceById($id, $token) {
    return $this->CI->rest->get(sprintf('/insurance/%s/%s', $id, $token));
  }

  public function createInsurance(Vocabulary_model $insurance, $token) {
    $json = json_encode($insurance);

    return $this->CI->rest->post(sprintf('/insurance/%s', $token), $json);
  }

  public function updateInsurance(Vocabulary_model $insurance, $token) {
    $json = json_encode($insurance);

    return $this->CI->rest->put(sprintf('/insurance/%s/%s', $insurance->id, $token), $json);
  }

  public function deleteInsurance($id, $token) {
    return $this->CI->rest->delete(sprintf('/insurance/%s/%s', $id, $token));
  }

// -- -------------------------------------------------
// -- COLLECTOR MANAGEMENT
// -- -------------------------------------------------

  public function fetchAllCollectors($token) {
    return $this->CI->rest->get(sprintf('/collector/%s', $token));
  }

  public function fetchCollectorById($id, $token) {
    return $this->CI->rest->get(sprintf('/collector/%s/%s', $id, $token));
  }

  public function createCollector(Vocabulary_model $collector, $token) {
    $json = json_encode($collector);

    return $this->CI->rest->post(sprintf('/collector/%s', $token), $json);
  }

  public function updateCollector(Vocabulary_model $collector, $token) {
    $json = json_encode($collector);

    return $this->CI->rest->put(sprintf('/collector/%s/%s', $collector->id, $token), $json);
  }

  public function deleteCollector($id, $token) {
    return $this->CI->rest->delete(sprintf('/collector/%s/%s', $id, $token));
  }
}
