
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

      <?php echo form_open('admin/user/create')?>
        <div class="form-item">
        	<input type="text" placeholder="Login"
        		value="<?php print set_value('login'); ?>" name="login" />
        </div>

        <div class="form-item">
        	<input type="text" placeholder="Voornaam"
        		value="<?php print set_value('firstname'); ?>" name="firstname" />
        </div>

        <div class="form-item">
        	<input type="text" placeholder="Naam"
        		value="<?php print set_value('lastname'); ?>" name="lastname" />
        </div>

        <div class="form-item">
        	<input type="text" placeholder="email"
        		value="<?php print set_value('email'); ?>" name="email" />
        </div>

        <div class="form-item">
            <?php foreach($roles as $role) {?>
                <input type="checkbox" name="roles[]" value="<?php echo $role->id?>" /><?php echo $role->name;?><br />
            <?php }?>
        </div>

        <div class="form__actions">
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
      <?php echo form_close();?>
    </div>

</div>
</div>
