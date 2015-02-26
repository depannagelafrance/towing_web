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
          <fieldset>
            <legend>Type</legend>
          <?php
          echo form_radio('type', 'SIGNA', set_value('type') == 'SIGNA') . " Signalisatiewagen <br />";
          echo form_radio('type', 'TOWING', set_value('type') == 'TOWING') . " Takelwagen <br />";
          echo form_radio('type', 'CRANE', set_value('type') == 'CRANE') . " Kraan <br />";
          echo form_radio('type', 'TRUCK', set_value('type') == 'TRUCK') . " Trekker <br />";
          echo form_radio('type', 'COLLISION', set_value('type') == 'COLLISION') . " Botsabsorbeerder <br />";
          ?>
          </fieldset>
        </div>


        <div class="box form__actions">
          <div class="form__actions__cancel">
            <div class="form-item">
              <a href="/admin/vehicle">Annuleren</a>
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
