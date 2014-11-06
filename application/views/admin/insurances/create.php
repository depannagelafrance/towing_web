
  <?php echo form_open('admin/insurance/create')?>
<div class="box layout_2col_container">
  <div class="layout_2col_item">
    <?php echo validation_errors(); ?>

    <div class="form-item-horizontal">
        <label>Naam: </label>
        <?php print form_input('name', $name); ?>
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
</div>
  <?php echo form_close();?>
