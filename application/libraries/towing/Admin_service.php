<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Admin_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

  public function fetchAllUsers($token) {
    return $this->CI->rest->get(sprintf('/admin/users/%s', $token));
  }

  public function fetchUserById($id, $token) {
    return $this->CI->rest->get(sprintf('/admin/users/%s/%s', $id, $token));
  }

  public function createUser(User_model $user, $token) {
    return $this->CI->rest->post(
                  sprintf('/admin/users/%s', $token),
                  json_encode($user),
                  'application/json');
  }

  public function updateUser(User_model $user, $token) {
    return $this->CI->rest->put(sprintf('/admin/users/%s/%s', $user->id, $token),
                  json_encode($user),
                  'application/json');
  }

  public function deleteUser($user_id, $token) {
    return $this->CI->rest->delete(sprintf('/admin/users/%s/%s', $user_id, $token));
  }

  public function reactivateUser($user_id, $token) {
    return $this->CI->rest->put(sprintf('/admin/users/reactivate/%s/%s', $user_id, $token));
  }

  public function unlockUser($user_id, $token) {
    return $this->CI->rest->put(sprintf('/admin/users/unlock/%s/%s', $user_id, $token));
  }

  public function fetchAvailableRoles($token) {
    return $this->CI->rest->get(sprintf('/admin/roles/%s', $token));
  }

// -- -------------------------------------------------
// -- CALENDAR MANAGEMENT
// -- -------------------------------------------------
  public function fetchCalendarByYear($year, $token) {
    return $this->CI->rest->get(sprintf('/admin/calendar/year/%s/%s', $year, $token));
  }

  public function fetchCalendaryById($id, $token) {
    return $this->CI->rest->get(sprintf('/admin/calendar/id/%s/%s', $id, $token));
  }

  public function createCalendar(Calendar_model $calendar, $token) {
    return $this->CI->rest->post(sprintf('/admin/calendar/%s', $token), get_object_vars($calendar));
  }

  public function updateCalendar(Calendar_model $calendar, $token) {
    return $this->CI->rest->put(sprintf('/admin/calendar/%s/%s', $calendar->id, $token), get_object_vars($calendar));
  }

  public function deleteCalendar($calendar_id, $token) {
    return $this->CI->rest->delete(sprintf('/admin/calendar/%s/%s', $calendar_id, $token));
  }


// -- -------------------------------------------------
// -- INSURANCE MANAGEMENT
// -- -------------------------------------------------
  public function fetchAllInsurances($token) {
    return $this->CI->rest->get(sprintf('/admin/insurance/%s', $token));
  }

  public function fetchInsuranceById($id, $token) {
    return $this->CI->rest->get(sprintf('/admin/insurance/%s/%s', $id, $token));
  }

  public function createInsurance(Insurance_model $insurance, $token) {
    return $this->CI->rest->post(sprintf('/admin/insurance/%s', $token), get_object_vars($insurance));
  }

  public function updateInsurance(Insurance_model $insurance, $token) {
    $result = $this->CI->rest->put(sprintf('/admin/insurance/%s/%s', $insurance->id, $token), get_object_vars($insurance));

    return $result;
  }

  public function deleteInsurance($id, $token) {
    return $this->CI->rest->delete(sprintf('/admin/insurance/%s/%s', $id, $token));
  }

// -- -------------------------------------------------
// -- COLLECTOR MANAGEMENT
// -- -------------------------------------------------

  public function fetchAllCollectors($token) {
    return $this->CI->rest->get(sprintf('/admin/collector/%s', $token));
  }

  public function fetchCollectorById($id, $token) {
    return $this->CI->rest->get(sprintf('/admin/collector/%s/%s', $id, $token));
  }

  public function createCollector(Vocabulary_model $collector, $token) {
    return $this->CI->rest->post(sprintf('/admin/collector/%s', $token), get_object_vars($collector));
  }

  public function updateCollector(Vocabulary_model $collector, $token) {
    return $this->CI->rest->put(sprintf('/admin/collector/%s/%s', $collector->id, $token), get_object_vars($collector));
  }

  public function deleteCollector($id, $token) {
    return $this->CI->rest->delete(sprintf('/admin/collector/%s/%s', $id, $token));
  }


// -- -------------------------------------------------
// -- TIMEFRAME ACTIVITY MANAGEMENT
// -- -------------------------------------------------
  public function fetchAllTimeframes($token) {
    return $this->CI->rest->get(sprintf('/admin/timeframe/%s', $token));
  }

  public function fetchAllTimeframeActivities($token) {
    return $this->CI->rest->get(sprintf('/admin/timeframe/activities/%s', $token));
  }

  public function fetchAllTimeframeActivityFees($timeframe_id, $token) {
    return $this->CI->rest->get(sprintf('/admin/timeframe/activity/%s/fees/%s', $timeframe_id, $token));
  }

  public function updateTimeframeActivityFees($timeframe_id, $data, $token) {
    return $this->CI->rest->put(
                    sprintf('/admin/timeframe/activity/%s/fees/%s', $timeframe_id, $token),
                    json_encode($data),
                    'application/json');
  }

  // -- -------------------------------------------------
  // -- COMPANY MANAGEMENT
  // -- -------------------------------------------------
  public function fetchUserCompany($token) {
    return $this->CI->rest->get(sprintf('/admin/company/%s', $token));
  }

  public function fetchUserCompanyDepot($token) {
    return $this->CI->rest->get(sprintf('/admin/company/depot/%s', $token));
  }

  public function updateCompany(Company_model $company_model, $token)
  {
    return $this->CI->rest->put(
                          sprintf('/admin/company/%s', $token),
                          json_encode(array("company" => $company_model)),
                          'application/json');
  }

  public function updateCompanyDepot(Depot_model $depot_model, $token)
  {
    return $this->CI->rest->put(
                          sprintf('/admin/company/depot/%s', $token),
                          json_encode(array("depot" => $depot_model)),
                          'application/json');
  }
}
