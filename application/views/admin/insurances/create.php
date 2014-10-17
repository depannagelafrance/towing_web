<div style="width: 800px; margin: auto;">
  <?php echo validation_errors(); ?>

  <?php echo form_open('admin/insurance/create')?>
    <div class="form-item">
	<input type="text" placeholder="Naam"
		value="<?php print set_value('name'); ?>" name="name" />
    </div>
    
    <div class="form-item">
    	<input type="submit" name="submit" value="submit" />
    </div>
  <?php echo form_close();?>
</div>
