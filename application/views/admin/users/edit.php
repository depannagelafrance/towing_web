<?php
$this->load->helper('listbox');

$errors = validation_errors();

if ($errors) {
    printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>


<div class="breadcrumbs">
    <div class="breadcrum-item-link"><a href="/admin/index">Algemeen beheer</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-link"><a href="/admin/user">Gebruikers</a></div>
    <i class="fa fa-chevron-right"></i>

    <div class="breadcrum-item-current"><?php printf("%s %s", $users->firstname, $users->lastname); ?></div>
</div>

<?php echo form_open('admin/user/edit/' . urlencode($users->id)) ?>

<div class="box unpadded dsform admin_form">
    <div class="inner_padding">

        <h2 class="admin_form_title">Gebruiker bewerken</h2>

        <div class="form-item-horizontal">
            <label>Gebruikersnaam: </label>
            <input type="text" placeholder="Login"
                   value="<?php print set_value('login', $users->login); ?>" name="login"/>
        </div>

        <div class="form-item-horizontal">
            <label>Voornaam: </label>
            <input type="text" placeholder="Voornaam"
                   value="<?php print set_value('firstname', $users->firstname); ?>" name="firstname"/>
        </div>

        <div class="form-item-horizontal">
            <label>Familienaam: </label>
            <input type="text" placeholder="Naam"
                   value="<?php print set_value('lastname', $users->lastname); ?>" name="lastname"/>
        </div>

        <div class="form-item-horizontal">
            <label>E-mail: </label>
            <input type="text" placeholder="E-mail"
                   value="<?php print set_value('email', $users->email); ?>" name="email"/>
        </div>
    </div>
</div>

<div class="box unpadded dsform admin_form" style="margin-top: 15px">
    <div class="inner_padding">
        <div class="form-item-horizontal admin-form-checks">
            <h2 class="admin_form_title">Voertuig en functies</h2>

            <div class="form-item-horizontal">
                <label>Standaard voertuig:</label>
                <?php print listbox('vehicle_id', $company_vehicles, $users->vehicle_id); ?>
            </div>

            <?php
            $data = array(
                'name' => 'is_signa',
                'value' => 1,
                'checked' => ($users->is_signa == 1)
            );

            echo '<div class="form-item-horizontal admin-user-checkbox">' . form_checkbox($data) . '<span>Signa?</span></div>';

            $data = array(
                'name' => 'is_towing',
                'value' => 1,
                'checked' => ($users->is_towing == 1)
            );

            echo '<div class="form-item-horizontal admin-user-checkbox">' . form_checkbox($data) . '<span>Takel?</span></div>';
            ?>
        </div>
    </div>
</div>

<div class="box unpadded dsform admin_form" style="margin-top: 15px">
    <div class="inner_padding">
        <div class="form-item-horizontal admin-form-checks">
            <h2 class="admin_form_title">Machtigingen</h2>


            <div class="form-item-horizontal admin-form-checks">
                <?php
                foreach ($roles as $role) {

                    $data = array(
                        'name' => 'roles[]',
                        'value' => $role->id,
                        'checked' => _userHasRole($users->user_roles, $role->id)
                    );

                    echo '<div class="form-item-horizontal admin-user-checkbox">' . form_checkbox($data) . '<span>' . $role->name . '</span></div>';
                }
                ?>
            </div>


        </div>
    </div>

    <div class="box form__actions">
        <div class="form__actions__cancel">
            <div class="form-item-horizontal">
                <a href="/admin/user">Annuleren</a>
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


<?php
function _userHasRole($userRoles, $id)
{
    foreach ($userRoles as $_role) {
        if ($_role->id == $id) {
            return true;
        }
    }

    return false;
}

?>
