<div class="breadcrumbs">
    <div class="breadcrum-item-link"><a href="/admin/index">Algemeen beheer</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-link"><a href="/admin/allotment">Perceel</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-current"><?php print $direction->name; ?></div>
</div>

<?php echo form_open('admin/allotment/create_indicator/' . $direction->id) ?>


<div class="box unpadded ">
    <div class="inner_padding">

        <?php
        $errors = validation_errors();

        if ($errors) {
            printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
        }
        ?>

        <h2 class="admin_form_title"><?php print sprintf("KM-palen aanmaken (Richting: %s)", $direction->name); ?></h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <input type="text" placeholder="Naam"
                   value="<?php print set_value('name'); ?>" name="name"/>
        </div>

        <div class="form-item-horizontal">
            <label>Postcode: </label>
            <input type="text" placeholder="Postcode"
                   value="<?php print set_value('zip'); ?>" name="zip"/>
        </div>

        <div class="form-item-horizontal">
            <label>Stad/Gemeente: </label>

            <input type="text" placeholder="Stad/Gemeente"
                   value="<?php print set_value('city'); ?>" name="city"/>
        </div>

        <div class="form-item-horizontal">
            <label>Volgorde: </label>

            <input type="text" placeholder="Volgorde (1,2,3...)"
                   value="<?php print set_value('sequence'); ?>" name="sequence"/>
        </div>

        <div class="form-item-horizontal">
            <input type="submit" value="Bewaren" name="submit">
        </div>

    </div>
</div>

<?php echo form_close(); ?>


<div class="box" style="margin-top: 15px">
    <?php

    //set table headers
    $this->table->set_heading(
        "Volgorde",
        sprintf("KM-palen voor %s", $direction->name),
        "&nbsp;",
        'Verwijderen',
        'Aanpassen');
    //add table row(s)
    foreach ($direction->indicators as $item) {
        $this->table->add_row(
            $item->sequence,
            $item->name,
            sprintf('%s %s', $item->zip, $item->city),
            sprintf('<a href="/admin/allotment/delete_indicator/%s/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $direction->id, $item->id),
            sprintf('<a href="/admin/allotment/edit_indicator/%s/%s"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $direction->id, $item->id)
        );
    }

    // and finally generate the table
    echo $this->table->generate();

    ?>
</div>
