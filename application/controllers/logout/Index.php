<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Index extends Page {
  public function __construct(){
    parent::__construct();

    $this->load->library('session');
    $this->load->helper('url');
  }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
      // Initialize the session.
      if(!isset($_SESSION)) {
        // If you are using session_name("something"), don't forget it now!
        session_start();
      }

      // Unset all of the session variables.
      $_SESSION = array();

      // If it's desired to kill the session, also delete the session cookie.
      // Note: This will destroy the session, and not just the session data!
      if (ini_get("session.use_cookies")) {
          $params = session_get_cookie_params();
          setcookie(session_name(), '', time() - 42000,
              $params["path"], $params["domain"],
              $params["secure"], $params["httponly"]
          );
      }

      // Finally, destroy the session.
      session_destroy();

      $session_data = $this->session->all_userdata();

      foreach($session_data as $key => $value) {
        $this->session->unset_userdata($key);
      }

      $this->session->sess_destroy();

      redirect("/", 302);
  }

}
