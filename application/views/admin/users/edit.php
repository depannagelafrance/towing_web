
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

  <?php echo form_open('admin/user/edit/' . urlencode($users->id))?>
    <div class="form-item">
	<input type="text" placeholder="Login"
		value="<?php print set_value('login', $users->login); ?>" name="login" />
    </div>

    <div class="form-item">
    	<input type="text" placeholder="Voornaam"
    		value="<?php print set_value('firstname', $users->first_name); ?>" name="firstname" />
    </div>

    <div class="form-item">
    	<input type="text" placeholder="Naam"
    		value="<?php print set_value('lastname', $users->last_name); ?>" name="lastname" />
    </div>

    <div class="form-item">
    	<input type="text" placeholder="email"
    		value="<?php print set_value('email', $users->email); ?>" name="email" />
    </div>

    <div class="form-item">
        <?php
          foreach($roles as $role)
          {

            $data = array(
                'name'        => 'roles[]',
                'value'       => $role->id,
                'checked'     => _userHasRole($users->user_roles, $role->id)
                );

            echo form_checkbox($data);
            printf("%s <br />", $role->name);
          }
        ?>
    </div>

    <div class="form-item">
    	<input type="submit" name="submit" value="submit" />
    </div>
<?php echo form_close();?>
</div>

</div>
</div>


<?php
function _userHasRole($userRoles, $id) {
  foreach($userRoles as $_role) {
    if($_role->id == $id) {
      return true;
    }
  }

  return false;
}
?>
