<?php
$this->load->helper('listbox');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>

<?= validation_errors(); ?>
<?= form_open('/login/perform') ?>
<div>
    <label>Datum:</label>
    <?= mdate('%d/%m/%Y %H:%i',strtotime($_dossier->call_date)); ?>
</div>
<div>
    <label>Takelbon:</label>
    <?= $_dossier->towing_vouchers[0]->voucher_number ?>
</div>
<div>
    <label>Richting</label>
    <?= listbox('direction', $directions, null); ?>
</div>

<div>
    <label>KM Paal</label>
    <?= listbox('indicators', array(), null); ?>
</div>

<div>
    <label>Rijstrook</label>
    <?= listbox('traffic_lane', $traffic_lanes, null); ?>
</div>

<div>
    <label>Type incident</label>
    <?= listbox('incident_type', $incident_types, $_dossier->incident_type_id); ?>
</div>

<div>
    <label>Oproepnr.</label>
    <?= form_input('call_number', $_dossier->call_number); ?>
</div>

<div>
    <label>Assistance</label>
    <?= listbox('insurances', $insurances, null); ?>
</div>

<div>
    <label>Dossiernr.</label>
    <?= form_input('insurance_dossiernr', $_dossier->towing_vouchers[0]->insurance_dossiernr); ?>
</div>

<div>
    <label>Type wagen</label>
    <?= form_input('vehicule_type', $_dossier->towing_vouchers[0]->vehicule_type); ?>
</div>

<div>
    <label>Nummerplaat</label>
    <?= form_input('vehicule_licenceplate', $_dossier->towing_vouchers[0]->vehicule_licenceplate); ?>
</div>

<div>
    <label>Land</label>
    <?= listbox('licence_plate_country', $licence_plate_countries, null); ?>
</div>

<div>
    <label>Afmelding CIC</label>
    <?= form_input('cic', $_dossier->towing_vouchers[0]->vehicule_type); ?>
</div>

<div>
    <label>Extra info</label>
    <?= form_textarea('additional_info', $_dossier->towing_vouchers[0]->additional_info); ?>
</div>


<?= form_close(); ?>

<pre>

<? var_dump($_dossier); ?>
</pre>
