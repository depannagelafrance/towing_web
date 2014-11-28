<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/collector/create">Create new timeframe</a>
  </div>
</div>

<?php

//set table headers
$this->table->set_heading('Id', 'Naam');

// add table row(s)
foreach ($timeframes as $timeframe){
    $this->table->add_row(
            $timeframe->id,
            $timeframe->name,
            anchor('admin/timeframe/edit/' . $timeframe->id, 'edit')
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