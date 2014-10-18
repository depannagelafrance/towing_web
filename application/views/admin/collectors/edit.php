<div style="width: 800px; margin: auto;">
  <?php echo form_open('admin/collector/update')?>
    <div class="form-item">
    <input type="hidden" value="<?php print set_value('id', $collector->id); ?>" name="id" />
	<input type="text"
		value="<?php print set_value('name', $collector->name); ?>" name="name" />
    </div>
    
    <div class="form-item">
    	<input type="submit" name="submit" value="submit" />
    </div>
  <?php echo form_close();?>
</div>
