<?php

$errors = validation_errors();

if($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>
<?php echo form_open('/admin/collector/create')?>

<div class="box unpadded dsform admin_form">
    <div class="inner_padding">
        <h2 class="admin_form_title">Afhaler aanmaken</h2>

        <div class="form-item">
    	     <input type="text" placeholder="Naam of bedrijfsnaam"
    		     value="<?php print set_value('name'); ?>" name="name" />
        </div>

        <div class="form-item">
    	     <input type="text" placeholder="BTW nummer"
    		     value="<?php print set_value('vat'); ?>" name="vat" />
        </div>

        <div class="form-item">
    	     <input type="text" placeholder="Straat"
    		     value="<?php print set_value('street'); ?>" name="street" />
        </div>

        <div class="form-item">
           <input type="text" placeholder="Huisnummer"
             value="<?php print set_value('street_number'); ?>" name="street_number" />
        </div>

        <div class="form-item">
           <input type="text" placeholder="Postbox"
             value="<?php print set_value('street_pobox'); ?>" name="street_pobox" />
        </div>

        <div class="form-item">
           <input type="text" placeholder="Postcode"
             value="<?php print set_value('zip'); ?>" name="zip" />
        </div>

        <div class="form-item">
           <input type="text" placeholder="Gemeente"
             value="<?php print set_value('city'); ?>" name="city" />
        </div>

        <div class="form-item">
           <input type="text" placeholder="Land"
             value="<?php print set_value('country'); ?>" name="country" />
        </div>

        <div class="form-item">
          <input type="text" placeholder="Klantnummer"
            value="<?php print set_value('customer_number'); ?>" name="customer_number" />
        </div>

        <div class="form-item-horizontal">
          <label>Factuur aan:</label>
          <?php
            $options = $collector_types;

            echo form_dropdown('type', $options, set_value('type'));
          ?>
        </div>
    </div>

        <div class="form__actions">
          <div class="form__actions__cancel">
            <div class="form-item">
              <a href="/admin/collector">Annuleren</a>
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
