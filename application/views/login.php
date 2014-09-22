<p>LOGIN</p>

<?php echo validation_errors(); ?>

<?php echo form_open('/login/perform') ?>
  <table border="0">
      <tr>
          <td>Login:</td>
          <td><input type="text" value="<?php echo set_value('login'); ?>" name="login" /></td>
      </tr>
      <tr>
          <td>Wachtwoord:</td>
          <td><input type="password" value="" name="password" /></td>
      </tr>
      <tr><td colspan="2"><input type="submit" name="submit" value="Log in!" /></td></tr>
  </table>
</form>
