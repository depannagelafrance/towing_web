<div class="box table_list table_list_large">
  <ul>
    <li><a href="">Nieuw</a></li>
    <li><a href="">Afgerond</a></li>
    <li><a href="">Ter controle</a></li>
    <li><a href="">Ter facturatie</a></li>
    <li><a href="">Afgesloten</a></li>
  </ul>
</div>

<div class="box table_list table_list_large">
<?php

$this->load->helper('date');

$this->table->set_heading('Dossier', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

$prev = '';
if($dossiers && sizeof($dossiers) > 0) {
  foreach($dossiers as $voucher) {


    if($prev !== $voucher->dossier_number){

      $prev = $voucher->dossier_number;

      $this->table->add_row(
        sprintf('<a class="id__cell" href="/fast_dossier/dossier/%s/%s"><span class="id__cell__icon icon--map"></span><span class="id__cell__text">%s</span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->dossier_number),
        $voucher->call_number,
        mdate('%d/%m/%Y %H:%i',strtotime($voucher->call_date)),
        $voucher->direction_name,
        $voucher->indicator_name,
        $voucher->towing_service,
        $voucher->incident_type
      );

    }
  }
}

echo $this->table->generate();
?>
</div>
