
  <?php echo form_open('admin/insurance/create')?>
  <?php echo validation_errors(); ?>

  <div class="box unpadded dsform admin_form">
      <div class="inner_padding">
        <h2 class="admin_form_title">Verzekeringsmaatschappij bewerken</h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <?php print form_input('name', $name); ?>
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
