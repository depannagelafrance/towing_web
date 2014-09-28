<div class="l-login">
  <div class="logo"></div>
  <?php echo validation_errors(); ?>

  <?php echo form_open('/login/perform') ?>
   <div class="form-item">
     <input type="text" placeholder="<?php print 'Gebruikersnaam'; ?>" value="<?php print set_value('login'); ?>" name="login" />
   </div>

    <div class="form-item">
      <input type="password" placeholder="<?php print 'Wachtwoord'; ?>" value="" name="password" />
    </div>

    <div class="form-item">
      <input type="submit" name="submit" value="Log in" />
    </div>
  </form>
</div>
