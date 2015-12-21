<div class="breadcrumbs">
    <div class="breadcrum-item-link"><a href="/admin/index">Algemeen beheer</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-current">Perceel</div>
</div>

<?php echo form_open('admin/allotment/create_direction') ?>


<div class="box unpadded ">
    <div class="inner_padding">

        <?php
        $errors = validation_errors();

        if ($errors) {
            printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
        }
        ?>

        <h2 class="admin_form_title">Nieuwe rijrichting aanmaken</h2>

        <div class="form-item-horizontal">
            <label>Naam: </label>
            <input type="text" placeholder="Naam"
                   value="<?php print set_value('name'); ?>" name="name"/>
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
    $this->table->set_heading('Naam', 'Verwijderen', 'Aanpassen', 'Detail');
    //add table row(s)
    foreach ($directions as $item) {
        $this->table->add_row(
            $item->name,
            sprintf('<a href="/admin/vehicle/delete/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $item->id),
            sprintf('<a href="/admin/vehicle/edit/%s"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $item->id),
            sprintf('<a href="/admin/allotment/direction/%s"><i class="fa fa-ellipsis-h fa-2x"></i></a>', $item->id)
        );
    }

    // and finally generate the table
    echo $this->table->generate();

    ?>
</div>
