


  <?php echo form_open('admin/insurance/create')?>
<div class="box layout_2col_container">
  <div class="layout_2col_item">
    <?php echo validation_errors(); ?>

    <div class="form-item-horizontal">
        <label>Naam: </label>
        <?php print form_input('name', $name); ?>
    </div>

    <div class="form-item-horizontal">
    	<input type="submit" name="submit" value="Opslaan" />
    </div>

    <div class="form-item-horizontal">
      <a href="/admin/insurance">Annuleren</a>
    </div>
  </div>
</div>
  <?php echo form_close();?>