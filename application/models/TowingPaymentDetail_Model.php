<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TowingPaymentDetail_Model  {
  public $id = null;
  public $towing_voucher_payment_id = null;
  public $category = null;
  public $foreign_vat = null;
  public $amount_excl_vat = null;
  public $amount_incl_vat = null;
  public $amount_paid_cash = null;
  public $amount_paid_bankdeposit = null;
  public $amount_paid_maestro = null;
  public $amount_paid_visa = null;
  public $amount_unpaid_excl_vat = null;
  public $amount_unpaid_incl_vat = null;

  public function __construct($data = null) {
    if($data) {
      $this->id                         = $data->id;
      $this->towing_voucher_payment_id  = $data->towing_voucher_payment_id;
      $this->category                   = $data->category;
      $this->foreign_vat                = $data->foreign_vat;
      $this->amount_excl_vat            = $data->amount_excl_vat;
      $this->amount_incl_vat            = $data->amount_incl_vat;
      $this->amount_paid_cash           = $data->amount_paid_cash;
      $this->amount_paid_bankdeposit    = $data->amount_paid_bankdeposit;
      $this->amount_paid_maestro        = $data->amount_paid_maestro;
      $this->amount_paid_visa           = $data->amount_paid_visa;
      $this->amount_unpaid_excl_vat     = $data->amount_unpaid_excl_vat;
      $this->amount_unpaid_incl_vat     = $data->amount_unpaid_incl_vat;
    }
  }
}
