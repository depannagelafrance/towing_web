<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Indicator_Model
{
    public $id = null;
    public $name = null;
    public $zip = null;
    public $city = null;
    public $sequence = null;

    public function __construct($data = null)
    {
        if ($data) {

            if (is_array($data)) {
                $this->initFromPost($data);
            } else {
                $this->id = property_exists($data, 'id') ? $data->id : null;
                $this->name = $data->name;
                $this->zip = $data->zip;
                $this->city = $data->city;
                $this->sequence = $data->sequence;
            }

        }
    }

    public function initFromPost($data)
    {
        $this->id = array_key_exists('id', $data) ? $data['id'] : null;

        $this->name = $data['name'];
        $this->zip = $data['zip'];
        $this->city = $data['city'];
        $this->sequence = $data['sequence'];
    }
}
