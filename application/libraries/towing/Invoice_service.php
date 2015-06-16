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

    public function createExpertMInvoiceExport($ids, $token) {
      return $this->CI->rest->post(
                  sprintf('/invoice/export/expertm/%s', $token),
                  json_encode(array('invoices' => $ids)),
                  'application/json');
    }


    /**
     * Fetch the invoice batches from the back-end
     *
     * @param $token (required) the token of the current user
     */
    public function fetchAllInvoiceBatches($token)
    {
      return $this->CI->rest->get(sprintf('/invoice/batch/%s', $token));
    }


    /**
     * Fetch the invoices  from the back-end
     *
     * @param $token (required) the token of the current user
     */
    public function fetchAllInvoices($token)
    {
      return $this->CI->rest->get(sprintf('/invoice/%s', $token));
    }

    /**
     * Create an invoice for a specific voucher
     *
     * @param $voucher_id
     * @param $message
     * @param $token
     */
    public function createInvoiceForVoucher($voucher_id, $message, $token)
    {
      return $this->CI->rest->post(
          sprintf('/invoice/voucher/%s/%s', $voucher_id, $token),
          json_encode(array('message' => $message)),
          'application/json');
    }

    /**
     * Create a storage invoice for a specific voucher
     *
     * @param $voucher_id
     * @param $token
     */
    public function createStorageInvoiceForVoucher($voucher_id, $token)
    {
      return $this->CI->rest->post(sprintf('/invoice/storage/%s/%s', $voucher_id, $token));
    }

}
