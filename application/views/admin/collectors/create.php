<div style="width: 800px; margin: auto;">
  <?php echo validation_errors(); ?>

  <?php echo form_open('admin/collector/create')?>
    <div class="form-item">
	<input type="text" placeholder="Name"
		value="<?php print set_value('name'); ?>" name="name" />
    </div>
    
    <div class="form-item">
    	<input type="submit" name="submit" value="submit" />
    </div>
  <?php echo form_close();?>
</div>
