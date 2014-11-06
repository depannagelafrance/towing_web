<div class="box unpadded dsform" style="width:850px">
  <div class="inner_padding">

    <div style="width: 800px; margin: auto;">
      <?php
        //TODO: @Gert, voorzien van een correcte styling voor de form errors!

        $errors = validation_errors();

        if($errors) {
          printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
        }
      ?>

      <?php echo form_open('/admin/collector/create')?>
        <div class="form-item">
    	     <input type="text" placeholder="Name"
    		     value="<?php print set_value('name'); ?>" name="name" />
        </div>

        <div class="form__actions">
          <div class="form__actions__cancel">
            <div class="form-item">
              <a href="/admin/collector">Annuleren</a>
            </div>
          </div>
          <div class="form__actions__save">
            <div class="form-item">
              <input type="submit" value="Bewaren" name="submit">
            </div>
          </div>
        </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>
