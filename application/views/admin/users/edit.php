<?php
$this->load->helper('listbox');

$errors = validation_errors();

if($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>

<?php echo form_open('admin/user/edit/' . urlencode($users->id))?>

<div class="box unpadded dsform admin_form">
  <div class="inner_padding">

      <h2 class="admin_form_title">Gebruiker bewerken</h2>

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
    	<input type="text" placeholder="E-mail"
    		value="<?php print set_value('email', $users->email); ?>" name="email" />
    </div>

    <div class="form-item admin-form-checks">
      <fieldset>
        <legend>Functies</legend>

        <div class="form-item">
          <label>Standaard voertuig:</label>
          <?php print listbox('vehicle_id', $company_vehicles, $users->vehicle_id); ?>
        </div>

        <?php
          $data = array(
            'name'        => 'is_signa',
            'value'       => 1,
            'checked'     => ($users->is_signa == 1)
          );

          echo '<div class="form-item admin-user-checkbox">' . form_checkbox($data) . '<span>Signa?</span></div>' ;

          $data = array(
            'name'        => 'is_towing',
            'value'       => 1,
            'checked'     => ($users->is_towing == 1)
          );

          echo '<div class="form-item admin-user-checkbox">' . form_checkbox($data) . '<span>Takel?</span></div>' ;
          ?>
      </fieldset>
    </div>


    <div class="form-item admin-form-checks">
        <fieldset>
          <legend>Machtigingen</legend>
        <?php
          foreach($roles as $role)
          {

            $data = array(
                'name'        => 'roles[]',
                'value'       => $role->id,
                'checked'     => _userHasRole($users->user_roles, $role->id)
                );

            echo '<div class="form-item admin-user-checkbox">' . form_checkbox($data) . '<span>' . $role->name . '</span></div>' ;
          }
        ?>
        </fieldset>
    </div>


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

<?php echo form_close();?>


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
