<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Invoice_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

    /**
     * Create a new invoice batch and start it
     *
     * @param $token (required) the token of the current user
     */
    public function createInvoiceBatch($token)
    {
      return $this->CI->rest->post(sprintf('/invoice/batch/%s', $token));
    }

}
