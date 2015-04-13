<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_Service.php');

class Document_Service extends Rest_Service {
    public function __construct() {
      parent::__construct();
    }

    public function fetchDocumentById($id, $token) {
      return $this->CI->rest->get(sprintf('/document/%s/%s', $id, $token));
    }
}
