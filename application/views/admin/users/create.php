<?php
$this->load->helper('listbox');

$errors = validation_errors();

if($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>

<?php echo form_open('admin/user/create')?>


<div class="box unpadded dsform admin_form">
  <div class="inner_padding">


      <h2 class="admin_form_title">Gebruiker aanmaken</h2>

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
        	<input type="text" placeholder="E-mail"
        		value="<?php print set_value('email'); ?>" name="email" />
        </div>

        <div class="form-item admin-form-checks">
          <fieldset>
            <legend>Functies</legend>
            <div class="form-item">
              <label>Standaard voertuig:</label>
              <?php print listbox('vehicle_id', $company_vehicles, set_value('vehicle_id')); ?>
            </div>

            <?php
            $data = array(
              'name'        => 'is_signa',
              'value'       => 1,
              'checked'     => (set_value('is_signa') == 1)
            );

            echo '<div class="form-item admin-user-checkbox">' . form_checkbox($data) . '<span>Signa?</span></div>' ;

            $data = array(
              'name'        => 'is_towing',
              'value'       => 1,
              'checked'     => (set_value('is_towing') == 1)
            );

            echo '<div class="form-item admin-user-checkbox">' . form_checkbox($data) . '<span>Takel?</span></div>' ;
            ?>
          </fieldset>
        </div>

        <div class="form-item admin-form-checks">
          <fieldset>
            <legend>Machtigingen</legend>

            <?php foreach($roles as $role) {?>
            <div class="form-item admin-user-checkbox">
                <input type="checkbox" name="roles[]" value="<?php echo $role->id?>" />
                <span><?php echo $role->name;?></span>
            </div>
            <?php }?>
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
</div>

<?php echo form_close();?>
