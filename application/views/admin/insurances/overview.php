<?php
$this->table->set_heading('id', 'Name'/** TABLE HEADERS TO BE ADDED */);

foreach ($insurances as $insurance){
    $this->table->add_row(
            $insurance->id,
            $insurance->name
            /**
             * add other fields here
             */
    );
}

echo $this->table->generate();
?>

<a href="/admin/insurance/create">Create new insurance</a>
