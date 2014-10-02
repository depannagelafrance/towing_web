<?php

$this->table->set_heading('Login', 'Voornaam', 'Naam', 'E-mail', 'Locked', 'Datum lock', 'Unlock', 'Reactivate', 'delete', 'update');

foreach ($users as $user){
    $this->table->add_row(
            $user->login,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->is_locked,
            $user->locked_ts
    );
}

echo $this->table->generate();
?>

<a href="/admin/user/create">Create new user</a>
