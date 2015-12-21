
<div class="breadcrumbs">
    <div class="breadcrum-item-link"><a href="/admin/index">Algemeen beheer</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-link"><a href="/admin/allotment">Perceel</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-current"><?php print $direction->name; ?></div>
</div>

<?php echo form_open('admin/allotment/edit_indicator/' . $direction->id . '/' . $indicator->id) ?>


<div class="box unpadded ">
    <div class="inner_padding">

        <?php
        $errors = validation_errors();

        if ($errors) {
            printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
        }
        ?>

        <h2 class="admin_form_title"><?php print sprintf("KM-paal aanpassen (Richting: %s)", $direction->name); ?></h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <input type="text" placeholder="Naam"
                   value="<?php print set_value('name') ? set_value('name') : $indicator->name; ?>" name="name"/>
        </div>

        <div class="form-item-horizontal">
            <label>Postcode: </label>
            <input type="text" placeholder="Postcode"
                   value="<?php print set_value('zip') ? set_value('zip') : $indicator->zip; ?>" name="zip"/>
        </div>

        <div class="form-item-horizontal">
            <label>Stad/Gemeente: </label>

            <input type="text" placeholder="Stad/Gemeente"
                   value="<?php print set_value('city') ? set_value('city') : $indicator->city; ?>" name="city"/>
        </div>
    </div>

    <div class="box form__actions">
        <div class="form__actions__cancel">
            <div class="form-item-horizontal">
                <a href="/admin/allotment/direction/<?php print $direction->id?>">Annuleren</a>
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
