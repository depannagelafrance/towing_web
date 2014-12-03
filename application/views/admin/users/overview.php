<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/user/create">Create new user</a>
  </div>
</div>

<div class="box">
<?php

//set table headers
$this->table->set_heading('Login', 'Voornaam', 'Naam', 'E-mail', 'Locked', 'Datum lock', '&nbsp;', '&nbsp;', '&nbsp;');
//add table row(s)
foreach ($users as $user){
    $this->table->add_row(
            $user->login,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->is_locked,
            $user->locked_ts,

            sprintf('<a href="/admin/user/unlock/%s"><i class="fa fa-unlock fa-2x">&nbsp;</i></a>', $user->id),
            sprintf('<a href="/admin/user/delete/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $user->id),
            sprintf('<a href="/admin/user/edit/%s"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $user->id)
    );
}

// and finally generate the table
echo $this->table->generate();

?>
</div>
