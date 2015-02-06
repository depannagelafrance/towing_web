<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/vehicle/create">Create new vehicle</a>
  </div>
</div>

<div class="box">
  <?php

  //set table headers
  $this->table->set_heading('Naam', 'Nummerplaat', 'Type', '&nbsp;', '&nbsp;');
  //add table row(s)
  foreach ($vehicles as $item){
    $this->table->add_row(
      $item->name,
      $item->licence_plate,
      $item->type,
      sprintf('<a href="/admin/vehicle/delete/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $item->id),
      sprintf('<a href="/admin/vehicle/edit/%s"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $item->id)
  );
}

// and finally generate the table
echo $this->table->generate();

?>
</div>
