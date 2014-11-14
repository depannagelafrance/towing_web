<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');
require_once(APPPATH . '/models/Dossier_model.php');

class Dossier extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
      $this->load->library('towing/Vocabulary_service');

      $this->load->library('table');
      $this->load->library('form_validation');
      $this->load->library('session');

      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('restdata');

      $this->_add_js('/public/assets/js/towing/fast_dossier.js');
    }

  /**
   * Index Page for this controller.
   */
  public function view($dossier_number, $voucher_number = null)
  {
    $token = $this->_get_user_token();

    //a dossier might be set in the cached data when an update occured. So no need to refetch.
    $dossier = $this->_pop_Dossier_cache();

    if(!$dossier) {
      $dossier = $this->dossier_service->fetchDossierByNumber($dossier_number, $token);
    }

    $this->_loadDossierView($token, $dossier, $voucher_number);

  }

  public function save($number, $voucher_number) {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);
    // $this->form_validation->set_rules('direction', 'Richting', 'required');
    // $this->form_validation->set_rules('indicator', 'KM Paal', 'required');
    // $this->form_validation->set_rules('incident_type', 'Type incident', 'required');
    // $this->form_validation->set_rules('call_number', 'Oproepnummer', 'required');
    // $this->form_validation->set_rules('vehicule_type', 'Type wagen', 'required');

    // if ($this->form_validation->run() === FALSE)
    // {
    //
    //   $this->_setDossierValuesFromPostRequest($dossier);
    //   $this->_loadDossierView($token, $dossier);
    // }
    // else
    // {
      if($dossier && $dossier->dossier) {
        $this->_setDossierValuesFromPostRequest($dossier, $voucher_number);

        $dossier = $this->dossier_service->updateDossier(new Dossier_model($dossier), $token);

        if($dossier)
        {
          //for performance improvements, put the dossier in the flash data cache
          $this->_cache_Dossier($dossier);

          //redirect to the view
          redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher_number));
        }
      }
    // }
  }


  public function voucher($dossier_id) {
    $dossier = $this->dossier_service->createTowingVoucherForDossier($dossier_id, $this->_get_user_token());

    if($dossier) {
      //for performance improvements, put the dossier in the flash data cache
      $this->_cache_Dossier($dossier);

      //redirect to the view
      redirect(sprintf("/fast_dossier/dossier/%s", $dossier->dossier->dossier_number));
    }
  }


  private function _loadDossierView($token, $dossier, $voucher_number = null) {
    $_voucher = null;

    if($voucher_number) {
      for($i = 0; $i < sizeof($dossier->dossier->towing_vouchers) && !$_voucher; $i++) {

        $voucher = $dossier->dossier->towing_vouchers[$i];

        if($voucher->voucher_number == $voucher_number) {
          $_voucher = $voucher;
        }
      }
    } else {
      $_voucher = $dossier->dossier->towing_vouchers[0];
    }

    $this->_add_content(
      $this->load->view(
        'fast_dossier/dossier',
          array(
            'dossier'                 => $dossier,
            'voucher_number'          => $voucher_number,
            'vouchers'                => $this->dossier_service->fetchAllNewVouchers($token),
            'traffic_posts'           => $this->dossier_service->fetchAllTrafficPostsByAllotment($dossier->dossier->allotment_id, $token),
            'insurances'              => $this->vocabulary_service->fetchAllInsurances($token),
            'collectors'              => $this->vocabulary_service->fetchAllCollectors($token),
            'licence_plate_countries' => $this->vocabulary_service->fetchAllCountryLicencePlates($token),
            'company_depot'           => $this->_get_authenticated_user()->company_depot
          ),
          true
      )
    );

    $this->_render_page();
  }

  private function _setDossierValuesFromPostRequest($dossier, $voucher_number) {

    $dossier->dossier->police_traffic_post_id = toIntegerValue($this->input->post('traffic_post_id'));

    for($i = 0; $i < sizeof($dossier->dossier->towing_vouchers); $i++) {

      $voucher = $dossier->dossier->towing_vouchers[$i];

      if($voucher->voucher_number == $voucher_number) {

        $voucher->vehicule_type         = $this->input->post('vehicule_type');
        $voucher->vehicule_licenceplate = $this->input->post('vehicule_licenceplate');
        $voucher->vehicule_country      = $this->input->post('licence_plate_country');

        $voucher->additional_info = $this->input->post('additional_info');

        $voucher->insurance_id                = toIntegerValue($this->input->post('insurance_id'));
        $voucher->insurance_dossiernr         = $this->input->post('insurance_dossiernr');
        $voucher->insurance_warranty_held_by  = $this->input->post('insurance_warranty_held_by');

        $voucher->collector_id        = toIntegerValue($this->input->post('collector_id'));
        $voucher->vehicule_collected  = toMySQLDate($this->input->post('vehicule_collected'));

        $voucher->signa_by          = $this->input->post('signa_by');
        $voucher->signa_by_vehicle  = $this->input->post('signa_by_vehicle');
        $voucher->signa_arrival     = $this->convertToUnixTime($this->input->post('signa_arrival'));

        $voucher->towed_by            = $this->input->post('towed_by');
        $voucher->towed_by_vehicle    = $this->input->post('towed_by_vehicle');
        $voucher->towing_called       = $this->convertToUnixTime($this->input->post('towing_called'));
        $voucher->towing_arrival      = $this->convertToUnixTime($this->input->post('towing_arrival'));
        $voucher->towing_start        = $this->convertToUnixTime($this->input->post('towing_start'));
        $voucher->towing_completed    = $this->convertToUnixTime($this->input->post('towing_completed'));

        $voucher->police_signature_dt = $this->convertToUnixTime($this->input->post('police_signature_dt'));

        $activity_ids = $this->input->post('activity_id');
        $activity_amounts = $this->input->post('amount');

        $voucher->towing_payments->amount_guaranteed_by_insurance  = $this->input->post('amount_guaranteed_by_insurance');
        $voucher->towing_payments->paid_in_cash                    = $this->input->post('paid_in_cash');
        $voucher->towing_payments->paid_by_bank_deposit            = $this->input->post('paid_by_bank_deposit');
        $voucher->towing_payments->paid_by_debit_card              = $this->input->post('paid_by_debit_card');
        $voucher->towing_payments->paid_by_credit_card             = $this->input->post('paid_by_credit_card');

        if(is_array($activity_ids)) {
          $j = 0;

          foreach($activity_ids as $activity_id) {
            $found = false;

            foreach($voucher->towing_activities as $towing_activity) {
              if($towing_activity->activity_id == $activity_id) {
                $towing_activity->amount = $activity_amounts[$j];
                $found = true;
              }
            }

            if(!$found) {
              $_activity = new stdClass();
              $_activity->activity_id = $activity_id;
              $_activity->towing_voucher_id = $voucher->id;
              $_activity->amount = $activity_amounts[$j];

              $voucher->towing_activities[] = $_activity;
            }

            $j++;
          }
        }


        $dossier->dossier->towing_vouchers[$i] = $voucher;
      }
    }
  }

  private function convertToUnixTime($val, $refdate = null)
  {
    if (preg_match('/^[0-9]{1,2}:[0-9]{1,2}$/i', $val))
    {
        //just received a time string (HH:MM)
        $te = explode(':', $val);

        //TODO: fetch values from reference date, if not provided, use today
        $day = 13;
        $month = 11;
        $year = 2014;
        $sec = 0;

        //TODO: validate the received hour and minutes, if not ok, just return null
        $hour = $te[0];
        $min = $te[1];

        if(($hour >= 0 && $hour <= 23) && ($min >= 0 && $min <= 59)) {
          return mktime($hour, $min, $sec, $month, $day, $year);
        } else return null;
    }
    else
    {
      return strtotime($val);
    }
  }
}
