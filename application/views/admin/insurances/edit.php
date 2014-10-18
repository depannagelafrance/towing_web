<div style="width: 800px; margin: auto;">
  <?php echo validation_errors(); ?>

  <?php echo form_open('admin/insurances/edit')?>
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
    
    <div class="form-item">
    	<input type="submit" name="submit" value="submit" />
    </div>
  <?php echo form_close();?>
</div>
