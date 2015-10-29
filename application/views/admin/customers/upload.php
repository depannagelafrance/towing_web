<div class="status--indication">
    <a href="/admin/customer">Klanten</a>
    <a class="active" href="/admin/customer/upload">Importeer klanten</a>
    <a href="/admin/customer/export">Exporteer klanten</a>
</div>

<?php echo form_open_multipart('/admin/customer/upload'); ?>
<div class="box unpadded dsform admin_form">
    <?php
    $errors = validation_errors();

    if($errors || (isset($error) && $error)) {
        printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors . $error);
    }
    ?>

    <div class="inner_padding">
        <h2 class="admin_form_title">Klanten importeren</h2>

        <div class="form-item-horizontal">

            <label>Bestand: </label>
            <input type="file"
                   name="userfile"/>
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
                <input type="submit" value="Opladen" name="submit">
            </div>
        </div>
    </div>
</div>
<?php echo form_close() ?>
</div>
