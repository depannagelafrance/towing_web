
<?php

$this->load->helper('date');

$this->table->set_heading('Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

//d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
//adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`

if($vouchers && sizeof($vouchers) > 0) {
  foreach($vouchers as $voucher) {
    $this->table->add_row(
      $voucher->voucher_number,
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
