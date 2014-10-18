<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/user/create">Create new user</a>
  </div>
</div>

<?php

//set table headers
$this->table->set_heading('Login', 'Voornaam', 'Naam', 'E-mail', 'Locked', 'Datum lock', 'Unlock', /*'Reactivate',*/ 'delete', 'update');
//add table row(s)
foreach ($users as $user){
    $this->table->add_row(
            $user->login,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->is_locked,
            $user->locked_ts,
            /**
             * TO REPLACE ANCHORS ABOVE WITH IMAGES -> ADD IMAGE SOURCE (see example below)
             * anchor('admin/user/unlock/' . $user->id, img(array('src'=>'images/???.png','border'=>'0','alt'=>'Delete')));
             *
             */
            anchor('admin/user/unlock/' . $user->id, 'unlock'),
            //anchor('admin/user/reactivate/' . $user->id, 'reactivate'),
            anchor('admin/user/delete/' . $user->id, 'delete'),
            anchor('admin/user/edit/' . $user->id, 'update')
    );
}

// and finally generate the table
echo $this->table->generate();

?>
