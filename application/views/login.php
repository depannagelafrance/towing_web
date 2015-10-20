<div class="l-login">
  <div class="logo"></div>
  <?php echo validation_errors(); ?>

  <?php echo form_open('/login/perform') ?>
   <div class="form-item-horizontal">
     <input type="text" placeholder="<?php print 'Gebruikersnaam'; ?>" value="<?php print set_value('login'); ?>" name="login" />
   </div>

    <div class="form-item-horizontal">
      <input type="password" placeholder="<?php print 'Wachtwoord'; ?>" value="" name="password" />
    </div>

    <div class="form-item-horizontal">
      <input type="submit" name="submit" value="Log in" />
    </div>

    <div class="form-item-horizontal" style="text-align: right;">
      <a style="color:white;" href="/password">Wachtwoord aanpassen</a>
    </div>
  </form>
</div>
