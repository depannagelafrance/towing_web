
<div class="breadcrumbs">
    <div class="breadcrum-item-link"><a href="/admin/index">Algemeen beheer</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-link"><a href="/admin/allotment">Perceel</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-current"><?php print $direction->name; ?></div>
</div>

<?php echo form_open('admin/allotment/edit_direction/' . $direction->id) ?>


<div class="box unpadded ">
    <div class="inner_padding">

        <?php
        $errors = validation_errors();

        if ($errors) {
            printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
        }
        ?>

        <h2 class="admin_form_title">Rijrichting aanpassen</h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <input type="text" placeholder="Naam"
                   value="<?php print set_value('name') ? set_value('name') : $direction->name; ?>" name="name"/>
        </div>
    </div>

    <div class="box form__actions">
        <div class="form__actions__cancel">
            <div class="form-item-horizontal">
                <a href="/admin/allotment">Annuleren</a>
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
