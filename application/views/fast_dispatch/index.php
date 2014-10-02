
<a href="/fast_dispatch/create">New Voucher</a>
<?php

$this->load->helper('date');

$this->table->set_heading('Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

if($vouchers && sizeof($vouchers) > 0) {
  foreach($vouchers as $voucher) {
    $this->table->add_row(
      sprintf('<a href="/fast_dispatch/dossier/%s">%s</a>', $voucher->dossier_number, $voucher->voucher_number),
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
