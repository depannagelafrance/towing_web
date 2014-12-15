
  <?php echo form_open('admin/insurance/create')?>
  <?php
  $errors = validation_errors();

  if($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
  }
  ?>

  <div class="box unpadded dsform admin_form">
      <div class="inner_padding">
        <h2 class="admin_form_title">Verzekeringsmaatschappij aanmaken</h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <?php print form_input('name', $name); ?>
        </div>

        <div class="form-item-horizontal">
          <label>BTW nummer: </label>
          <?php print form_input('vat', $vat); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Straat: </label>
          <?php print form_input('street', $street); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Nummer: </label>
          <?php print form_input('street_number', $street_number); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Bus: </label>
          <?php print form_input('street_pobox', $street_pobox); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Postcode: </label>
          <?php print form_input('zip', $zip); ?>
        </div>

        <div class="form-item-horizontal">
          <label>Stad: </label>
          <?php print form_input('city', $city); ?>
        </div>
      </div>

    <div class="form__actions">
      <div class="form__actions__cancel">
        <div class="form-item">
          <a href="/admin/insurance">Annuleren</a>
        </div>
      </div>
      <div class="form__actions__save">
        <div class="form-item">
          <input type="submit" value="Bewaren" name="submit">
        </div>
      </div>
    </div>

  </div>
  <?php echo form_close();?>
