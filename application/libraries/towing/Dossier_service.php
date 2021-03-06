<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Dossier_Model.php');
require_once(APPPATH . '/models/Depot_Model.php');
require_once(APPPATH . '/models/File_Model.php');
require_once(APPPATH . '/models/Causer_Model.php');
require_once(APPPATH . '/models/Customer_Model.php');
require_once(APPPATH . '/models/Communication_Model.php');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Dossier_service extends Rest_service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAllDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/%s', $token));
    }

    public function fetchAllNewDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/new/%s', $token));
    }

    public function fetchAllToBeCheckedDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/check/%s', $token));
    }

    public function fetchAllInvoicableDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/invoice/%s', $token));
    }

    public function fetchAllInvoicedDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/invoiced/%s', $token));
    }

    public function fetchAllDossiersForAWVApproval($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/awaiting_awv_approval/%s', $token));
    }

    public function fetchAllDossiersWithAWVApproval($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/awv_approved/%s', $token));
    }

    public function fetchAllClosedDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/done/%s', $token));
    }

    public function fetchAllNotCollectedDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/not_collected/%s', $token));
    }

    public function fetchAllAgencyDossiers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/agency/%s', $token));
    }

    public function fetchAllNewVouchers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/vouchers/new/%s', $token));
    }

    public function fetchAllCompletedVouchers($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/vouchers/completed/%s', $token));
    }

    public function fetchActivitiesForVoucher($dossier, $voucher, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/activities/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchAllAvailableActivitiesForVoucher($dossier, $voucher, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/available_activities/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchDossierById($dossier, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/%s/%s', $dossier, $token));
    }

    public function fetchDossierByNumber($dossier, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/find/dossier_number/%s/%s', $dossier, $token));
    }

    public function fetchAvailableAllotments($direction, $indicator, $token)
    {
        if ($indicator && trim($indicator) != "") {
            return $this->CI->rest->get(sprintf('/dossier/list/available_allotments/direction/%s/indicator/%s/%s', $direction, $indicator, $token));
        } else {
            return $this->CI->rest->get(sprintf('/dossier/list/available_allotments/direction/%s/%s', $direction, $token));
        }
    }

    public function fetchVoucherDepot($dossier, $voucher, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/depot/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchVoucherCauser($dossier, $voucher, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/causer/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchVoucherCustomer($dossier, $voucher, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/customer/%s/%s/%s', $dossier, $voucher, $token));
    }

    public function fetchAllTrafficPostsByAllotment($allotment, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/traffic_posts/allotment/%s/%s', $allotment, $token));
    }

    public function fetchAllTrafficLanes($dossier_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/traffic_lanes/%s/%s', $dossier_id, $token));
    }

    public function createDossier($token)
    {
        return $this->CI->rest->post(sprintf('/dossier/%s', $token));
    }

    public function createTowingVoucherForDossier($dossier_id, $token)
    {
        return $this->CI->rest->post(sprintf('/dossier/voucher/%s/%s', $dossier_id, $token));
    }

    public function updateDossier(Dossier_Model $dossier, $token)
    {
        $_dossier = new stdClass();
        $_dossier->dossier = $dossier;

        return $this->CI->rest->put(
            sprintf('/dossier/%s/%s', $dossier->id, $token),
            json_encode($_dossier),
            'application/json'
        );
    }

    public function updateDossierCollectionInformation($voucher_number, $collector_id, $vehicule_collected, $token)
    {
        return $this->CI->rest->put(
            sprintf('/dossier/collector/%s', $token),
            json_encode(array(
                'voucher_number' => $voucher_number,
                'collector_id' => $collector_id,
                'vehicule_collected' => $vehicule_collected
            )),
            'application/json'
        );
    }

    public function addActivitiesToVoucher($dossier_id, $voucher_id, $activities, $token)
    {
        return $this->CI->rest->put(
            sprintf('/dossier/voucher/activities/%s/%s/%s', $dossier_id, $voucher_id, $token),
            json_encode(array("activities" => $activities)),
            'application/json'
        );
    }


    public function removeActivityFromVoucher($voucher_id, $activity_id, $token)
    {
        return $this->CI->rest->delete(
            sprintf('/dossier/voucher/%s/activity/%s/%s', $voucher_id, $activity_id, $token)
        );
    }

    public function updateTowingDepot($depot_id, $voucher_id, Depot_Model $depot, $token)
    {
        $_depot = new stdClass();
        $_depot->depot = $depot;

        return $this->CI->rest->put(
            sprintf('/dossier/depot/%s/%s/%s', $depot_id, $voucher_id, $token),
            json_encode($_depot),
            'application/json'
        );
    }

    public function updateTowingDepotToAgency($depot_id, $voucher_id, $token)
    {
        return $this->CI->rest->put(sprintf('/dossier/depot_agency/%s/%s/%s', $depot_id, $voucher_id, $token));
    }

    public function updateCustomer($customer_id, $voucher_id, Customer_Model $data, $token)
    {
        $_value = new stdClass();
        $_value->customer = $data;

        return $this->CI->rest->put(
            sprintf('/dossier/customer/%s/%s/%s', $customer_id, $voucher_id, $token),
            json_encode($_value),
            'application/json'
        );
    }

    public function updateCustomerToAgency($voucher_id, $token)
    {
        return $this->CI->rest->put(
            sprintf('/dossier/customer/agency/%s/%s', $voucher_id, $token)
        );
    }

    public function updateCauser($causer_id, $voucher_id, Causer_Model $data, $token)
    {
        $_value = new stdClass();
        $_value->causer = $data;

        return $this->CI->rest->put(
            sprintf('/dossier/causer/%s/%s/%s', $causer_id, $voucher_id, $token),
            json_encode($_value),
            'application/json'
        );
    }

    //TODO: remove $voucher_id from query string and place into file_model
    public function addInsuranceDocumentToVoucher($voucher_id, File_Model $file, $token)
    {
        return $this->CI->rest->post(
            sprintf('/voucher/attachment/insurance_document/%s/%s', $voucher_id, $token),
            json_encode($file),
            'application/json'
        );
    }

    public function fetchAllInternalCommunications($dossier_id, $voucher_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/communication/internal/%s/%s/%s', $dossier_id, $voucher_id, $token));
    }

    public function fetchAllEmailCommunications($dossier_id, $voucher_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/communication/email/%s/%s/%s', $dossier_id, $voucher_id, $token));
    }

    public function addInternalCommunication(Communication_Model $model, $token)
    {
        return $this->CI->rest->post(
            sprintf('/dossier/communication/internal/%s', $token),
            json_encode($model),
            'application/json'
        );
    }

    public function addEmailCommunication(Communication_Model $model, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/dossier/communication/email/%s', $token),
            json_encode($model),
            'application/json'
        );

        return $result;
    }

    public function sendVoucherEmailToAWV($dossier_id, $voucher_id, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/dossier/communication/awv_voucher_email/%s', $token),
            json_encode(array(
                "dossier_id" => $dossier_id,
                "voucher_id" => $voucher_id,
            )),
            'application/json'
        );

        return $result;
    }

    public function requestCollectorSignature($dossier_id, $voucher_id, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/dossier/signature/collector/%s/%s/%s', $dossier_id, $voucher_id, $token),
            json_encode(array("dossier" => $dossier_id, "voucher" => $voucher_id)),
            'application/json'
        );

        return $result;
    }

    public function requestCauserSignature($dossier_id, $voucher_id, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/dossier/signature/causer/%s/%s/%s', $dossier_id, $voucher_id, $token),
            json_encode(array("dossier" => $dossier_id, "voucher" => $voucher_id)),
            'application/json'
        );

        return $result;
    }

    public function requestTrafficPostSignature($dossier_id, $voucher_id, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/dossier/signature/police/%s/%s/%s', $dossier_id, $voucher_id, $token),
            json_encode(array("dossier" => $dossier_id, "voucher" => $voucher_id)),
            'application/json'
        );

        return $result;
    }

    public function searchTowingVouchers($call_number, $call_date, $vehicle, $type, $licence_plate, $name, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/search/%s', $token),
            json_encode(array(
                "call_number" => $call_number,
                "call_date" => $call_date,
                "vehicle" => $vehicle,
                "type" => $type,
                "licence_plate" => $licence_plate,
                "name" => $name
            )),
            'application/json'
        );

        return $result;
    }

    public function searchTowingVoucherByNumber($number, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/search/towing_voucher/%s', $token),
            json_encode(array("number" => $number)),
            'application/json'
        );

        return $result;
    }

    public function searchCustomer($search, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/search/customer/%s', $token),
            json_encode(array("search" => $search)),
            'application/json'
        );

        return $result;
    }

    public function fetchAllAttachments($dossier_id, $voucher_id, $token)
    {
        //the ID veld dat teruggeven wordt in de lijst van documenten kan je gebruiken
        //om de Document_service aan te roepen. Deze wordt al gebruikt om de signatures
        //op te halen.

        return $this->CI->rest->get(sprintf('/dossier/voucher/attachment/%s/%s', $voucher_id, $token));
    }

    public function addAttachment($dossier_id, $voucher_id, $file, $token)
    {
        $result = $this->CI->rest->post(
            sprintf('/dossier/voucher/attachment/any/%s/%s', $voucher_id, $token),
            json_encode(
                array("file_name" => $file->file_name, "content_type" => $file->content_type, "file_size" => $file->file_size, "content" => $file->content)
            ),
            'application/json'
        );

        return $result;
    }

    public function deleteAttachment($dossier_id, $voucher_id, $docid, $token)
    {
        return $this->CI->rest->delete(sprintf('/dossier/voucher/attachment/%s/%s/%s', $voucher_id, $docid, $token));
    }

    public function fetchAllVoucherValidationMessages($voucher_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/voucher/validation_messages/%s/%s', $voucher_id, $token));
    }

    /**
     * Fetch the addications costs for the requested voucher
     *
     * @param $dossier_id the unique id of the dossier
     * @param $voucher_id the unique id of the voucher (not the number, as it is not unique)
     * @param $token the token of the user currently executing the request
     *
     * @return an array of json objects containing the information of the additional costs
     */
    public function fetchAllVoucherAdditionalCosts($dossier_id, $voucher_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/additional_costs/%s/%s/%s', $dossier_id, $voucher_id, $token));
    }

    public function fetchVoucherPaymentDetails($dossier_id, $voucher_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/payment_details/%s/%s/%s', $dossier_id, $voucher_id, $token));
    }

    /**
     * Remove an additional cost entry from a voucher
     *
     * @param $cost_id the unique id of the additional cost
     * @param $voucher_id the unique id of the voucher (not the number, as the number is not unique)
     * @param $token the token of the user currently executing the request
     *
     * @return a JSON object containing either an "ok" or an error
     */
    public function removeVoucherAdditionalCost($cost_id, $voucher_id, $token)
    {
        return $this->CI->rest->delete(sprintf('/dossier/voucher/%s/additional_cost/%s/%s', $voucher_id, $cost_id, $token));
    }

    /**
     * Approve a voucher for AWV export and letter generation
     *
     * @param $voucher_id the id of the voucher
     * @param $token the token of the current user
     *
     * @return a json object containing an "ok" or an error
     */
    public function approveVoucher($voucher_id, $token)
    {
        return $this->CI->rest->post(sprintf('/dossier/voucher/approve/%s/%s', $voucher_id, $token));
    }

    /**
     * Export the vouchers awaiting approval to Excel
     *
     * @param $token the token of the current user
     *
     * @return a base64 stream representing the excel file
     */
    public function exportVouchersAwaitingApprovalToExcel($token)
    {
        return $this->CI->rest->post(sprintf('/dossier/export/vouchersAwaitingApproval/%s', $token));
    }

    public function startLetterRenderingOfAWVApprovedVouchers($token)
    {
        return $this->CI->rest->post(sprintf('/dossier/render/awv_letter/%s', $token));
    }

    public function fetchAllAWVLetterBatches($token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/awv/letter/batches/%s', $token));
    }

    public function fetchAllVoucherTrackingLocations($voucher_id, $token)
    {
        return $this->CI->rest->get(sprintf('/dossier/list/voucher/tracking/%s/%s', $voucher_id, $token));
    }
}
