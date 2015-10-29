<div class="status--indication">
    <a class="active" href="/admin/customer">Klanten</a>
    <a href="/admin/customer/upload">Importeer klanten</a>
    <a href="/admin/customer/export">Exporteer klanten</a>
</div>

<div class="layout-actions">
  <div class="btn--icon--highlighted bright">
    <a class="icon--add" href="/admin/customer/create">Create new customer</a>
  </div>
</div>




<div class="box">
<?php
//set table headers
$this->table->set_heading('Klantnummer', 'Naam', 'BTW-nummer', 'Adres', '&nbsp;', '&nbsp;');

if(isset($customers) && is_array($customers)) {
// add table row(s)
    foreach ($customers as $customer){
        $this->table->add_row(
            $customer->customer_number,
            $customer->company_name,
            $customer->company_vat,
            sprintf("%s %s %s %s %s %s", $customer->street, $customer->street_number, $customer->street_pobox, $customer->zip, $customer->city, $customer->country),
            sprintf('<a href="/admin/customer/delete/%s"><i class="fa fa-trash-o fa-2x">&nbsp;</i></a>', $customer->id),
            sprintf('<a href="/admin/customer/edit/%s"><i class="fa fa-pencil-square-o fa-2x">&nbsp;</i></a>', $customer->id)
        );
    }
}

//render table
echo $this->table->generate();
?>
</div>
