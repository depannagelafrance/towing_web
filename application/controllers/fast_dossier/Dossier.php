<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');
require_once(APPPATH . '/models/Dossier_Model.php');

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
        $dossier = $this->dossier_service->updateDossier(new Dossier_Model($dossier), $token);

        if($dossier)
        {
          //for performance improvements, put the dossier in the flash data cache
          $this->_cache_dossier($dossier);

          //redirect to the view
          redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher_number));
        }
      }
    // }
  }

  public function save_collector($number, $voucher_number) {
    $token = $this->_get_user_token();

    $dossier = $this->dossier_service->fetchDossierByNumber($number, $token);
    $this->form_validation->set_rules('collector_id', 'Afhaler', 'required');
    $this->form_validation->set_rules('vehicule_collected', 'Datum afhaling', 'required');


    if ($this->form_validation->run() === FALSE)
    {
      redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher_number));
    }
    else
    {
      if($dossier && $dossier->dossier) {
        $this->dossier_service->updateDossierCollectionInformation(
          $voucher_number,
          $this->input->post('collector_id'),
          $this->input->post('vehicule_collected') == '' ? null : DateTime::createFromFormat('d/m/Y H:i', $this->input->post('vehicule_collected'))->getTimestamp(),
          $token
        );
        if($dossier) {
          redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher_number));
        }
      }
    }
  }


  public function voucher($dossier_id) {
    $dossier = $this->dossier_service->createTowingVoucherForDossier($dossier_id, $this->_get_user_token());

    if($dossier) {
      //for performance improvements, put the dossier in the flash data cache
      $this->_cache_dossier($dossier);

      $voucher = end($dossier->dossier->towing_vouchers)->voucher_number;


      //redirect to the view
      redirect(sprintf("/fast_dossier/dossier/%s/%s", $dossier->dossier->dossier_number, $voucher));
    }
  }


  private function _loadDossierView($token, $dossier, $voucher_number = null) {
    $_voucher = null;

    if($voucher_number) {
      for($i = 0; $i < sizeof($dossier->dossier->towing_vouchers) && !$_voucher; $i++) {

        $voucher = $dossier->dossier->towing_vouchers[$i];

        if($voucher->voucher_number == $voucher_number) {
          $_voucher = $voucher;
          $i = sizeof($dossier->dossier->towing_vouchers);
        }
      }
    } else {
      $_voucher = $dossier->dossier->towing_vouchers[0];
    }

    $view = $this->_has_role('FAST_MANAGER') ? 'fast_dossier/dossier' : 'fast_dossier/dossier_readonly';

    // set the data
    $data = array(
      'dossier'                 => $dossier,
      'voucher_number'          => $voucher_number,
      'traffic_posts'           => $this->dossier_service->fetchAllTrafficPostsByAllotment($dossier->dossier->allotment_id, $token),
      'company_depot'           => property_exists($this->_get_authenticated_user(), 'company_depot') ? $this->_get_authenticated_user()->company_depot : null,
      'IS_FAST_MANAGER'         => $this->_has_role('FAST_MANAGER')
    );

    $collectors = null;

    switch($_voucher->status) {
      case 'TO CHECK':
        $vouchers = $this->dossier_service->fetchAllToBeCheckedDossiers($token);
        break;
      case 'READY FOR INVOICE':
        // $view = 'fast_dossier/dossier_readonly';
        $vouchers = $this->dossier_service->fetchAllInvoicableDossiers($token);
        break;
      case 'INVOICED':
      case 'INVOICED WITHOUT STORAGE':
        $vouchers   = $this->dossier_service->fetchAllInvoicedDossiers($token);
        $collectors = $this->vocabulary_service->fetchAllCollectors($token);
        $view = 'fast_dossier/dossier_readonly';
        break;
      case 'NEW':
      default:
        $vouchers = $this->dossier_service->fetchAllNewVouchers($token);
    }

    $data['vouchers'] = $vouchers;

    $data['insurances'] = $this->vocabulary_service->fetchAllInsurances($token);

    if(!$this->_has_role('FAST_MANAGER'))
    {
      if($collectors == null)
        $collectors = $this->vocabulary_service->fetchAllCollectors($token);
    }

    if($collectors != null)
      $data['collectors'] = $collectors;

    $this->_add_content($this->load->view($view, $data, true));

    $this->_render_page();
  }

  private function _setDossierValuesFromPostRequest($dossier, $voucher_number)
  {
    $dossier->dossier->police_traffic_post_id = toIntegerValue($this->input->post('traffic_post_id'));

    if($this->input->post('call_number'))
      $dossier->dossier->call_number = $this->input->post('call_number');

    if($this->input->post('allotment_direction_id') && trim($this->input->post('allotment_direction_id')) != '') {
      $dossier->dossier->allotment_direction_id = $this->input->post('allotment_direction_id');
      $dossier->dossier->direction_id = $this->input->post('allotment_direction_id');
    }


    if($this->input->post('allotment_direction_indicator_id') && trim($this->input->post('allotment_direction_indicator_id')) != '') {
      $dossier->dossier->allotment_indicator_id = $this->input->post('allotment_direction_indicator_id');
      $dossier->dossier->indicator_id           = $this->input->post('allotment_direction_indicator_id');
    }

    //traffic lanes are not changed here
    $traffic_lanes = $this->dossier_service->fetchAllTrafficLanes($dossier->dossier->id, $this->_get_user_token());

    foreach($traffic_lanes as $_traffic_lane)
    {
      if(!property_exists($dossier->dossier, 'traffic_lanes') || !$dossier->dossier->traffic_lanes) {
        $dossier->dossier->traffic_lanes = array();
      }

      if($_traffic_lane->selected)
        $dossier->dossier->traffic_lanes[] = $_traffic_lane->id;
    }

    //iterate towing vouchers and update data
    for($i = 0; $i < sizeof($dossier->dossier->towing_vouchers); $i++) {

      $voucher = $dossier->dossier->towing_vouchers[$i];

      if($voucher->voucher_number == $voucher_number)
      {
        $voucher->vehicule              = $this->input->post('vehicule');
        $voucher->vehicule_type         = $this->input->post('vehicule_type');
        $voucher->vehicule_color        = $this->input->post('vehicule_color');
        $voucher->vehicule_keys_present = ($this->input->post('vehicule_keys_present') == 1);

        $voucher->vehicule_licenceplate = $this->input->post('vehicule_licenceplate');
        $voucher->vehicule_country      = $this->input->post('licence_plate_country');

        if($this->input->post('additional_info'))
          $voucher->additional_info = $this->input->post('additional_info');

        $voucher->insurance_id                = toIntegerValue($this->input->post('insurance_id'));
        $voucher->insurance_dossiernr         = $this->input->post('insurance_dossiernr');
        $voucher->insurance_warranty_held_by  = $this->input->post('insurance_warranty_held_by');
        $voucher->insurance_invoice_number    = $this->input->post('insurance_invoice_number');

        $voucher->collector_id        = $this->input->post('collector_id');

        $voucher->vehicule_collected  = $this->input->post('vehicule_collected') == '' ? null : DateTime::createFromFormat('d/m/Y H:i', $this->input->post('vehicule_collected'))->getTimestamp();

        if($voucher->signa_id != $this->input->post('signa_id') && trim($this->input->post('signa_id')) != '')
        {
            //either the previous signa was not set or the data has changed => send a push message
            $_actions = new stdClass();

            $_actions->signa_send_notification = 1;

            $voucher->actions = $_actions;
        }


        if(($voucher->towing_id != $this->input->post('towing_id') && trim($this->input->post('towing_id')) != '')
            || ($voucher->towing_vehicle_id != $this->input->post('towing_vehicle_id') && trim($this->input->post('towing_vehicle_id')) != ''))
        {
            //either the previous towing was not set or the data has changed => send a push message
            if(!property_exists($voucher, 'actions') || !$voucher->actions)
              $voucher->actions = new stdClass();

            $_actions = $voucher->actions;

            $_actions->towing_updated_notification = 1;

            $voucher->actions = $_actions;
        }

        $voucher->signa_id          = $this->input->post('signa_id');
        $voucher->signa_by          = $this->input->post('signa_by');
        $voucher->signa_by_vehicle  = $this->input->post('signa_by_vehicle');
        $voucher->signa_arrival     = $this->convertToUnixTime($this->input->post('signa_arrival'), strtotime($dossier->dossier->call_date));
        $voucher->cic               = $this->convertToUnixTime($this->input->post('cic'), strtotime($dossier->dossier->call_date));

        $voucher->towing_id           = $this->input->post('towing_id');
        $voucher->towing_vehicle_id   = $this->input->post('towing_vehicle_id');
        $voucher->towed_by            = $this->input->post('towed_by');
        $voucher->towed_by_vehicle    = $this->input->post('towed_by_vehicle');
        $voucher->towing_called       = $this->convertToUnixTime($this->input->post('towing_called'), strtotime($dossier->dossier->call_date));
        $voucher->towing_arrival      = $this->convertToUnixTime($this->input->post('towing_arrival'), strtotime($dossier->dossier->call_date));
        $voucher->towing_start        = $this->convertToUnixTime($this->input->post('towing_start'), strtotime($dossier->dossier->call_date));
        $voucher->towing_completed    = $this->convertToUnixTime($this->input->post('towing_completed'), strtotime($dossier->dossier->call_date));

        $voucher->police_signature_dt = $this->convertToUnixTime($this->input->post('police_signature_dt'), strtotime($dossier->dossier->call_date));

        $voucher->causer_not_present = $this->input->post('causer_not_present');

        $activity_ids = $this->input->post('activity_id');
        $activity_amounts = $this->input->post('amount');

        $voucher->towing_payments->amount_guaranteed_by_insurance  = $this->input->post('amount_guaranteed_by_insurance');
        $voucher->towing_payments->paid_in_cash                    = $this->input->post('paid_in_cash');
        $voucher->towing_payments->paid_by_bank_deposit            = $this->input->post('paid_by_bank_deposit');
        $voucher->towing_payments->paid_by_debit_card              = $this->input->post('paid_by_debit_card');
        $voucher->towing_payments->paid_by_credit_card             = $this->input->post('paid_by_credit_card');

        if(is_array($activity_ids))
        {
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

        // ---------------------------------------------------------------------
        // PREPARE THE TOWING VOUCHER COSTS
        // ---------------------------------------------------------------------
        $cost_ids       = $this->input->post('cost_id');
        $cost_fees_incl = $this->input->post('cost_fee_incl_vat');
        $cost_fees_excl = $this->input->post('cost_fee_excl_vat');
        $cost_names     = $this->input->post('cost_name');


        // if(!property_exists($voucher, 'towing_additional_costs') || $voucher->towing_additional_costs == null) {
        //   $voucher->towing_additional_costs = array();
        // }

        if(is_array($cost_ids))
        {
          for($j = 0; $j < count($cost_ids); $j++)
          {
            $cost_id = $cost_ids[$j];

            $found = false;

            foreach($voucher->towing_additional_costs as $towing_additional_cost)
            {
              if($towing_additional_cost != null && $towing_additional_cost->id == $cost_id)
              {
                $found = true;
                //$cost.name, $cost.fee_excl_vat, $cost.fee_incl_vat
                $towing_additional_cost->name = $cost_names[$j];
                $towing_additional_cost->fee_excl_vat = $cost_fees_excl[$j];
                $towing_additional_cost->fee_incl_vat = $cost_fees_incl[$j];
              }
            }

            if(!$found)
            {
              if(!is_array($voucher->towing_additional_costs))
                $voucher->towing_additional_costs = array();

              if(trim($cost_id) == "" && trim($cost_names[$i]) != "")
              {
                $cost = new stdClass();
                $cost->name = $cost_names[$j];
                $cost->fee_excl_vat = $cost_fees_excl[$j];
                $cost->fee_incl_vat = $cost_fees_incl[$j];
                $cost->id = ($cost_id == "" ? null : $cost_id);

                $voucher->towing_additional_costs[] = $cost;
              }
            }
          }
        }

        $dossier->dossier->towing_vouchers[$i] = $voucher;
      }
    }
  }

  private function convertToUnixTime($val, $reference_unix_timestamp = null)
  {
    if (preg_match('/^[0-9]{1,2}:[0-9]{1,2}$/i', $val))
    {
        $format = '%s'; //Unix Epoch Time timestamp (same as the time() function)

        $ref_date = strptime($reference_unix_timestamp, $format);

        //just received a time string (HH:MM)
        $te = explode(':', $val);

        //fetch values from reference date, if not provided, use today
        $day = $ref_date['tm_mday'];
        $month = $ref_date['tm_mon'];
        $year = $ref_date['tm_year']+1900; //tm_year is years sinds 1900
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
