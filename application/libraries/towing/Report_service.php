<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Report_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

    public function generateVoucher($dossier_id, $voucher_id, $token) {
      return $this->CI->rest->get(sprintf('/report/towing_voucher/%s/%s', $dossier_id, $token));
    }
}
