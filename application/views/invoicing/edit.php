<?php
  $this->load->helper('date');
  $payment_types = $this->invoice_service->fetchAvailablePaymentTypes();

// echo "<pre>";
// var_dump($invoice);
// echo "</pre>";

  echo form_open('invoicing/invoice/edit/' . urlencode($invoice->id))
?>

<script type="text/javascript">
  $(document).ready(function() {
    $(".remove-invoice-item").on('click', function() {
      return confirm('Bent u zeker dat u dit item wenst te verwijderen?');
    });

    $("#btnSaveAndClose").on('click', function() {
      return confirm('Bent u zeker dat u deze factuur wenst af te sluiten?');
    });


  });
</script>

<style media="screen">
.invoice_lines td {
  padding: 5px;
}
</style>

<div class="unpadded dsform admin_form">
  <div class="box box--unpadded idbar">
    <div class="idbar__item idbar__id bright has_icon">
      <div class="idbar__icon icon--map"></div>
      <div class="idbar__id__value"><?=$invoice->invoice_number_display?></div>
    </div>

    <div class="idbar__item">
      <div class="idbar__label">
        <div class="icon--date"></div>
      </div>
      <div class="idbar__value">
        <?= mdate('%d/%m/%Y',strtotime($invoice->invoice_date)); ?>
      </div>
    </div>
  </div>

  <!-- invoice customer -->
  <div class="box inner_padding">
    <h1>Factuur</h1>

    <div class="invoice-full-container__name">
      <div class="form-item-horizontal invoice-full-container__first_name">
        <label>Betalingskenmerk:</label>
        <?php print form_input(array('name' => 'invoice_structured_reference', 'value' => $invoice->invoice_structured_reference, 'id' => 'invoice_structured_reference')); ?>
      </div>

      <div class="form-item-horizontal invoice-full-container__last_name">
        <label>Factuur afsluiten?</label>
        <?php print form_input(array('name' => 'close_invoice', 'value' => 1, 'id' => 'close_invoice', 'type' => 'checkbox')); ?>
      </div>
    </div>
  </div>

  <!-- invoice customer -->
  <div class="box inner_padding">
    <h1>Klant</h1>

    <div class="invoice-full-container__name">
      <div class="form-item-horizontal invoice-full-container__first_name">
        <label>Klantnummer:</label>
        <?php print form_input(array('name' => 'customer_number', 'value' => $invoice->invoice_customer->customer_number, 'id' => 'customer_search_customer_number')); ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__last_name">
        <label>&nbsp;</label>
        &nbsp;
      </div>
    </div>

    <div class="invoice-full-container__name">
      <div class="form-item-horizontal invoice-full-container__first_name">
        <label>Voornaam:</label>
        <?php print form_input(array('name' => 'first_name', 'value' => $invoice->invoice_customer->first_name, 'id' => 'customer_search_firstname')); ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__last_name">
        <label>Achternaam:</label>
        <?php print form_input(array('name' => 'last_name', 'value' => $invoice->invoice_customer->last_name, 'id' => 'customer_search_lastname')); ?>
      </div>
    </div>

    <div class="invoice-full-container__company">
      <div class="form-item-horizontal invoice-full-container__company_name">
        <label>Bedrijf:</label>
        <?php print form_input(array('name' => 'company_name', 'value' => $invoice->invoice_customer->company_name, 'id' => 'customer_search_company_name')); ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__company_vat">
        <label>BTW:</label>
        <?php print form_input(array('name' => 'company_vat', 'value' => $invoice->invoice_customer->company_vat, 'id' => 'customer_search_company_vat')); ?>
      </div>
    </div>

    <div class="invoice-full-container__address__street">
      <div class="form-item-horizontal invoice-full-container__street">
        <label>Straat:</label>
        <?php print form_input(array('name' => 'street', 'value' => $invoice->invoice_customer->street, 'id' => 'customer_search_street')); ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__street_number">
        <label>Nr:</label>
        <?php print form_input(array('name' => 'street_number', 'value' => $invoice->invoice_customer->street_number, 'id' => 'customer_search_street_number')); ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__street_pobox">
        <label>Bus:</label>
        <?php print form_input(array('name' => 'street_pobox', 'value' => $invoice->invoice_customer->street_pobox, 'id' => 'customer_search_street_pobox')); ?>
      </div>
    </div>

    <div class="invoice-full-container__address__city">
      <div class="form-item-horizontal invoice-full-container__zip">
        <label>Postcode:</label>
        <?php print form_input(array('name' => 'zip', 'value' => $invoice->invoice_customer->zip, 'id' => 'customer_search_zip')); ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__city">
        <label>Gemeente:</label>
        <?php print form_input(array('name' => 'city', 'value' => $invoice->invoice_customer->city, 'id' => 'customer_search_city')); ?>
      </div>
    </div>

    <div class="form-item-horizontal invoice-full-container__country">
      <label>Land:</label>
      <?php print form_input(array('name' => 'country', 'value' => $invoice->invoice_customer->country, 'id' => 'customer_search_country')); ?>
    </div>
  </div>

  <!-- invoice lines -->
  <div class="box inner_padding">
    <h1>Detail</h1>
    <div class="invoice_lines">
      <?php
        $this->table->set_heading('Item', 'Aantal', 'Prijs (EUR, excl. BTW)', 'Prijs (EUR, incl. BTW)', 'Totaal (EUR, excl. BTW)', 'Totaal (EUR, incl. BTW)', '&nbsp;');

        foreach($invoice->invoice_lines as $item)
        {
              $this->table->add_row(
                form_input(array(
                        'name'        => "item[]",
                        'value'       => $item->item
                )),
                form_input(array(
                        'name'        => "item_amount[]",
                        'value'       => $item->item_amount
                )),
                form_input(array(
                        'name'        => "item_price_excl_vat[]",
                        'value'       => $item->item_price_excl_vat
                )),
                form_input(array(
                        'name'        => "item_price_incl_vat[]",
                        'value'       => $item->item_price_incl_vat
                )),
                form_input(array(
                        'name'        => "item_total_excl_vat[]",
                        'value'       => $item->item_total_excl_vat,
                        'readonly'    => 'readonly',
                        'style'       => 'background: #F0F0F0'
                )),
                form_input(array(
                        'name'        => "item_total_incl_vat[]",
                        'value'       => $item->item_total_incl_vat,
                        'readonly'    => 'readonly',
                        'style'       => 'background: #F0F0F0'
                )),

                sprintf('<a href="/invoicing/invoice/removeline/%s/%s" class="remove-invoice-item"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>
                        <input type="hidden" name="item_id[]" value="%d">', $invoice->id, $item->id, $item->id)
              );
        }

        //add new entry
        $this->table->add_row(
          form_input(array(
                  'name'        => "item[]",
                  'value'       => ''
          )),
          form_input(array(
                  'name'        => "item_amount[]",
                  'value'       => ''
          )),
          form_input(array(
                  'name'        => "item_price_excl_vat[]",
                  'value'       => ''
          )),
          form_input(array(
                  'name'        => "item_price_incl_vat[]",
                  'value'       => ''
          )),
          '&nbsp;',
          '&nbsp;',
          '<input type="hidden" name="item_id[]" value="">'
        );

        //invoice total
        $this->table->add_row(
          '&nbsp;',
          '&nbsp;',
          '&nbsp;',
          'Factuur totaal:',
          form_input(array(
                  'value'       => $invoice->invoice_total_excl_vat,
                  'readonly'    => 'readonly',
                  'style'       => 'background: #F0F0F0'
          )),
          form_input(array(
                  'value'       => $invoice->invoice_total_incl_vat,
                  'readonly'    => 'readonly',
                  'style'       => 'background: #F0F0F0'
          )),
          '&nbsp;'
        );

        if($invoice->vat_foreign_country)
        {
          $this->table->add_row(
            '&nbsp;',
            '&nbsp;',
            '&nbsp;',
            'Betaald:',
            form_input(array('name' => 'invoice_amount_paid', 'value' => $invoice->invoice_amount_paid, 'id' => 'invoice_amount_paid')),
            form_dropdown("invoice_payment_type", $payment_types, $invoice->invoice_payment_type), //form_input(array('name' => 'invoice_payment_type', 'value' => $invoice->invoice_payment_type, 'id' => 'invoice_payment_type')),
            '&nbsp;'
          );

          $this->table->add_row(
            '&nbsp;',
            '&nbsp;',
            '&nbsp;',
            'Openstaand saldo:',
            form_input(array(
              'value' => ($invoice->invoice_total_excl_vat - $invoice->invoice_amount_paid),
              'readonly'    => 'readonly',
              'style'       => 'background: #F0F0F0')),
            '&nbsp;',
            '&nbsp;'
          );
        }
        else
        {
          $this->table->add_row(
            '&nbsp;',
            '&nbsp;',
            '&nbsp;',
            'Betaald:',
            form_dropdown("invoice_payment_type", $payment_types, $invoice->invoice_payment_type), //form_input(array('name' => 'invoice_payment_type', 'value' => $invoice->invoice_payment_type, 'id' => 'invoice_payment_type')),
            form_input(array('name' => 'invoice_amount_paid', 'value' => $invoice->invoice_amount_paid, 'id' => 'invoice_amount_paid')),
            '&nbsp;'
          );

          $this->table->add_row(
            '&nbsp;',
            '&nbsp;',
            '&nbsp;',
            'Openstaand saldo:',
            '&nbsp;',
            form_input(array(
              'value' => ($invoice->invoice_total_incl_vat - $invoice->invoice_amount_paid),
              'readonly'    => 'readonly',
              'style'       => 'background: #F0F0F0')),
            '&nbsp;'
          );
        }

        echo $this->table->generate();
      ?>
    </div>
  </div>

  <!-- invoice remakrs -->
  <div class="box inner_padding">
    <h1>Opmerkingen</h1>
    <?php print form_textarea('invoice_message', $invoice->invoice_message); ?>
  </div>


  <div class="form__actions">
      <div class="form__actions__cancel">
          <div class="form-item">
              <a href="/invoicing/overview/batch">Annuleren</a>
          </div>
      </div>
      <div class="form__actions__save">
          <div class="form-item">
              <input type="submit" value="Bewaren" name="submit">
          </div>
      </div>
  </div>

</div>
<?php echo form_close(); ?>
