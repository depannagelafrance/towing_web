<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/collector/create">Create new collector</a>
  </div>
</div>


<div class="box">
<?php
//set table headers
$this->table->set_heading('Naam', 'BTW-nummer', 'Adres', '&nbsp;', '&nbsp;');

// add table row(s)
foreach ($collectors as $collector){
    $this->table->add_row(
            $collector->name,
            $collector->vat,
            sprintf("%s %s %s %s %s %s", $collector->street, $collector->street_number, $collector->street_pobox, $collector->zip, $collector->city, $collector->country),
            sprintf('<a href="/admin/collector/delete/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $collector->id),
            sprintf('<a href="/admin/collector/edit/%s"><i class="fa fa-pencil-square-o fa-2x">&nbsp;</i></a>', $collector->id)
    );
}
//render table
echo $this->table->generate();
?>
</div>
