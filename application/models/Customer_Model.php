<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Model
{
    public $id = null;
    public $customer_number = null;
    public $first_name = null;
    public $last_name = null;
    public $company_name = null;
    public $company_vat = null;
    public $street = null;
    public $street_number = null;
    public $street_pobox = null;
    public $zip = null;
    public $city = null;
    public $country = null;
    public $email = null;
    public $phone = null;
    public $invoice_ref = null;
    public $invoice_excluded = null;
    public $invoice_to = null;
    public $type = 'DEFAULT';

    public function __construct($data = null)
    {
        if ($data) {
            if (is_array($data)) {
                $this->company_name = $data['company_name'];
                $this->company_vat = $data['company_vat'];
                $this->street = $data['street'];
                $this->street_number = $data['street_number'];
                $this->street_pobox = $data['street_pobox'];
                $this->zip = $data['zip'];
                $this->city = $data['city'];
                $this->country = $data['country'];

                if (array_key_exists('customer_number', $data))
                    $this->customer_number = $data['customer_number'];

                if (array_key_exists('id', $data))
                    $this->id = $data['id'];

                if (array_key_exists('first_name', $data))
                    $this->first_name = $data['first_name'];

                if (array_key_exists('last_name', $data))
                    $this->last_name = $data['last_name'];

                if (array_key_exists('email', $data))
                    $this->email = $data['email'];

                if (array_key_exists('phone', $data))
                    $this->phone = $data['phone'];

                if (array_key_exists('type', $data))
                    $this->type = $data['type'];

                if (array_key_exists('invoice_excluded', $data))
                    $this->invoice_excluded = $data['invoice_excluded'];

                if (array_key_exists('invoice_to', $data))
                    $this->invoice_to = $data['invoice_to'];

                if (array_key_exists('is_insurance', $data))
                    $this->is_insurance = $data['is_insurance'];

                if (array_key_exists('is_collector', $data))
                    $this->is_collector = $data['is_collector'];

            } else {
                $this->id = $data->id;
                $this->customer_number = $data->customer_number;
                $this->first_name = $data->first_name;
                $this->last_name = $data->last_name;
                $this->company_name = $data->company_name;
                $this->company_vat = $data->company_vat;
                $this->street = $data->street;
                $this->street_number = $data->street_number;
                $this->street_pobox = $data->street_pobox;
                $this->zip = $data->zip;
                $this->city = $data->city;
                $this->country = $data->country;
                $this->email = $data->email;
                $this->phone = $data->phone;
                $this->type = $data->type;

                if (property_exists($data, 'invoice_excluded')) {
                    $this->invoice_excluded = $data->invoice_excluded;
                }

                if (property_exists($data, 'invoice_to')) {
                    $this->invoice_to = $data->invoice_to;
                }

                if (property_exists($data, 'is_insurance')) {
                    $this->is_insurance = $data->is_insurance;
                }

                if (property_exists($data, 'is_collector')) {
                    $this->is_collector = $data->is_collector;
                }
            }
        }
    }
}
