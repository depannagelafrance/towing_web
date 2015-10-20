<div class="l-login">
  <div class="logo"></div>

  <?php
  $_errors = validation_errors();

  if($_errors && $_errors !== '') {
    ?>
      <div style="background:#4285f4; color: white; padding: 10px 10px 10px 10px;">
      <?php echo validation_errors(); ?>
      </div>
    <?php
  }
  ?>


  <?php echo form_open('/password/perform') ?>
   <div class="form-item-horizontal">
     <input type="text" placeholder="<?php print 'Gebruikersnaam'; ?>" value="<?php print set_value('login'); ?>" name="login" />
   </div>

    <div class="form-item-horizontal">
      <input type="password" placeholder="<?php print 'Huidige wachtwoord'; ?>" value="" name="current_pwd" />
    </div>
    <div class="form-item-horizontal">
      <input type="password" placeholder="<?php print 'Nieuw wachtwoord'; ?>" value="" name="new_pwd_1" />
    </div>
    <div class="form-item-horizontal">
      <input type="password" placeholder="<?php print 'Nieuw wachtwoord (2)'; ?>" value="" name="new_pwd_2" />
    </div>

    <div class="form-item-horizontal">
      <input type="submit" name="submit" value="Wijzig" />
    </div>

    <div class="form-item-horizontal" style="text-align: right;">
      <a style="color:white;" href="/login">Annuleren</a>
    </div>
  </form>
</div>
