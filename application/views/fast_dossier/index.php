<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);

?>

<div class="status--indication">
  <a class="<?php print $active_tab == 'index' ? 'active' : '';  ?>" href="/fast_dossier/index">Alle</a>
  <a class="<?php print $active_tab == 'new' ? 'active' : '';  ?>" href="/fast_dossier/overview/new">Nieuw</a>
  <a class="<?php print $active_tab == 'to_check' ? 'active' : '';  ?>" href="/fast_dossier/overview/to_check">Ter controle</a>
  <a class="<?php print $active_tab == 'for_invoice' ? 'active' : '';  ?>" href="/fast_dossier/overview/for_invoice">Ter facturatie</a>
  <a class="<?php print $active_tab == 'done' ? 'active' : '';  ?>" href="/fast_dossier/overview/done">Afgesloten</a>
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
