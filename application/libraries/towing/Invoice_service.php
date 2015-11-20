<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Invoice_service extends Rest_service {
    public function __construct() {
      parent::__construct();
    }

    /** CREATE A NEW EMPTY INVOICE **/
    public function createInvoice($token)
    {
      return $this->CI->rest->post(sprintf('/invoice/%s', $token));
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

    public function createExpertMInvoiceExport($token) {
      return $this->CI->rest->post(
                  sprintf('/invoice/export/expertm/%s', $token),
                  array(),
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
    public function createInvoiceForVoucher($voucher_id,
                                            // $customer_amount,
                                            // $customer_ptype,
                                            // $collector_amount,
                                            // $collector_ptype,
                                            // $assurance_amount,
                                            // $assurance_ptype,
                                            $message, $token)
    {
      return $this->CI->rest->post(
          sprintf('/invoice/voucher/%s/%s', $voucher_id, $token),
          json_encode(
            array(
              'message'          => $message//,
              // 'customer_amount'  => $customer_amount,
              // 'customer_ptype'   => $customer_ptype,
              // 'collector_amount' => $collector_amount,
              // 'collector_ptype'  => $collector_ptype,
              // 'assurance_amount' => $assurance_amount,
              // 'assurance_ptype'  => $assurance_ptype
            )
          ),
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

    /**
     * Fetch an invoice by its unique id
     */
    public function fetchInvoiceById($invoice_id, $token)
    {
      return $this->CI->rest->get(sprintf('/invoice/%d/%s', $invoice_id, $token));
    }

    /**
     * Update the invoice information
     */
    public function updateInvoice($invoice, $token)
    {
      return $this->CI->rest->put(
        sprintf('/invoice/%d/%s', $invoice->id, $token),
        json_encode(array("invoice" => $invoice)),
        'application/json'
      );
    }

    /* close the invoice and create a pdf for it */
    public function closeInvoice($invoice_id, $token)
    {
      return $this->CI->rest->post(
        sprintf('/invoice/render/%d/%s', $invoice_id, $token),
        json_encode(array()),
        'application/json'
      );
    }

    /* create a CN for this invoice */
    public function creditInvoice($invoice_id, $token)
    {
      return $this->CI->rest->post(
        sprintf('/invoice/credit/%d/%s', $invoice_id, $token),
        json_encode(array()),
        'application/json'
      );
    }

    /* Remove an item from an invoice */
    public function removeInvoiceItem($invoice, $item, $token)
    {
      return $this->CI->rest->delete(
        sprintf('/invoice/%d/item/%d/%s', $invoice, $item, $token)
      );
    }

    public function fetchAvailablePaymentTypes() {
      return array(
        "" => 'Niet betaald',
        "OTHER" => 'Betalingswijze onbekend',
        "CASH" => 'Contant',
        "MAESTRO" => 'Maestro/Bancontact',
        "CREDITCARD" => 'Visa/Kredietkaart',
        "BANKDEPOSIT" => 'Overschrijving'
      );
    }

}
