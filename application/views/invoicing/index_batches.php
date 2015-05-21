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


<div class="box table_list table_list_large">
<?php

$this->load->helper('date');

$this->table->set_heading('ID', 'Gestart op', 'Gestart door', 'Afgerond op', 'Acties');

$prev = '';
if($batches && sizeof($batches) > 0) {
  foreach($batches as $batch)
  {
      $this->table->add_row(
        sprintf('<a class="id__cell" href="/%s/overview/batch/?id=%s><span class="id__cell__icon icon--map"></span><span class="id__cell__text">%s</span></a>',
          $module,
          $batch->id,
          $batch->id),
        $batch->batch_started,
        $batch->cd_by,
        // mdate('%d/%m/%Y %H:%i',strtotime($voucher->call_date)),
        $batch->batch_completed,
        sprintf('<a href=download>Download</a>')
      );
  }
}

echo $this->table->generate();
?>
</div>
