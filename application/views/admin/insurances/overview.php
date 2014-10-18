<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/insurance/create">Create new insurance</a>
  </div>
</div>

<?php
$this->table->set_heading('id', 'Name'/** TABLE HEADERS TO BE ADDED */);

foreach ($insurances as $insurance){
    $this->table->add_row(
            $insurance->id,
            $insurance->name,
            /**
             * add other fields here
             */
            anchor('admin/insurance/delete/' . $insurance->id, 'delete'),
            anchor('admin/insurance/edit/' . $insurance->id, 'update')
    );
}

echo $this->table->generate();
?>
