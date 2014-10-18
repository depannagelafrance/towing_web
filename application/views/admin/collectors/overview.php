<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/collector/create">Create new collector</a>
  </div>
</div>

<?php
//set table headers
$this->table->set_heading('Id', 'Naam');

// add table row(s)
foreach ($collectors as $collector){
    $this->table->add_row(
            $collector->id,
            $collector->name,
            anchor('admin/collector/delete/' . $collector->id, 'delete'),
            anchor('admin/collector/edit/' . $collector->id, 'update')
            /**
             * TO REPLACE ANCHORS ABOVE WITH IMAGES -> ADD IMAGE SOURCE (see example below)
             * anchor('admin/user/unlock/' . $user->id, img(array('src'=>'images/???.png','border'=>'0','alt'=>'Delete')));
             *
             */
    );
}
//render table
echo $this->table->generate();
?>
