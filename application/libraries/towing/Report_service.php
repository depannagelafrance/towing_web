<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_Service.php');

class Report_Service extends Rest_Service {
    public function __construct() {
      parent::__construct();
    }

    public function generateVoucher($dossier_id, $voucher_id, $type, $token) {
      return $this->CI->rest->get(sprintf('/report/towing_voucher/%s/%s/%s/%s', $type, $dossier_id, $voucher_id, $token));
    }
}
