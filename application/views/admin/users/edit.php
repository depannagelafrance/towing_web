<div style="width: 800px; margin: auto;">

  <?php echo form_open('admin/user/update')?>
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
        <?php foreach($roles as $role) {?>
            <input type="checkbox" name="roles[]" value="<?php echo $role->id?>" /><?php echo $role->name;?><br />
        <?php }?>
    </div>

    <div class="form-item">
    	<input type="submit" name="submit" value="submit" />
    </div>
  <?php echo form_close();?>
</div>
