<script type="application/javascript">
$(document).ready(function() {
    $('.download_document').click(function() {
      var $document_id = $(this).data('document_id');

      if($document_id)
        window.location.href = '/awv/document/download/' + $document_id;
    });
});
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

$this->table->set_heading('Document', 'Datum', 'Aangemaakt door', 'Download');

$prev = '';
if($batches && sizeof($batches) > 0) {
  foreach($batches as $batch)
  {
      $this->table->add_row(
        $batch->name,
        mdate('%d/%m/%Y',strtotime($batch->render_date)),
        $batch->cd_by,
        sprintf('<a class="download_document" data-document_id="%s"><i class="fa fa-download fa-2x"></i></a>', $batch->document_id)
      );
  }
}

echo $this->table->generate();
?>
</div>
