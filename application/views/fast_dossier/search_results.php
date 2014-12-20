<div>
  <form method="post" action="/fast_dossier/search">
    <input type="text" value="<?php print isset($call_number) ? $call_number : '' ?>" name="call_number" placeholder="Oproepnummer" />
    <input type="text" value="<?php print isset($call_date) ? $call_date : '' ?>" name="call_date" placeholder="Datum oproep" />
    <input type="text" value="<?php print isset($type) ? $type : '' ?>" name="type" placeholder="Type voertuig" />
    <input type="text" value="<?php print isset($licence_plate) ? $licence_plate : '' ?>" name="licence_plate" placeholder="Nummerplaat" />
    <input type="text" value="<?php print isset($customer_name) ? $customer_name : '' ?>" name="customer_name" placeholder"Naam klant" />
    <input type="submit" value="Zoeken" name="btnSearch" />
  </form>
</div>


<div class="box table_list table_list_large">
  <?php

  $this->load->helper('date');

  $this->table->set_heading('Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

  if($vouchers && sizeof($vouchers) > 0) {
    foreach($vouchers as $voucher) {

      $this->table->add_row(
        sprintf('<a class="id__cell" href="/fast_dossier/dossier/%s/%s"><span class="id__cell__icon icon--ticket"></span><span class="id__cell__text">%s</span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->voucher_number),
        $voucher->call_number,
        mdate('%d/%m/%Y %H:%i',strtotime($voucher->call_date)),
        $voucher->direction_name,
        $voucher->indicator_name,
        $voucher->towing_service,
        $voucher->incident_type
      );
    }
  }

  echo $this->table->generate();
  ?>
</div>
