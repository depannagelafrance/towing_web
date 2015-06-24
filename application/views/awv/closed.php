<script type="application/javascript">

</script>
<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);
$module = $this->uri->segment(1);

$to_check_active = $active_tab == 'to_check' || $active_tab == 'index' || $active_tab == '';
$approved_active = $active_tab == 'approved';
$closed_active   = $active_tab == 'closed';
$batches_active  = $active_tab == 'batches';
?>

<div class="status--indication">
  <a class="<?php print $to_check_active  ? 'active' : '';  ?>" href="/<?=$module?>/overview/to_check">Ter controle</a>
  <a class="<?php print $approved_active ? 'active' : '';  ?>" href="/<?=$module?>/overview/approved">Goedgekeurd</a>
  <a class="<?php print $closed_active ? 'active' : '';  ?>" href="/<?=$module?>/overview/closed">Afgesloten</a>
  <a class="<?php print $batches_active ? 'active' : '';  ?>" href="/<?=$module?>/overview/batches">Geconsolideerde brieven</a>
</div>



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
