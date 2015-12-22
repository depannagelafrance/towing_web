<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/libraries/towing/Rest_service.php');

class Vocabulary_service extends Rest_service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAllInsurances($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/insurances/%s', $token));
    }

    public function fetchAllCollectors($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/collectors/%s', $token));
    }

    public function fetchAllDirections($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/directions/%s', $token));
    }

    public function fetchDirectionById($id, $token)
    {
        $data = $this->CI->rest->get(sprintf('/vocab/direction/%s/%s', $id, $token));

        $data->indicators = $this->fetchAllIndicatorsByDirection($id, $token);

        return $data;
    }

    public function createDirection($name, $token)
    {
        return $this->CI->rest->post(
            sprintf('/vocab/directions/%s', $token),
            json_encode(array("name" => $name)),
            'application/json'

        );
    }

    public function updateDirection($direction, $name, $token)
    {
        return $this->CI->rest->put(
            sprintf('/vocab/directions/%s/%s', $direction, $token),
            json_encode(array("name" => $name)),
            'application/json'
        );
    }

    public function deleteDirection($direction, $token)
    {
        return $this->CI->rest->delete(
            sprintf('/vocab/directions/%s/%s', $direction, $token)
        );
    }

    public function fetchAllIndicatorsByDirection($direction, $token)
    {
        if ($direction && trim($direction) !== "")
            return $this->CI->rest->get(sprintf('/vocab/indicators/%s/%s', $direction, $token));

        return array();
    }


    public function fetchIndicatorById($direction_id, $indicator_id, $token)
    {
        return $this->CI->rest->get(sprintf('/vocab/indicators/%s/%s/%s', $direction_id, $indicator_id, $token));
    }

    public function createIndicator($direction, $indicator, $token)
    {
        return $this->CI->rest->post(
            sprintf('/vocab/indicators/%s/%s', $direction, $token),
            json_encode($indicator),
            'application/json'

        );
    }

    public function updateIndicator($direction, $indicator, $token)
    {
        return $this->CI->rest->put(
            sprintf('/vocab/indicators/%s/%s/%s', $direction, $indicator->id, $token),
            json_encode($indicator),
            'application/json'
        );
    }

    public function deleteIndicator($direction, $indicator, $token)
    {
        return $this->CI->rest->delete(
            sprintf('/vocab/indicators/%s/%s/%s', $direction, $indicator, $token)
        );
    }

    public function fetchAllTrafficLanes($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/traffic_lanes/%s', $token));
    }

    public function fetchAllCountryLicencePlates($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/country_licence_plates/%s', $token));
    }

    public function fetchAllIncidentTypes($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/incident_types/%s', $token));
    }

    public function fetchAllSignaDrivers($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/drivers/signa/%s', $token));
    }

    public function fetchAllTowingDrivers($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/drivers/towing/%s', $token));
    }

    public function fetchAllTowingVehicles($token)
    {
        return $this->CI->rest->get(sprintf('/vocab/vehicles/towing/%s', $token));
    }
}
