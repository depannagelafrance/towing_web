<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);
$module = $this->uri->segment(1);

?>

<div class="status--indication">
  <a class="<?php print $active_tab == 'for_invoice' || $active_tab == 'index' || $active_tab == '' ? 'active' : '';  ?>" href="/<?=$module?>/overview/for_invoice">Ter facturatie</a>
  <a class="<?php print $active_tab == 'done' ? 'active' : '';  ?>" href="/<?=$module?>/overview/done">Afgesloten</a>
  <a class="<?php print $active_tab == 'batch' ? 'active' : '';  ?>" href="/<?=$module?>/overview/batch">Facturatie runs</a>
</div>


<?php
if($active_tab === 'for_invoice' || $active_tab == 'index' || $active_tab == '') {
?>
<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/invoicing/initbatch" onclick="return confirm('Bent u zeker dat u een facturatierun wenst te starten?');">Start nieuwe Facturatierun</a>
  </div>
</div>
<?
}
?>


<div class="box table_list table_list_large">
<?php

$this->load->helper('date');

$this->table->set_heading('Dossier', 'Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

$prev = '';
if($dossiers && sizeof($dossiers) > 0) {
  foreach($dossiers as $voucher)
  {
      $this->table->add_row(
        sprintf('<a class="id__cell" href="/%s/dossier/%06d/%06d"><span class="id__cell__icon icon--map"></span><span class="id__cell__text">%06d</span></a>',
          $module,
          $voucher->dossier_number,
          $voucher->voucher_number,
          $voucher->dossier_number),
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
</div>
