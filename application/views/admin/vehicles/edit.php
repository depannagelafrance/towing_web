<?php
$errors = validation_errors();

if ($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>


<div class="breadcrumbs">
    <div class="breadcrum-item-link"><a href="/admin/index">Algemeen beheer</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-link"><a href="/admin/vehicle">Voertuigen</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-current"><?php print $name ?></div>
</div>

<?php echo form_open('admin/vehicle/edit/' . $id) ?>


<div class="box unpadded dsform admin_form">
    <div class="inner_padding">


        <h2 class="admin_form_title">Voertuig aanpassen</h2>

        <div class="form-item-horizontal">
            <label>Naam:</label>
            <input type="text" placeholder="Naam"
                   value="<?php print $name ?>" name="name"/>
        </div>

        <div class="form-item-horizontal">
            <label>Nummerplaat:</label>
            <input type="text" placeholder="Nummerplaat"
                   value="<?php print $licence_plate ?>" name="licence_plate"/>
        </div>
    </div>
</div>

<div class="box unpadded dsform admin_form" style="margin-top: 15px">
    <div class="inner_padding">
        <div class="form-item-horizontal admin-form-checks">
            <h2 class="admin_form_title">Voertuigtype</h2>

            <div class="form-item-horizontal">
                <?php
                echo form_radio('type', 'SIGNA', $type == 'SIGNA') . " Signalisatiewagen <br />";
                ?>
            </div>
            <div class="form-item-horizontal">
                <?php
                echo form_radio('type', 'TOWING', $type == 'TOWING') . " Takelwagen <br />";
                ?>
            </div>
            <div class="form-item-horizontal">
                <?php
                echo form_radio('type', 'CRANE', $type == 'CRANE') . " Kraan <br />";
                ?>
            </div>
            <div class="form-item-horizontal">
                <?php
                echo form_radio('type', 'TRUCK', $type == 'TRUCK') . " Trekker <br />";
                ?>
            </div>
            <div class="form-item-horizontal">
                <?php
                echo form_radio('type', 'COLLISION', set_value('type') == 'COLLISION') . " Botsabsorbeerder <br />";
                ?>
            </div>
        </div>
    </div>

    <div class="box form__actions">
        <div class="form__actions__cancel">
            <div class="form-item-horizontal">
                <a href="/admin/vehicle">Annuleren</a>
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
