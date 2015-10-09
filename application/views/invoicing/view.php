<?php
  $this->load->helper('date');

  $payment_types = $this->invoice_service->fetchAvailablePaymentTypes();

  function resolvePaymentType($type, $payment_types) {
    foreach($payment_types as $code => $label) {
      if($type === $code)
        return $label;
    }

    return "";
  }
?>


<style media="screen">
.invoice_lines td {
  padding: 5px;
}
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $(".credit_invoice").on('click', function() {
      return confirm('Bent u zeker dat u deze factuur wenst te crediteren?');
    });
  });
</script>


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



  <div class="dossierbar">

    <div class="dossierbar__mainactions">
    </div>

    <div class="dossierbar__actions">
      <?php if($invoice->invoice_type !=='CN' && $invoice->invoice_ref_id == null) {?>
        <div class="dossierbar__action__item">
          <div class="btn--dropdown">
            <div class="btn--dropdown--btn btn--icon">
              <span class="icon--invoice">Facturatie</span>
            </div>
            <ul class="btn--dropdown--drop">
              <li><a class="credit_invoice" href="/invoicing/invoice/credit/<?=$invoice->id?>">Creditnota aanmaken</a></li>
            </ul>
          </div>
        </div>
      <?php } ?>

      <?php if($invoice->document_id != null && $invoice->document_id =! '') { ?>
      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--print">Print</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a href="/invoicing/document/download/<?=$invoice->document_id?>"><?php print ($invoice->invoice_type =='CN' ? 'Creditnota' : 'Factuur')?> ophalen</a></li>
          </ul>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>

  <!-- invoice customer -->
  <div class="box inner_padding">
    <h1><?php print ($invoice->invoice_type =='CN' ? 'Creditnota' : 'Factuur')?></h1>

    <?php if($invoice->invoice_type != 'CN') { ?>
      <div class="invoice-full-container__name">
        <div class="form-item-horizontal invoice-full-container__first_name">
          <label>Betalingskenmerk:</label>
          <?php print $invoice->invoice_structured_reference; ?>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- invoice customer -->
  <div class="box inner_padding">
    <h1>Klant</h1>

    <div class="invoice-full-container__name">
      <div class="form-item-horizontal invoice-full-container__first_name">
        <label>Voornaam:</label>
        <?php print $invoice->invoice_customer->first_name; ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__last_name">
        <label>Achternaam:</label>
        <?php print $invoice->invoice_customer->last_name; ?>
      </div>
    </div>

    <div class="invoice-full-container__company">
      <div class="form-item-horizontal invoice-full-container__company_name">
        <label>Bedrijf:</label>
        <?php print $invoice->invoice_customer->company_name; ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__company_vat">
        <label>BTW:</label>
        <?php print $invoice->invoice_customer->company_vat; ?>
      </div>
    </div>

    <div class="invoice-full-container__address__street">
      <div class="form-item-horizontal invoice-full-container__street">
        <label>Straat:</label>
        <?php print $invoice->invoice_customer->street; ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__street_number">
        <label>Nr:</label>
        <?php print $invoice->invoice_customer->street_number; ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__street_pobox">
        <label>Bus:</label>
        <?php print $invoice->invoice_customer->street_pobox; ?>
      </div>
    </div>

    <div class="invoice-full-container__address__city">
      <div class="form-item-horizontal invoice-full-container__zip">
        <label>Postcode:</label>
        <?php print $invoice->invoice_customer->zip; ?>
      </div>
      <div class="form-item-horizontal invoice-full-container__city">
        <label>Gemeente:</label>
        <?php print $invoice->invoice_customer->city; ?>
      </div>
    </div>

    <div class="form-item-horizontal invoice-full-container__country">
      <label>Land:</label>
      <?php print $invoice->invoice_customer->country; ?>
    </div>
  </div>

  <!-- invoice lines -->
  <div class="box inner_padding">
    <h1>Detail</h1>
    <div class="invoice_lines">
      <?php
        $this->table->set_heading('Item', 'Aantal', 'Prijs (EUR, excl. BTW)', 'Prijs (EUR, incl. BTW)', 'Totaal (EUR, excl. BTW)', 'Totaal (EUR, incl. BTW)');

        foreach($invoice->invoice_lines as $item)
        {
              $this->table->add_row(
                $item->item
                , $item->item_amount
                , $item->item_price_excl_vat
                , $item->item_price_incl_vat
                , $item->item_total_excl_vat
                , $item->item_total_incl_vat
              );
        }


        //invoice total
        $this->table->add_row(
          '&nbsp;',
          '&nbsp;',
          '&nbsp;',
          ($invoice->invoice_type == 'CN' ? 'Totaal Creditnota' : 'Factuur totaal:'),
          $invoice->invoice_total_excl_vat,
          $invoice->invoice_total_incl_vat
        );

        if($invoice->invoice_type != 'CN')
        {
          if($invoice->vat_foreign_country)
          {
            $this->table->add_row(
              '&nbsp;',
              '&nbsp;',
              '&nbsp;',
              'Betaald:',
              $invoice->invoice_amount_paid,
              resolvePaymentType($invoice->invoice_payment_type, $payment_types) //form_input(array('name' => 'invoice_payment_type', 'value' => $invoice->invoice_payment_type, 'id' => 'invoice_payment_type')),
            );

            $this->table->add_row(
              '&nbsp;',
              '&nbsp;',
              '&nbsp;',
              'Openstaand saldo:',
              $invoice->invoice_total_excl_vat - $invoice->invoice_amount_paid,
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
              resolvePaymentType($invoice->invoice_payment_type, $payment_types), //form_input(array('name' => 'invoice_payment_type', 'value' => $invoice->invoice_payment_type, 'id' => 'invoice_payment_type')),
              $invoice->invoice_amount_paid
            );

            $this->table->add_row(
              '&nbsp;',
              '&nbsp;',
              '&nbsp;',
              'Openstaand saldo:',
              '&nbsp;',
              $invoice->invoice_total_incl_vat - $invoice->invoice_amount_paid
            );
          }
        }

        echo $this->table->generate();
      ?>
    </div>
  </div>


  <!-- invoice remakrs -->
  <div class="box inner_padding">
    <h1>Opmerkingen</h1>
    <?php print $invoice->invoice_message ?>
  </div>


  <div class="form__actions">
      <div class="form__actions__cancel">
          <div class="form-item">
              <a href="/invoicing/overview/batch">Terug</a>
          </div>
      </div>
  </div>
</div>
