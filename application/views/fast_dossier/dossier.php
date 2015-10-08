<?php
function displayVoucherTimeField($value, $name)
{
    if ($value)
    {
        $render = sprintf('<div class="input_value">%s</div>', asTime($value));
        $render .= form_hidden($name, asJsonDateTime($value));

        return $render;
    }
    else
    {
        return form_input($name, asTime($value));
    }
}


$this->load->helper('listbox');
$this->load->helper('datetime');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>