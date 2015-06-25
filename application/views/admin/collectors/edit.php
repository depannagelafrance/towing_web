<?php echo form_open('admin/collector/edit/'.$id)?>
<?php echo validation_errors(); ?>
<div class="box unpadded dsform admin_form">
    <div class="inner_padding">
        <h2 class="admin_form_title">Afhaler bewerken</h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <?php print form_input('name', $name); ?>
        </div>

        <div class="form-item-horizontal">
            <label>BTW-nummer: </label>
            <?php print form_input('vat', $vat); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Street: </label>
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
          <label>Klantnummer: </label>
          <?php print form_input('customer_number', $customer_number); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Factureren aan: </label>
          <?php
            $options = $collector_types;

            echo form_dropdown('type', $options, $type);
          ?>
        </div>
    </div>

      <div class="box form__actions">
          <div class="form__actions__cancel">
              <div class="form-item-horizontal">
                  <a href="/admin/collector">Annuleren</a>
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
