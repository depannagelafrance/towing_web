<?php
$module = 'fast_dossier';

if($this->uri->segment(1) === 'commando') {
  $module = 'commando';
}
?>

<div>
  <form class="search--fast--dossier box" method="post" action="/<?php print $module; ?>/search">

    <div class="search--title">Takelbon Zoeken</div>

    <div class="search--input">
      <input type="text" value="<?php print isset($call_number) ? $call_number : '' ?>" name="call_number" placeholder="Oproepnummer" />
    </div>

    <div class="search--input">
      <input type="text" value="<?php print isset($call_date) ? $call_date : '' ?>" name="call_date" placeholder="Datum oproep" />
    </div>

    <div class="search--input">
      <input type="text" value="<?php print isset($type) ? $type : '' ?>" name="type" placeholder="Type voertuig" />
    </div>

    <div class="search--input">
      <input type="text" value="<?php print isset($licence_plate) ? $licence_plate : '' ?>" name="licence_plate" placeholder="Nummerplaat" />
    </div>

    <div class="search--input">
      <input type="text" value="<?php print isset($customer_name) ? $customer_name : '' ?>" name="customer_name" placeholder="Naam klant" />
    </div>
    <div class="search--input search--submit">
      <input type="submit" value="Zoeken" name="btnSearch" />
    </div>
  </form>
</div>


<div class="box table_list table_list_large">
  <?php

  $this->load->helper('date');


  if($vouchers && sizeof($vouchers) > 0) {

    $this->table->set_heading('Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

    foreach($vouchers as $voucher) {

      $this->table->add_row(
        sprintf('<a class="id__cell" href="/%s/dossier/%s/%s"><span class="id__cell__icon icon--ticket"></span><span class="id__cell__text">%s</span></a>', $module, $voucher->dossier_number, $voucher->voucher_number, $voucher->voucher_number),
        $voucher->call_number,
        mdate('%d/%m/%Y %H:%i',strtotime($voucher->call_date)),
        $voucher->direction_name,
        $voucher->indicator_name,
        $voucher->towing_service,
        $voucher->incident_type
      );
    }

    echo $this->table->generate();

  }

  ?>
</div>
