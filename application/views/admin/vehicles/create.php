<?php
$errors = validation_errors();

if($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>

<?php echo form_open('admin/vehicle/create')?>


<div class="box unpadded dsform admin_form">
  <div class="inner_padding">


      <h2 class="admin_form_title">Voertuig aanmaken</h2>

        <div class="form-item">
        	<input type="text" placeholder="Naam"
        		value="<?php print set_value('name'); ?>" name="name" />
        </div>

        <div class="form-item">
        	<input type="text" placeholder="Nummerplaat"
        		value="<?php print set_value('licence_plate'); ?>" name="licence_plate" />
        </div>

        <div class="form-item">
        	<input type="text" placeholder="Type"
        		value="<?php print set_value('type'); ?>" name="type" />
        </div>


        <div class="box form__actions">
          <div class="form__actions__cancel">
            <div class="form-item">
              <a href="/admin/user">Annuleren</a>
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
