<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/fast_dispatch/create" onclick="return confirm('Bent u zeker dat u een nieuw dossier wenst aan te maken?');">New Voucher</a>
  </div>
</div>
<div class="box table_list table_list_large">
  <?php

  $this->load->helper('date');

  $this->table->set_heading('Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

  if($vouchers && sizeof($vouchers) > 0) {
    foreach($vouchers as $voucher) {

      $this->table->add_row(
        sprintf('<a class="id__cell" href="/fast_dispatch/dossier/%s/%s"><span class="id__cell__icon icon--ticket"></span><span class="id__cell__text">%s</span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->voucher_number),
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

