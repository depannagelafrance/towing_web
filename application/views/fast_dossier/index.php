<div class="box table_list">
<?php

$this->load->helper('date');

$this->table->set_heading('Dossier', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

if($dossiers && sizeof($dossiers) > 0) {
  foreach($dossiers as $voucher) {
    $this->table->add_row(
      sprintf('<a href="/fast_dossier/dossier/%s">%s</a>', $voucher->dossier_number, $voucher->dossier_number), //$voucher->voucher_number),
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