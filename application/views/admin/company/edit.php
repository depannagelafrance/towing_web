<?php echo form_open('admin/company/edit')?>
<div class="box layout_2col_container">
  <?php echo validation_errors(); ?>


  <div class="layout_2col_item">
    <h2>Bedrijfsgegevens</h2>
    <div class="form-item-horizontal">
        <label>Naam: </label>
        <?php print form_input('company_name', $company->name); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Code: </label>
      <?php print form_input('company_code', $company->code); ?>
    </div>


    <div class="form-item-horizontal">
      <label>BTW: </label>
      <?php print form_input('company_vat', $company->vat); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Straat: </label>
      <?php print form_input('company_street', $company->street); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Nummber: </label>
      <?php print form_input('company_street_number', $company->street_number); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Bus: </label>
      <?php print form_input('company_street_pobox', $company->street_pobox); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Postcode: </label>
      <?php print form_input('company_zip', $company->zip); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Gemeente: </label>
      <?php print form_input('company_city', $company->city); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Telefoon: </label>
      <?php print form_input('company_phone', $company->phone); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Fax: </label>
      <?php print form_input('company_fax', $company->fax); ?>
    </div>

    <div class="form-item-horizontal">
      <label>E-mail: </label>
      <?php print form_input('company_email', $company->email); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Website: </label>
      <?php print form_input('company_website', $company->website); ?>
    </div>
  </div>
</div>

<div class="box layout_2col_container">
  <div class="layout_2col_item">
    <h2>Depot</h2>
    <div class="form-item-horizontal">
      <label>Naam: </label>
      <?php print form_input('depot_name', $depot->name); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Straat: </label>
      <?php print form_input('depot_street', $depot->street); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Nummber: </label>
      <?php print form_input('depot_street_number', $depot->street_number); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Bus: </label>
      <?php print form_input('depot_street_pobox', $depot->street_pobox); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Postcode: </label>
      <?php print form_input('depot_zip', $depot->zip); ?>
    </div>

    <div class="form-item-horizontal">
      <label>Gemeente: </label>
      <?php print form_input('depot_city', $depot->city); ?>
    </div>

  </div>
</div>

<div class="form-item-horizontal">
  <input type="submit" name="submit" value="Opslaan" />
</div>

<div class="form-item-horizontal">
  <a href="/admin/company">Annuleren</a>
</div>
  <?php echo form_close();?>
