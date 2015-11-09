<?php
$errors = validation_errors();

if ($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>
<?php echo form_open('/admin/customer/create') ?>
<div class="box unpadded dsform admin_form">
    <div class="inner_padding">
        <h2 class="admin_form_title">Klant aanmaken</h2>

        <div class="form-item-horizontal">
            <label>Klantnummer: </label>
            <input type="text" placeholder="Klantnummer"
                   value="<?php print set_value('customer_number'); ?>" name="customer_number"/>
        </div>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <input type="text" placeholder="Naam of bedrijfsnaam"
                   value="<?php print set_value('company_name'); ?>" name="company_name"/>
        </div>
        <div class="form-item-horizontal">
            <label>Voornaam: </label>
            <input type="text" placeholder="Voornaam"
                   value="<?php print set_value('first_name'); ?>" name="first_name"/>
        </div>
        <div class="form-item-horizontal">
            <label>Familienaam: </label>
            <input type="text" placeholder="Familienaam"
                   value="<?php print set_value('last_name'); ?>" name="last_name"/>
        </div>

        <div class="form-item-horizontal">
            <label>BTW-nummer: </label>
            <input type="text" placeholder="BTW nummer"
                   value="<?php print set_value('company_vat'); ?>" name="company_vat"/>
        </div>

        <div class="form-item-horizontal">
            <label>Straat: </label>
            <input type="text" placeholder="Straat"
                   value="<?php print set_value('street'); ?>" name="street"/>
        </div>

        <div class="form-item-horizontal">
            <label>Huisnummer: </label>
            <input type="text" placeholder="Huisnummer"
                   value="<?php print set_value('street_number'); ?>" name="street_number"/>
        </div>

        <div class="form-item-horizontal">
            <label>Postbus: </label>
            <input type="text" placeholder="Postbox"
                   value="<?php print set_value('street_pobox'); ?>" name="street_pobox"/>
        </div>

        <div class="form-item-horizontal">
            <label>Postcode: </label>
            <input type="text" placeholder="Postcode"
                   value="<?php print set_value('zip'); ?>" name="zip"/>
        </div>

        <div class="form-item-horizontal">
            <label>Gemeente: </label>
            <input type="text" placeholder="Gemeente"
                   value="<?php print set_value('city'); ?>" name="city"/>
        </div>

        <div class="form-item-horizontal">
            <label>Land: </label>
            <input type="text" placeholder="Land"
                   value="<?php print set_value('country'); ?>" name="country"/>
        </div>

        <div class="form-item-horizontal">
            <label>Niet automatisch factureren? </label>
            <?php
            $data = array(
                'name'        => 'invoice_excluded',
                'value'       => 1,
                'checked'     => (set_value('invoice_excluded') == 1)
            );

            print form_checkbox($data);
            ?>
        </div>

        <div class="form-item-horizontal">
            <label>Factureren aan </label>
            <?php
            echo form_dropdown('invoice_to', $invoice_to_options, set_value('invoice_to'));
            ?>
        </div>

        <div class="form-item-horizontal">
            <label>Verzekeringsmaatschappij? </label>
            <?php
            $data = array(
                'name'        => 'is_insurance',
                'value'       => 1,
                'checked'     => (set_value('is_insurance') == 1)
            );

            print form_checkbox($data);
            ?>
        </div>

        <div class="form-item-horizontal">
            <label>Afhaler? </label>
            <?php
            $data = array(
                'name'        => 'is_collector',
                'value'       => 1,
                'checked'     => (set_value('is_collector') == 1)
            );

            print form_checkbox($data);
            ?>
        </div>
    </div>

        <div class="form__actions">
            <div class="form__actions__cancel">
                <div class="form-item-horizontal">
                    <a href="/admin/customer">Annuleren</a>
                </div>
            </div>
            <div class="form__actions__save">
                <div class="form-item-horizontal">
                    <input type="submit" value="Bewaren" name="submit">
                </div>
            </div>
        </div>
</div>

<?php echo form_close(); ?>
