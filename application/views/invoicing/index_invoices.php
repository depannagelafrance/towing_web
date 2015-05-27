<?php

$last = $this->uri->total_segments();
$active_tab = $this->uri->segment($last);
$module = $this->uri->segment(1);

?>

<div class="status--indication">
  <a class="<?php print $active_tab == 'for_invoice' || $active_tab == 'index' || $active_tab == '' ? 'active' : '';  ?>" href="/<?=$module?>/overview/for_invoice">Ter facturatie</a>
  <a class="<?php print $active_tab == 'batch' ? 'active' : '';  ?>" href="/<?=$module?>/overview/batch">Facturen</a>
</div>

<form method="post" action="/invoicing/export/expertm">

<div style="float: right;">
  <input type="submit" value="Exporteer Facturen naar ExpertM" />
</div>


<div class="box table_list table_list_large">
<?php

$this->load->helper('date');

$this->table->set_heading('Factuurnummer', 'Factuurdatum', 'Takelbon', 'Klant', 'Acties');

$prev = '';
if($invoices && sizeof($invoices) > 0) {
  foreach($invoices as $invoice)
  {
      $_customer = "";

      if($invoice->company_name != null && trim($invoice->company_name) != '')
        $_customer .= $invoice->company_name;

      if($invoice->company_vat != null && trim($invoice->company_vat) != '')
        $_customer .= " (" . $invoice->company_vat . ")";

      $_customer .= sprintf(" %s %s %s %s", $invoice->street, $invoice->street_number, $invoice->zip, $invoice->city);

      $this->table->add_row(
        $invoice->invoice_number,
        mdate('%d/%m/%Y', $invoice->invoice_date),
        $invoice->voucher_number,
        $_customer,
        form_checkbox('selected_invoice_id[]', $invoice->invoice_id)
      );
  }
}

echo $this->table->generate();
?>

</div>
</form>
