<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Document_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

    public function fetchDocumentById($id, $token) {
      return $this->CI->rest->get(sprintf('/document/%s/%s', $id, $token));
    }
}
