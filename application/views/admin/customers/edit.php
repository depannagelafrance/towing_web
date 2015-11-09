<?php
$this->load->helper('listbox');

$errors = validation_errors();

if($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>

<?php echo form_open('admin/customer/edit/'.$id)?>
<div class="box unpadded dsform admin_form">
    <div class="inner_padding">
        <h2 class="admin_form_title">Klant bewerken</h2>

        <div class="form-item-horizontal">
            <label>Klantnummer: </label>
            <?php print form_input('customer_number', $customer_number); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <?php print form_input('company_name', $company_name); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Voornaam: </label>
            <?php print form_input('first_name', $first_name); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Familienaam: </label>
            <?php print form_input('last_name', $last_name); ?>
        </div>

        <div class="form-item-horizontal">
            <label>BTW-nummer: </label>
            <?php print form_input('company_vat', $company_vat); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Straat: </label>
          <?php print form_input('street', $street); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Huisnummer: </label>
          <?php print form_input('street_number', $street_number); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Postbus: </label>
          <?php print form_input('street_pobox', $street_pobox); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Postcode: </label>
          <?php print form_input('zip', $zip); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Gemeente: </label>
          <?php print form_input('city', $city); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Land: </label>
          <?php print form_input('country', $country); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Niet automatisch factureren? </label>
          <?php
          $data = array(
              'name'        => 'invoice_excluded',
              'value'       => 1,
              'checked'     => (isset($invoice_excluded) && $invoice_excluded == 1)
          );

          print form_checkbox($data);
          ?>
        </div>

        <div class="form-item-horizontal">
            <label>Factureren aan </label>
            <?php
            echo form_dropdown('invoice_to', $invoice_to_options, $invoice_to);
            ?>
        </div>

        <div class="form-item-horizontal">
            <label>Verzekeringsmaatschappij? </label>
            <?php
            $data = array(
                'name'        => 'is_insurance',
                'value'       => 1,
                'checked'     => (isset($is_insurance) && $is_insurance == 1)
            );

            print form_checkbox($data);
            ?>
        </div>

        <div class="form-item-horizontal">
            <label>Afhaler? </label>
            <?php
            $data = array(
                'name'        => 'is_collector',
                'value'       => 1,
                'checked'     => (isset($is_collector) && $is_collector == 1)
            );

            print form_checkbox($data);
            ?>
        </div>

    </div>

      <div class="box form__actions">
          <div class="form__actions__cancel">
              <div class="form-item-horizontal">
                  <a href="/admin/customer">Annuleren</a>
              </div>
          </div>
          <div class="form__actions__save">
              <div class="form-item-horizontal">
                  <input type="submit" value="Bewaren" name="submit">
              </div>
          </div>
      </div>

</div>
<?php echo form_close();?>
