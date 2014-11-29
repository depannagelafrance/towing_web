<?php

//set table headers
$this->table->set_heading('Tarief');

// add table row(s)
foreach ($timeframes as $timeframe){
    $this->table->add_row(
            $timeframe->name,
            anchor('admin/timeframe/edit/' . $timeframe->id, 'edit')
    );
}

//render table
echo $this->table->generate();
?>
