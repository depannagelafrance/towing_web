<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/insurance/create">Create new insurance</a>
  </div>
</div>

<div class="box">
<?php
$this->table->set_heading('ID', 'Name', '&nbsp;', '&nbsp;');

foreach ($insurances as $insurance){
    $this->table->add_row(
            $insurance->id,
            $insurance->name,
            sprintf('<a href="/admin/insurance/delete/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $insurance->id),
            sprintf('<a href="/admin/insurance/edit/%s"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $insurance->id)
    );
}

echo $this->table->generate();
?>
</div>
