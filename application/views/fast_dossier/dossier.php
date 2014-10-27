<?php

function composeCustomerInformation($c) {
  $output = "<div>";

  if($c->company_name) {
    $output .= $c->company_name;
  } else {
    $output .= sprintf("%s %s", $c->last_name, $c->first_name);
  }

  $output .= "</div>";
  $output .= "<div>";
  $output .= sprintf("%s %s %s", $c->street, $c->street_number, ($c->street_pobox ? "/" . $c->street_pobox : ""));
  $output .= "</div>";
  $output .= "<div>" . sprintf("%s %s", $c->zip, $c->city) . "</div>";
  $output .= "<div>" . $c->country . "</div>";
  $output .= "<div>T: " . $c->phone . "</div>";
  $output .= "<div>E: " . $c->email . "</div>";

  return $output;
}


$this->load->helper('listbox');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>
<div class="layout-has-sidebar edit-view">
  <div class="layout-sidebar">
    <div class="box table_list table_list_small">

      <?php

      $last = $this->uri->total_segments();
      $url_dossier_id = $this->uri->segment($last - 1);
      $url_takelbon_id = $this->uri->segment($last);


      $this->load->helper('date');

      $this->table->set_heading('Dossier');

      //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
      //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`
      $prev = '';
      if($vouchers && sizeof($vouchers) > 0) {
        foreach($vouchers as $voucher) {

          if($voucher->dossier_number === $url_dossier_id){
            $class = 'active bright';
          }else{
            $class = 'inactive';
          }

          if($prev !== $voucher->dossier_number){

            $prev = $voucher->dossier_number;

            $this->table->add_row(
                  array('class' => $class, 'data' => sprintf('<a class="id__cell" href="/fast_dossier/dossier/%s/%s"><span class="id__cell__icon icon--map"></span><span class="id__cell__text">%s</span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->dossier_number)) // $voucher->voucher_number),
                  //array('class' => $class, 'data' => mdate('%d %M',strtotime($voucher->call_date))),
                  //array('class' => $class, 'data' => mdate('%H:%i',strtotime($voucher->call_date)))
            );

          }
        }
      }

      echo $this->table->generate();

      ?>
    </div>
  </div>

  <div class="layout-content">
    <div class="box box--unpadded idbar">

      <div class="idbar__item idbar__id bright has_icon">
        <div class="idbar__icon icon--map"></div>
        <div class="idbar__id__value"><?php print $_dossier->dossier_number; ?></div>
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


      <div class="idbar__incident">
        <?php print $_dossier->incident_type_name; ?>
      </div>

    </div>

    <div class="box detailbar">
      <div class="detailbar__row">
        <div class="form-item-horizontal less_padded">
          <label>Oproepnr.&nbsp;:</label>
          <div class="value"><?php print $_dossier->call_number; ?></div>
        </div>

        <div class="form-item-horizontal less_padded">
          <label>Perceel&nbsp;:</label>
          <div class="value"><?php print $_dossier->allotment_name ?></div>
        </div>

        <div class="form-item-horizontal less_padded">
          <label>Toegewezen aan&nbsp;:</label>
          <div class="value"><?php print $_dossier->company_name ?></div>
        </div>
      </div>

      <div class="detailbar__row">

         <div class="form-item-horizontal less_padded">
           <label>Richting&nbsp;:</label>
           <div class="value"><?php print $_dossier->direction_name; ?></div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>KM Paal&nbsp;:</label>
           <div class="value"><?php print $_dossier->indicator_name; ?></div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>Rijstrook&nbsp;:</label>
           <div class="value"><?php print $_dossier->traffic_lane_name; ?></div>
         </div>
      </div>

    </div>

  <?php
  print validation_errors();

  $_voucher = null;

  foreach($_dossier->towing_vouchers as $_v) {
    if($_v->voucher_number == $voucher_number) {
      $_voucher = $_v;
    }
  }

  if(!$_voucher)
    $_voucher = $_dossier->towing_vouchers[0];


  print form_open('fast_dossier/dossier/save/' . $_dossier->dossier_number . '/' . $_voucher->voucher_number);

  ?>

  <div class="dossierbar">

    <div class="dossierbar__vouchers">
      <?php
        foreach($_dossier->towing_vouchers as $_v) :
          $_is_selected = ($_v->voucher_number == $_voucher->voucher_number);
      ?>
          <div class="dossierbar__id box has_icon <?php print ($_is_selected || sizeof($_dossier->towing_vouchers) == 1) ? 'active bright' : 'inactive'; ?>">
            <div class="dossierbar__icon icon--ticket"></div>
            <div class="dossierbar__id__value">
            <?php

            if($_is_selected || sizeof($_dossier->towing_vouchers) == 1) {
              printf('%s', $_v->voucher_number);
            } else {
              printf('<a href="/fast_dossier/dossier/%s/%s">%s</a>', $_dossier->dossier_number, $_v->voucher_number, $_v->voucher_number);
            }
            ?>
            </div>
          </div>
      <?php
        endforeach;
      ?>
    </div>

    <div class="dossierbar__mainactions">
      <!--
      <div class="dossierbar__mainaction__item">
        <div class="btn--icon">
          <a class="icon--edit" href="#">Edit</a>
        </div>
      </div>
      -->
      <div class="dossierbar__mainaction__item">
        <div class="btn--icon--highlighted bright">
          <a class="icon--add" href="/fast_dossier/dossier/voucher/<?=$_dossier->id?>">Add</a>
        </div>
      </div>
    </div>

    <div class="dossierbar__actions">
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a id="add-nota-link" class="icon--nota" href="#add-nota-form">Nota</a>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a class="icon--attachement" href="">Bijlage</a>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a id="add-email-link" class="icon--email" href="#add-email-form">Email</a>
        </div>
      </div>

      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--print">Print</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a href="/fast_dossier/report/voucher/towing/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar Takeldienst</a></li>
            <li><a href="/fast_dossier/report/voucher/collector/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar Afhaler</a></li>
            <li><a href="/fast_dossier/report/voucher/customer/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar Klant</a></li>
            <li><a href="/fast_dossier/report/voucher/other/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar op Aanvraag</a></li>
          </ul>
        </div>
      </div>

    </div>

  </div>

  <div class="box unpadded dsform">
    <div class="inner_padding">
      <!--SIGNA-->
      <div class="signa-container">
        <div class="signa-container__left">
          <div class="form-item-horizontal signa-container__signa">
            <label>Signa:</label>
            <?php print form_input('signa_by', $_voucher->signa_by); ?>
          </div>

          <div class="form-item-horizontal signa-container__licenceplate">
            <label>Nummerplaat:</label>
            <?php print form_input('signa_by_vehicle', $_voucher->signa_by_vehicle); ?>
          </div>
        </div>

        <div class="signa-container__right">
          <div class="form-item-horizontal signa-container__arrival">
            <label>Aankomst:</label>
            <?php print form_input('signa_arrival', mdate('%H:%i',strtotime($_voucher->signa_arrival))); ?>
          </div>
        </div>
      </div>
      <!-- END SIGNA -->

      <!--TOWED BY-->
      <div class="towedby-container">
        <div class="towedby-container__left">
          <div class="form-item-horizontal towedby-container__towedby">
            <label>Takelaar:</label>
            <?php print form_input('towed_by', $_voucher->towed_by); ?>
          </div>

          <div class="form-item-horizontal towedby-container__licenceplate">
            <label>Nummerplaat:</label>
            <?php print form_input('towed_by_vehicle', $_voucher->towed_by_vehicle); ?>
          </div>
        </div>

        <div class="towedby-container__right">
          <div class="form-item-horizontal towedby-container__call">
            <label>Oproep:</label>
            <?php print form_input('towing_called', mdate('%H:%i',strtotime($_voucher->towing_called))); ?>
          </div>

          <div class="form-item-horizontal towedby-container__arival">
            <label>Aankomst:</label>
            <?php print form_input('towing_arrival', mdate('%H:%i',strtotime($_voucher->towing_arrival))); ?>
          </div>

          <div class="form-item-horizontal towedby-container__start">
            <label>Start:</label>
            <?php print form_input('towing_start', mdate('%H:%i',strtotime($_voucher->towing_start))); ?>
          </div>

          <div class="form-item-horizontal towedby-container__completed">
            <label>Stop:</label>
            <?php print form_input('towing_completed', mdate('%H:%i',strtotime($_voucher->towing_completed))); ?>
          </div>

        </div>
      </div>
      <!-- END TOWEDBY -->

      <!-- VEHICULE -->
      <div class="vehicule-container">
        <div class="vehicule-container__left">
          <div class="form-item-horizontal vehicule-container__vehicule">
            <label>Type wagen:</label>
            <?php print form_input('vehicule_type', $_voucher->vehicule_type); ?>
          </div>

          <div class="form-item-horizontal vehicule-container__license">
            <label>Nummerplaat:</label>
            <?php print form_input('vehicule_licenceplate', $_voucher->vehicule_licenceplate); ?>
          </div>
        </div>

        <div class="vehicule-container__right">
          <div class="form-item-horizontal vehicule-container__country">
            <label>Land:</label>
            <?php print listbox('licence_plate_country',
              $licence_plate_countries,
              $_voucher->vehicule_country,
              array(
                'value_key' => 'name',
                'label_key' => 'name',
              )); ?>
          </div>
        </div>
      </div>
      <!-- END CAR -->

      <div class="dsform__clearfix dsform_seperation">
        <div class="dsform__left">

          <!--FACTURATION-->
          <div class="form-item-vertical facturation-container">
            <label>Facturatiegegevens:</label>
            <div class="facturation-container__info">
              <?php print(composeCustomerInformation($_voucher->customer)) ?>
            </div>
            <a id="edit-invoice-data-link" class="inform-link icon--edit--small" href="#edit-invoice-data-form">Bewerken</a>
          </div>
          <!--END FACTURATION-->

          <!--NUISANCE-->
          <div class="form-item-vertical nuisance-container">
            <label>Hinderverwekker:</label>
            <div class="nuisance-container__info">
              <?php print(composeCustomerInformation($_voucher->causer)) ?>
            </div>
            <a id="edit-nuisance-data-link" class="inform-link icon--edit--small" href="#edit-nuisance-data-form">Bewerken</a>
          </div>
          <!--END NUISANCE-->

        </div>
        <div class="dsform__right">

          <!--DEPOT-->
          <div class="form-item-horizontal depot-container">
            <label>Depot:</label>
            <div class="depot-container__name"><?php print $_voucher->depot->display_name; ?></div>
            <a id="edit-depot-link" class="inform-link icon--edit--small" href="#edit-depot-form">Bewerken</a>
          </div>
          <!-- END DEPOT-->

          <!--ASSI-->
          <div class="form-item-horizontal  assistance-container">
            <label>Assistance:</label>
            <?php print listbox('insurance_id', $insurances, $_voucher->insurance_id); ?>
          </div>
          <!--END ASSI-->

          <!--DOSS-->
          <div class="form-item-horizontal dossiernr-container">
            <label>Dossiernr.:</label>
            <?= form_input('insurance_dossiernr', $_voucher->insurance_dossiernr); ?>
          </div>
          <!--END DOSS-->

          <!--WARENTY-->
          <div class="form-item-horizontal warrenty-container">
            <label>Garantie:</label>
            <?= form_input('insurance_warranty_held_by', $_voucher->insurance_warranty_held_by); ?>
          </div>
          <!--END WARENTY-->

        </div>
      </div>


      <!--WORK-->
      <div class="form-item-vertical work-container">
        <div class="work-container__fields">
          <div class="form-item-vertical work-container__task">
            <label>Werkzaamheden:</label>
            <?php
              foreach($_voucher->towing_activities as $_activity) {
                $data = array(
                  'name'        => 'name[]',
                  'value'       => $_activity->name,
                  'readonly'    => 'readonly',
                  'style'       => 'background: #F0F0F0'
                );

                print form_input($data);
                print form_hidden('activity_id[]', $_activity->activity_id);
              }
            ?>
          </div>

          <div class="form-item-vertical work-container__number">
            <label>Aantal:</label>
            <?php
            foreach($_voucher->towing_activities as $_activity) {
              print form_input('amount[]', $_activity->amount);
            }
            ?>
          </div>

          <div class="form-item-vertical work-container__unitprice">
            <label>EHP:</label>
            <?php
            foreach($_voucher->towing_activities as $_activity) {
              $data = array(
                'name'        => 'fee_incl_vat[]',
                'value'       => $_activity->fee_incl_vat,
                'readonly'    => 'readonly',
                'style'       => 'background: #F0F0F0'
              );

              print form_input($data);
            }
            ?>
          </div>

          <div class="form-item-vertical work-container__excl">
            <label>Excl:</label>
            <?php
            foreach($_voucher->towing_activities as $_activity) {
              $data = array(
                'name'        => 'cal_fee_excl_vat[]',
                'value'       => $_activity->cal_fee_excl_vat,
                'readonly'    => 'readonly',
                'style'       => 'background: #F0F0F0'
              );

              print form_input($data);
            }
            ?>
          </div>

          <div class="form-item-vertical work-container__incl">
            <label>Incl:</label>
            <?php
            foreach($_voucher->towing_activities as $_activity) {
              $data = array(
                'name'        => 'cal_fee_incl_vat[]',
                'value'       => $_activity->cal_fee_incl_vat,
                'readonly'    => 'readonly',
                'style'       => 'background: #F0F0F0'
              );

              print form_input($data);
            }
            ?>
          </div>
          <div class="form-item-vertical work-container__remove">
            <?php foreach($_voucher->towing_activities as $_activity){ ?>
              <div class="work-container__remove__btn">
                <div class="btn--icon--small">
                  <a class="icon--remove--small" href="#">Remove</a>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="work-container__actions">
          <div class="work-container__add">
            <a id="add-work-link" class="inform-link" href="#add-work-form">Werkzaamheid toevoegen</a>
          </div>
        </div>

        <!--PAYMENT-->
        <div class="form-item-vertical payment-container">
          <div class="form-item-vertical payment-container__insurance">
            <label class="notbold">Garantie:</label>
            <?php print form_input('amount_guaranteed_by_insurance', $_voucher->towing_payments->amount_guaranteed_by_insurance); ?>
          </div>

          <div class="form-item-vertical payment-container__amount_customer">
            <label class="notbold">Te betalen:</label>
            <?php print form_input('amount_customer', $_voucher->towing_payments->amount_customer); ?>
          </div>

          <div class="form-item-vertical payment-container__paid_in_cash">
            <label class="notbold">Contant:</label>
            <?php print form_input('paid_in_cash', $_voucher->towing_payments->paid_in_cash); ?>
          </div>

          <div class="form-item-vertical payment-container__paid_by_bank_deposit">
            <label class="notbold">Overschrijving:</label>
            <?php print form_input('paid_by_bank_deposit', $_voucher->towing_payments->paid_by_bank_deposit); ?>
          </div>

          <div class="form-item-vertical payment-container__paid_by_debit_card">
            <label class="notbold">Maestro:</label>
            <?php print form_input('paid_by_debit_card', $_voucher->towing_payments->paid_by_debit_card); ?>
          </div>

          <div class="form-item-vertical payment-container__paid_by_credit_card">
            <label class="notbold">Creditcard:</label>
            <?php print form_input('paid_by_credit_card', $_voucher->towing_payments->paid_by_credit_card); ?>
          </div>

          <div class="form-item-vertical payment-container__cal_amount_paid">
            <label class="notbold">Betaald:</label>
            <?php print form_input('cal_amount_paid', $_voucher->towing_payments->cal_amount_paid); ?>
          </div>

          <div class="form-item-vertical payment-container__cal_amount_unpaid">
            <label class="notbold">Openstaand:</label>
            <?php print form_input('cal_amount_unpaid', $_voucher->towing_payments->cal_amount_unpaid); ?>
          </div>

        </div>


      </div>
      <!-- END WORK-->



      <!--AUTOGRAPHS-->
      <div class="autograph-container">
        <div class="autograph-container__police">
          <label>Bevestiging politie:</label>

          <div class="form-item-horizontal  autograph-container__police__trafficpost">
            <label class="notbold">Verkeerspost:</label>
            <?php print listbox('traffic_post_id', $traffic_posts, $_dossier->police_traffic_post_id); ?>
          </div>

          <div class="form-item-horizontal  autograph-container__police__timestamp">
            <label class="notbold">Tijdstip:</label>
            <?php print form_input('police_signature_dt', mdate('%H:%i',strtotime($_voucher->police_signature_dt))); ?>
          </div>
        </div>
        <div class="autograph-container__nuisance">
          <label>Bevestiging hinderverwekker:</label>

          <div class="form-item-horizontal">
            <div class="nuisance_value">
              <?php print $_voucher->causer->first_name . ' ' . $_voucher->causer->last_name; ?>
            </div>
            <div class="nuisance_value">
              <?php print $_voucher->causer->street . ' ' . $_voucher->causer->street_number . ' ' . $_voucher->causer->street_pobox; ?>
            </div>
            <div class="nuisance_value">
              <?php print $_voucher->causer->zip . ' ' . $_voucher->causer->city; ?>
            </div>
          </div>
        </div>
        <div class="autograph-container__collecting">
          <label>Bevestiging afhaler:</label>

          <div class="form-item-horizontal  autograph-container__collecting__collector">
            <label class="notbold">Afhaler:</label>
            <?php print listbox('collector_id', $collectors, $_voucher->collector_id); ?>
          </div>

          <div class="form-item-horizontal  autograph-container__collecting__date">
            <label class="notbold">Datum:</label>
            <?php print form_input('vehicule_collected', mdate('%d/%m/%Y %H:%i',strtotime($_voucher->vehicule_collected))); ?>
          </div>
        </div>
      </div>
      <!-- AUTHOGRAPH BUTTONS -->
      <div class="autograph-container-buttons">
        <div class="autograph-container__police">
          <?php
          $police_has_autograph = false;
          $police_collecting_url = 'none';
          $police_class = '';
          if(property_exists($_voucher, 'signature_traffic_post') && $_voucher->signature_traffic_post) {
            $police_class = 'active';
            $police_has_autograph = true;
            $police_collecting_url = "/fast_dossier/image/view/" . $_voucher->signature_traffic_post->document_blob_id . '/200/125';
          }
          ?>
          <div class="autograph-block autograph-container__police__autograph <?php print $police_class; ?>" style="background-image: url(<?php print $police_collecting_url; ?>);">
            <?php if($police_has_autograph): ?>
              <a id="edit-autograph-police" class="inform-link icon--edit--small" href="#"></a>
            <?php else: ?>
              <a class="add_autograph" href="#">Voeg een handtekening toe</a>
            <?php endif; ?>
          </div>
        </div>

        <div class="autograph-container__nuisance">
          <?php
          $nuisance_has_autograph = false;
          $nuisance_collecting_url = 'none';
          $nuisance_class = '';
          if(property_exists($_voucher, 'signature_causer') && $_voucher->signature_causer) {
            $nuisance_class = 'active';
            $nuisance_has_autograph = true;
            $nuisance_collecting_url = "/fast_dossier/image/view/" . $_voucher->signature_causer->document_blob_id . '/200/125';
          }
          ?>
          <div class="autograph-block autograph-container__nuisance__autograph <?php print $nuisance_class; ?>" style="background-image: url(<?php print $nuisance_collecting_url; ?>);">
            <?php if($nuisance_has_autograph): ?>
              <a id="edit-autograph-nuisance" class="inform-link icon--edit--small" href="#"></a>
            <?php else: ?>
              <a class="add_autograph" href="#">Voeg een handtekening toe</a>
            <?php endif; ?>
          </div>
        </div>

        <div class="autograph-container__collecting">
          <?php
          $collecting_class = '';
          $collecting_has_autograph = false;
          $autograph_collecting_url = 'none';
          if(property_exists($_voucher, 'signature_collector') && $_voucher->signature_collector) {
            $collecting_class = 'active';
            $collecting_has_autograph = true;
            $autograph_collecting_url = "/fast_dossier/image/view/" . $_voucher->signature_collector->document_blob_id . '/200/125';
          }
          ?>
          <div class="autograph-block autograph-container__collecting__autograph <?php print $collecting_class; ?>" style="background-image: url(<?php print $autograph_collecting_url; ?>);">
            <?php if($collecting_has_autograph): ?>
              <a id="edit-autograph-collecting" class="inform-link icon--edit--small" href="#"></a>
            <?php else: ?>
              <a class="add_autograph" href="#">Voeg een handtekening toe</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!-- END AUTOGRAPH BUTTONS -->
      <!-- END AUTOGRAPHS-->
    </div>

    <!--SAVE-->
    <div class="form__actions">
      <div class="form__actions__cancel"></div>
      <div class="form__actions__save">
        <div class="form-item">
          <input type="submit" value="Bewaren" name="btnSave" />
        </div>
      </div>
    </div>
    <!-- END SAVE -->

  </div>



  </div>
  <?= form_close(); ?>

  <!-- DEPOT -->
  <div id="edit-depot-form" style="display: none;">
    <div class="fancybox-form">
      <h3>Depot Bewerken</h3>
      <?php $depot_hidden = array('id' => $_voucher->depot->id, 'vid' => $_voucher->id, 'did' => $_dossier->id); ?>
      <?php print form_open('','',$depot_hidden); ?>
      <!-- DEPOT -->
      <div class="depot-full-container">
        <div class="depot-full-container__left">
          <div class="form-item-horizontal depot-full-container__depot">
            <label>Depot:</label>
            <?php print form_input('name', $_voucher->depot->name); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__street">
            <label>Straat:</label>
            <?php print form_input('street', $_voucher->depot->street); ?>
          </div>
        </div>
        <div class="depot-full-container__right">

          <div class="form-item-horizontal depot-full-container__streetnr">
            <label>Nr:</label>
            <?php print form_input('street_number', $_voucher->depot->street_number); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__streetbox">
            <label>Box:</label>
            <?php print form_input('street_pobox', $_voucher->depot->street_pobox); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__postal">
            <label>Zip:</label>
            <?php print form_input('zip', $_voucher->depot->zip); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__city">
            <label>City:</label>
            <?php print form_input('city', $_voucher->depot->city); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Depot X" name="btnDepotCompany" />
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnDepotSave" />
      </div>
    </div>
    <?php print form_close(); ?>
  </div>


  <!-- INVOICE -->
  <div id="edit-invoice-data-form" style="display: none;">
    <div class="fancybox-form">
        <h3>Facturatie gegevens Bewerken</h3>
        <?php $fact_hidden = array('customer-id' => $_voucher->customer->id, 'customer-voucher_id' => $_voucher->customer->voucher_id); ?>
        <?php form_open('','',$fact_hidden); ?>
        <div class="invoice-full-container">

        <div class="invoice-full-container__name">
          <div class="form-item-horizontal invoice-full-container__first_name">
            <label>Voornaam:</label>
            <?php print form_input('customer-first_name', $_voucher->customer->first_name); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__last_name">
            <label>Achternaam:</label>
            <?php print form_input('customer-last_name', $_voucher->customer->last_name); ?>
          </div>
        </div>

        <div class="invoice-full-container__company">
          <div class="form-item-horizontal invoice-full-container__company_name">
            <label>Bedrijf:</label>
            <?php print form_input('customer-company_name', $_voucher->customer->company_name); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__company_vat">
            <label>VAT:</label>
            <?php print form_input('customer-company_vat', $_voucher->customer->company_vat); ?>
          </div>
        </div>

        <div class="invoice-full-container__address__street">
          <div class="form-item-horizontal invoice-full-container__street">
            <label>Straat:</label>
            <?php print form_input('customer-street', $_voucher->customer->street); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__street_number">
            <label>Nr:</label>
            <?php print form_input('customer-street_number', $_voucher->customer->street_number); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__street_pobox">
            <label>Bus:</label>
            <?php print form_input('customer-street_pobox', $_voucher->customer->street_pobox); ?>
          </div>
        </div>

        <div class="invoice-full-container__address__city">
          <div class="form-item-horizontal invoice-full-container__zip">
            <label>Postcode:</label>
            <?php print form_input('customer-zip', $_voucher->customer->zip); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__city">
            <label>Gemeente:</label>
            <?php print form_input('customer-city', $_voucher->customer->city); ?>
          </div>
        </div>

        <div class="form-item-horizontal invoice-full-container__country">
          <label>Land:</label>
          <?php print form_input('customer-country', $_voucher->customer->country); ?>
        </div>

        <div class="invoice-full-container__contact">
          <div class="form-item-horizontal invoice-full-container__phone">
            <label>Telefoon:</label>
            <?php print form_input('customer-phone', $_voucher->customer->phone); ?>
          </div>

          <div class="form-item-horizontal invoice-full-container__email">
            <label>Email:</label>
            <?php print form_input('customer-email', $_voucher->customer->email); ?>
          </div>
        </div>

      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnInvoiceSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <!-- NUISANCE -->
  <div id="edit-nuisance-data-form" style="display: none;">
    <div class="fancybox-form">
      <h3>Hinderverwerker gegevens Bewerken</h3>
      <?= form_open(); ?>
      <!-- DEPOT -->
      <div class="nuisance-full-container">
      <div class="nuisance-full-container__name">
        <div class="form-item-horizontal nuisance-full-container__first_name">
          <label>Voornaam:</label>
          <?php print form_input('causer-first_name', $_voucher->causer->first_name); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__last_name">
          <label>Achternaam:</label>
          <?php print form_input('causer-last_name', $_voucher->causer->last_name); ?>
        </div>
      </div>

      <div class="nuisance-full-container__company">
        <div class="form-item-horizontal nuisance-full-container__company_name">
          <label>Bedrijf:</label>
          <?php print form_input('causer-company_name', $_voucher->causer->company_name); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__company_vat">
          <label>Bedrijf VAT:</label>
          <?php print form_input('causer-company_vat', $_voucher->causer->company_vat); ?>
        </div>
      </div>

      <div class="nuisance-full-container__address__street">
        <div class="form-item-horizontal nuisance-full-container__street">
          <label>Straat:</label>
          <?php print form_input('causer-street', $_voucher->causer->street); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__street_number">
          <label>Nummer:</label>
          <?php print form_input('causer-street_number', $_voucher->causer->street_number); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__street_pobox">
          <label>Bus:</label>
          <?php print form_input('causer-street_pobox', $_voucher->causer->street_pobox); ?>
        </div>
      </div>

      <div class="nuisance-full-container__address__city">
        <div class="form-item-horizontal nuisance-full-container__zip">
          <label>Postcode:</label>
          <?php print form_input('causer-zip', $_voucher->causer->zip); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__city">
          <label>Gemeente:</label>
          <?php print form_input('causer-city', $_voucher->causer->city); ?>
        </div>
      </div>

      <div class="form-item-horizontal nuisance-full-container__country">
        <label>Land:</label>
        <?php print form_input('causer-country', $_voucher->causer->country); ?>
      </div>

      <div class="nuisance-full-container__contact">
        <div class="form-item-horizontal nuisance-full-container__phone">
          <label>Telefoon:</label>
          <?php print form_input('causer-phone', $_voucher->causer->phone); ?>
        </div>

        <div class="form-item-horizontal nuisance-full-container__email">
          <label>Email:</label>
          <?php print form_input('causer-email', $_voucher->causer->email); ?>
        </div>
      </div>


      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnNuisanceSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>


  <!-- EMAIL -->
  <div id="add-email-form" style="display: none;">
    <div class="fancybox-form">
      <h3>Email versturen</h3>
      <?= form_open(); ?>

      <div class="form-item-horizontal">
        <label>Email:</label>
        <?php print form_input('email'); ?>
      </div>

      <div class="form-item-horizontal">
        <label>Onderwerp:</label>
        <?php print form_input('email-subject'); ?>
      </div>

      <div class="form-item-horizontal">
        <label>Bericht:</label>
        <?php print form_textarea('email-message'); ?>
      </div>

    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnEmailSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <!-- NOTA -->
  <div id="add-nota-form" style="display: none;">
    <div class="fancybox-form">
      <h3>Nota toevoegen</h3>
      <?= form_open(); ?>

      <div class="form-item-horizontal">
        <label>Nota:</label>
        <?php print form_textarea('nota'); ?>
      </div>

    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnNotaSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <!-- WORK -->
  <div id="add-work-form" style="display: none;">
    <div class="fancybox-form">
      <h3>Werkzaamheid toevoegen</h3>
      <?php

      print form_open();


      $this->table->set_heading('Activiteit', 'Code', 'Prijs (excl. BTW)', 'Prijs (incl. BTW)');

      if($available_activities && sizeof($available_activities) > 0) {
        foreach($available_activities as $activity) {
            $this->table->add_row(
              sprintf('<a class="id__cell" href="#activity_%s">%s</a>', $activity->id, $activity->name),
              $activity->code,
              $activity->fee_excl_vat,
              $activity->fee_incl_vat
            );
        }
      }

      echo $this->table->generate();

      ?>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnWorkSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>


</div>


<pre>

<? var_dump($_dossier); ?>
</pre>


<script>
$('#list_direction').change(function(){
  var id = $('#list_direction option:selected').val();

  $.getJSON("/fast_dispatch/ajax/indicators/"+id,
    function(data) {
      $('#list_indicator').empty();

      $.each(data, function(index, item) {
          $('#list_indicator').append($('<option/>', {
                  value: item.id,
                  text : item.name
              }));
      });

      $('#list_indicator').trigger('chosen:updated');

    }
  );
});

$(document).ready(function() {

  $('#edit-depot-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#edit-invoice-data-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#edit-nuisance-data-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#add-email-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#add-nota-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#add-work-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('.close_overlay').click(function(){
    parent.$.fancybox.close();
    return false;
  });


  $('#edit-depot-form form').bind('submit', function() {

    /* /depot/:dossier/:voucher/:token */

    var vid;
    var did;

    var formObj = {};
    var inputs = $(this).serializeArray();
    $.each(inputs, function (i, input) {
      if(input.name == 'vid'){
        vid = parseInt(input.value);
      }else if(input.name == 'did'){
        did = parseInt(input.value);
      }else{
        formObj[input.name] = input.value;
      }
    });

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/updatedepot/" + did + '/' + vid,
      data		: {'depot' : formObj},
      success: function(data) {
        if(data.id) {
          //data was save succesfully
          alert("ok, and close overlay");

        } else {
          //could not save data for whatever reason
          alert("Er is een fout opgetreden bij het bewaren van de gegevens!");
        }
      }
    });




    return false;
  });



});

</script>
