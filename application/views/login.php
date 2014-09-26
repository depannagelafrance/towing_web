<p>LOGIN</p>

<?php echo validation_errors(); ?>

<?php echo form_open('/login/perform') ?>
 <div>
   <label>Login:</label>
   <input type="text" placeholder="<?php print 'Gebruikersnaam'; ?>" value="<?php print set_value('login'); ?>" name="login" />
 </div>

  <div>
    <label>Wachtwoord:</label>
    <input type="password" placeholder="<?php print 'Wachtwoord'; ?>" value="" name="password" />
  </div>

  <div>
    <input type="submit" name="submit" value="Log in!" /></td></tr>
  </div>
</form>
