<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);
$module = $this->uri->segment(1);

?>

<div class="status--indication">
  <a class="<?php print $active_tab == 'index' ? 'active' : '';  ?>" href="/<?=$module?>/index">Alle</a>
  <?php
  if($hasSearchResults) {
     printf('<a class="%s" href="%s/overview/searchresults">', ($active_tab == 'searchresults' ? 'active' : ''), $module);
  }
  ?>
  <a class="<?php print $active_tab == 'new' ? 'active' : '';  ?>" href="/<?=$module?>/overview/new">Nieuw</a>
  <a class="<?php print $active_tab == 'to_check' ? 'active' : '';  ?>" href="/<?=$module?>/overview/to_check">Ter controle</a>
  <a class="<?php print $active_tab == 'for_invoice' ? 'active' : '';  ?>" href="/<?=$module?>/overview/for_invoice">Ter facturatie</a>
  <a class="<?php print $active_tab == 'not_collected' ? 'active' : '';  ?>" href="/<?=$module?>/overview/not_collected">Niet afgehaald</a>
  <a class="<?php print $active_tab == 'awv' ? 'active' : '';  ?>" href="/<?=$module?>/overview/awv">AW&amp;V</a>
  <a class="<?php print $active_tab == 'done' ? 'active' : '';  ?>" href="/<?=$module?>/overview/done">Afgesloten</a>
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
</div><!-- nothing here -->




