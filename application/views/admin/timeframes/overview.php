<div class="box">
<?php

//set table headers
$this->table->set_heading('Tarief', '&nbsp;');

// add table row(s)
foreach ($timeframes as $timeframe){
    $this->table->add_row(
            $timeframe->name,
            sprintf('<a href="/admin/timeframe/edit/%s"><i class="fa fa-pencil-square-o fa-2x"></i></a>', $timeframe->id)
    );
}

//render table
echo $this->table->generate();
?>
</div>
