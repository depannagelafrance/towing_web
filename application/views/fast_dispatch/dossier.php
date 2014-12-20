<?php
  $this->load->helper('listbox');
  $this->load->helper('date');

  $_dossier = $dossier->dossier;
  $_voucher_id = $voucher_number;

?>
<div class="layout-has-sidebar edit-view">
  <div class="layout-sidebar">
    <div class="box table_list table_list_small">
      <?php
      $this->load->helper('date');

      $this->table->set_heading('Takelbon');

      //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
      //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`

      if($vouchers && sizeof($vouchers) > 0) {
        foreach($vouchers as $voucher) {

          if($voucher->voucher_number === $_voucher_id){
            $class = 'active bright';
          }else{
            $class = 'inactive';
          }

          $this->table->add_row(
            array(
              'class' => $class,
              'data' => sprintf('<a class="id__cell" href="/fast_dispatch/dossier/%s/%s"><span class="id__cell__icon icon--ticket"></span><span class="id__cell__text__type">%s</span><span class="id__cell__text"><span class="id__cell__text__data"><span class="id__cell__text__nr">%s</span><span class="id__cell__text__info">%s %s</span></span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->voucher_number, $voucher->incident_type, $voucher->direction_name , $voucher->indicator_name)
            )

          //array('class' => $class, 'data' => mdate('%d/%m/%Y',strtotime($voucher->call_date))),
            //array('class' => $class, 'data' => mdate('%H:%i',strtotime($voucher->call_date)))
          );
        }
      }

      echo $this->table->generate();
      ?>
    </div>
  </div>



  <?php print form_open('fast_dispatch/dossier/save/' . $_dossier->dossier_number .'/'. $_voucher_id) ?>

  <div class="layout-content">

    <div class="box box--unpadded idbar">

      <div class="idbar__item idbar__id">
          <?php print $_voucher_id; ?>
      </div>

      <div class="idbar__item">
          <div class="idbar__label">
            <div class="icon--date"></div>
          </div>
          <div class="idbar__value">
            <?php print mdate('%d/%m/%Y',strtotime($_dossier->call_date)); ?>
          </div>
      </div>

      <div class="idbar__item">
        <div class="idbar__label">
          <div class="icon--clock"></div>
        </div>
        <div class="idbar__value">
          <?php print mdate('%H:%i',strtotime($_dossier->call_date)); ?>
        </div>
      </div>
    </div>

<?php
//TODO: @Gert, voorzien van een correcte styling voor de form errors!

$errors = validation_errors();

if($errors) {
  printf('<div class="msg msg__error">%s</div>', $errors);
}

?>


    <div class="box layout_2col_container">
      <div class="layout_2col_item">
        <div class="form-item-horizontal">
            <label>Richting:</label>
            <?php print listbox('direction', $directions, $_dossier->allotment_direction_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>KM Paal:</label>
            <?php print listbox('indicator', $indicators, $_dossier->allotment_direction_indicator_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Rijstrook:</label>

            <div class="trafficlane-container">
            <?php
              $data = array();
              $traffic_selected = array();

              foreach($traffic_lanes as $_traffic_lane)
              {
                $data[$_traffic_lane->id] = $_traffic_lane->name;
                  if($_traffic_lane->selected == 1){
                      array_push($traffic_selected, $_traffic_lane->id);
                  }
              }

              print form_multiselect('traffic_lanes', $data, $traffic_selected);

            ?>
            </div>
        </div>

        <div class="form-item-horizontal">
            <label>Type incident:</label>
            <?php print listbox('incident_type', $incident_types, $_dossier->incident_type_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Oproepnr.:</label>
            <?php print form_input('call_number', $_dossier->call_number); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Assistance:</label>
            <?php print listbox('insurance_id', $insurances, $_dossier->towing_vouchers[0]->insurance_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Dossiernr.:</label>
            <?php print form_input('insurance_dossiernr', $_dossier->towing_vouchers[0]->insurance_dossiernr); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Type wagen:</label>
            <?php print form_input('vehicule_type', $_dossier->towing_vouchers[0]->vehicule_type); ?>
        </div>

        <div class="form-item-horizontal form-item-licenseplate">
            <label>Nummerplaat:</label>
            <div class="licenseplate-container">
              <?php print form_input('vehicule_licenceplate', $_dossier->towing_vouchers[0]->vehicule_licenceplate); ?>

              <?php print listbox('licence_plate_country',
                            $licence_plate_countries,
                            $_dossier->towing_vouchers[0]->vehicule_country,
                            array(
                                'value_key' => 'name',
                                'label_key' => 'name',
                            )); ?>
            </div>
        </div>


        <div class="form-item-horizontal">
            <label>Afmelding CIC:</label>
            <?php print form_input('cic', $_dossier->towing_vouchers[0]->cic); ?>
        </div>
      </div>

  <!-- second column -->

      <div class="layout_2col_item">
        <div class="form-item-horizontal">
            <label>Perceel:</label>
            <div class="form-value">
              <?php
                  $data = array(
                    'name'        => 'allotment_name',
                    'value'       => $_dossier->allotment_name,
                    'readonly'    => 'readonly',
                    'style'       => 'background: #F0F0F0; width: 100%'
                  );
                  print form_input($data);
              ?>

              <?php print form_hidden('allotment_id', $_dossier->allotment_id); ?>
            </div>
        </div>

        <div class="form-item-horizontal">
            <label>Takeldienst:</label>
            <?php
              $data = array();

              if($_dossier->company_id) {
                $c = new stdClass();
                $c->id = $_dossier->company_id;
                $c->name = $_dossier->company_name;

                $data[] = $c;
              }

              print listbox('company_id', $data, $_dossier->company_id);
            ?>
        </div>

        <?php if(property_exists($_dossier, 'towing_company')): ?>
        <div class="form-item-horizontal telephone-container">
            <label></label>

            <div class="form-value bright" id="towing_service_phone">
              <span class="phone icon--phone"></span>
              <?php
                  printf("%s", $_dossier->towing_company->phone);
              ?>
            </div>
        </div>
        <?php endif; ?>



        <div class="form-item-horizontal">
            <label>Extra info:</label>
            <?php print form_textarea('additional_info', $_dossier->towing_vouchers[0]->additional_info); ?>
        </div>

      </div>

    </div>

    <!--SAVE-->
    <div class="box form__actions">
      <div class="form__actions__cancel"></div>
      <div class="form__actions__save">
        <div class="form-item">
          <input type="submit" value="Bewaren" name="btnSave" />
        </div>
      </div>
    </div>
    <!-- END SAVE -->
    <?php print form_close(); ?>

    <pre>

    <? var_dump($_dossier); ?>
    </pre>

  </div>
</div>

<script>
function fetchAllotmentAndTowingServices()
{
  var direction_id = $('#list_direction option:selected').val();
  var indicator_id = $('#list_indicator option:selected').val();

  $.getJSON("/fast_dispatch/ajax/allotments/"+direction_id+"/"+indicator_id, function(data, status, xhr) {
      if(data && data.length == 1) {
        var allotment = data.shift();

        $("input[name*='allotment_id']").val(allotment.id);
        $("input[name*='allotment_name']").val(allotment.name);

        $('#list_company_id').empty();

        $.each(allotment.towing_services, function(index, item) {
            $('#list_company_id').append($('<option/>', {
                    value: item.id,
                    text : item.name
                }));

            if(index == 0) {
              $('#towing_service_phone').text(item.phone);
            }
        });

        $('#list_company_id').trigger('chosen:updated');
      }
  });
}


$('#list_direction').change(function(){
  var id = $('#list_direction option:selected').val();

  $.getJSON("/fast_dispatch/ajax/indicators/"+id, function(data, status, xhr) {
      $('#list_indicator').empty();

      $.each(data, function(index, item) {
          $('#list_indicator').append($('<option/>', {
                  value: item.id,
                  text : item.name
              }));
      });

      $('#list_indicator').trigger('chosen:updated');
      fetchAllotmentAndTowingServices();
  });
});

$('#list_indicator').change(function(){
  fetchAllotmentAndTowingServices();
});

$(function() {
  // setTimeout() function will be fired after page is loaded
  // it will wait for 5 sec. and then will fire
  // $("#successMessage").hide() function
  /*
  setTimeout(function() {
    $('.msg').fadeOut(800)
  }, 3000);
  */
});


</script>
