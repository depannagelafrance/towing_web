<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TowingPayment_model  {
  public $id                              = null;
  public $towing_voucher_id               = null;
  public $amount_guaranteed_by_insurance  = null;
  public $amount_customer                 = null;
  public $paid_in_cash                    = null;
  public $paid_by_debit_card              = null;
  public $paid_by_credit_card             = null;
  public $cal_amount_paid                 = null;
  public $cal_amount_unpaid               = null;


  public function __construct($data = null) {
    if($data) {
      $this->id                               = $data->id;
      $this->towing_voucher_id                = $data->towing_voucher_id;
      $this->amount_guaranteed_by_insurance   = $data->amount_guaranteed_by_insurance;
      $this->amount_customer                  = $data->amount_customer;
      $this->paid_in_cash                     = $data->paid_in_cash;
      $this->paid_by_debit_card               = $data->paid_by_debit_card;
      $this->paid_by_credit_card              = $data->paid_by_credit_card;
      $this->cal_amount_paid                  = $data->cal_amount_paid;
      $this->cal_amount_unpaid                = $data->cal_amount_unpaid;
    }
  }
