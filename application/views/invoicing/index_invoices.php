<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);
$module = $this->uri->segment(1);

?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".credit_invoice").on('click', function(event) {
        event.stopPropagation();
      return confirm('Bent u zeker dat u deze factuur wenst te crediteren?');
    });
    $(".invoice_checkbox").on('click', function(event) {
      event.stopPropagation();
    })
  });
</script>

<div class="status--indication">
  <a class="<?php print $active_tab == 'for_invoice' || $active_tab == 'index' || $active_tab == '' ? 'active' : '';  ?>" href="/<?=$module?>/overview/for_invoice">Ter facturatie</a>
  <a class="<?php print $active_tab == 'batch' ? 'active' : '';  ?>" href="/<?=$module?>/overview/batch">Facturen</a>
</div>

<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/invoicing/invoice/create" onclick="return confirm('Bent u zeker dat u een nieuwe factuur wenst aan te maken?');">Nieuwe factuur aanmaken</a>
  </div>
</div>

<form method="post" action="/invoicing/export/expertm">

<div style="float: right;">
  <input type="submit" value="Exporteer Facturen naar ExpertM" />
</div>


<div class="box table_list table_list_large">
<?php

$this->load->helper('date');

$this->table->set_heading('Nummer', 'Type', 'Factuurdatum', 'Takelbon', 'Klant', '&nbsp;', '&nbsp;', '&nbsp;');

$prev = '';
if($invoices && sizeof($invoices) > 0) {
  foreach($invoices as $invoice)
  {
      $_customer = "";

      if($invoice->company_name != null && trim($invoice->company_name) != '')
        $_customer .= $invoice->company_name;

      if($invoice->company_vat != null && trim($invoice->company_vat) != '')
        $_customer .= " (" . $invoice->company_vat . ")";

      if($invoice->first_name != null && $invoice->company_name != null
          && $invoice->first_name != '' && $invoice->company_name != '')
          $_customer .= ", tav. ";

      if($invoice->first_name != null && $invoice->first_name != '')
        $_customer .= sprintf("%s, %s -", strtoupper($invoice->last_name), $invoice->first_name);

      $_customer .= sprintf(" %s %s %s %s", $invoice->street, $invoice->street_number, $invoice->zip, $invoice->city);

      $data_checkbox = array(
          'name'        => 'selected_invoice_id[]',
          'value'       => $invoice->invoice_id,
          'class'       => 'invoice_checkbox',
      );

      $this->table->add_row(
        sprintf('<a href="/invoicing/invoice/%s/%d">%s</a>', (!$invoice->document_id && !$invoice->invoice_type=='CN' ? "edit" : "view"), $invoice->invoice_id, $invoice->invoice_number_display ),
        sprintf($invoice->invoice_type == 'CN' ? 'Creditnota' : 'Factuur'),
        mdate('%d/%m/%Y', $invoice->invoice_date),
        $invoice->voucher_number,
        $_customer,
        (!$invoice->document_id && $invoice->invoice_type != 'CN' ? sprintf('<a href="/invoicing/invoice/edit/%d"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $invoice->invoice_id) : '&nbsp;'),
        ($invoice->document_id ? sprintf('<a class="download_invoice" href="/invoicing/document/download/%s"><i class="fa fa-download"></i>&nbsp; Download</a>', $invoice->document_id) : '&nbsp;'), //href="/%s/document/download/%s"
        ($invoice->document_id && $invoice->invoice_type != 'CN' && $invoice->invoice_ref_id == null? sprintf('<a class="credit_invoice" href="/invoicing/invoice/credit/%d"><i class="fa fa-chain-broken fa-2x"></i></a>', $invoice->invoice_id) : '&nbsp;'), //href="/%s/document/download/%s"
        form_checkbox($data_checkbox)
      );
  }
}

echo $this->table->generate();
?>

</div>
</form>
