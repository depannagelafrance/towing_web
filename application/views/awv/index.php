<script type="application/javascript">
$(document).ready(function() {
  $('.awv_approve_voucher').on('click', function() {
    var $voucher_id = $(this).data('vid');
    var $selectedElement = $(this);

    $.ajax({
        url		: '/awv/ajax/approveVoucher/' + $voucher_id,
        type	: 'POST',
        cache	: false,
        data		: {
        },
        success: function( data ) {
          $selectedElement.children().removeClass("fa-circle-o").addClass("fa-chevron-circle-down");
        },
        error: function(request, status, error) {
          alert('Er is een fout opgetreden bij het goedkeuren van deze takelbon.');
        }
    });

    return false;
  });

  $('#download').on('click', function() {
    document.location.href='/awv/index/exportVouchersAwaitingApproval';
  });

  $("#render").on('click', function() {
    if(confirm('Bent u zeker dat u voor deze takelbonnen de brieven wenst aan te maken?')) {
      $.ajax({
          url		: '/awv/ajax/startRender',
          type	: 'POST',
          cache	: false,
          data		: {
          },
          success: function( data ) {
            // $selectedElement.children().removeClass("fa-circle-o").addClass("fa-chevron-circle-down");
          },
          error: function(request, status, error) {
            alert('Er is een fout opgetreden bij het goedkeuren van deze takelbon.');
          }
      });
    }
  });
});
</script>
<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);
$module = $this->uri->segment(1);

$to_check_active = $active_tab == 'to_check' || $active_tab == 'index' || $active_tab == '';
$approved_active = $active_tab == 'approved';
?>

<div class="status--indication">
  <a class="<?php print $to_check_active  ? 'active' : '';  ?>" href="/<?=$module?>/overview/to_check">Ter controle</a>
  <a class="<?php print $approved_active ? 'active' : '';  ?>" href="/<?=$module?>/overview/approved">Goedgekeurd</a>
</div>



<div class="box table_list table_list_large">
<?php
if($to_check_active) {
?>
<div class="layout-actions" style="float: right;">
  <button id="download"><i class="fa fa-download fa-3"></i>&nbsp; Download</button>
</div>
<?php
} else if ($approved_active) {
?>
<div class="layout-actions" style="float: right;">
  <button id="render"><i class="fa fa-file fa-3"></i>&nbsp; Maak brieven</button>
</div>
<?php
}

$this->load->helper('date');

$this->table->set_heading('Dossier', 'Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type', 'Goedgekeurd');

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
        $voucher->incident_type,
        $voucher->awv_approved != null ? '<i class="fa fa-chevron-circle-down fa-3">' : sprintf('<a href="#" class="awv_approve_voucher" data-vid="%s"><i class="fa fa-circle-o fa-3"></i></a>', $voucher->voucher_id) //check-circle
      );
  }
}

echo $this->table->generate();
?>
</div>
