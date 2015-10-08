<?php
function displayVoucherTimeField($value, $name)
{
    if ($value)
    {
        $render = sprintf('<div class="input_value">%s</div>', asTime($value));
        $render .= form_hidden($name, asJsonDateTime($value));

        return $render;
    }
    else
    {
        return form_input($name, asTime($value));
    }
}


$this->load->helper('listbox');
$this->load->helper('datetime');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>
<div class="layout-has-sidebar edit-view">
    <div class="layout-sidebar">
        <div class="box table_list table_list_small">

            <?php
            $this->load->helper('date');

            print showDossierList($this, $search_results, 'Zoekresultaten');
            if (count($search_results) > 0) {
                echo '<div style="padding-top: 15px; padding-bottom: 15px;background-color: #f0f0f0">';
                echo '<input type="button" value="Wis zoekresultaten" id="btn_delete_search_results">';
                echo '</div>';
            }

            print showDossierList($this, $vouchers, 'Dossiers');

            ?>
        </div>
    </div>

    <?php
    print validation_errors();

    $_voucher = null;

    foreach ($_dossier->towing_vouchers as $_v) {
        if ($_v->voucher_number === $voucher_number) {
            $_voucher = $_v;
        }
    }

    if (!$_voucher) {
        $_voucher = $_dossier->towing_vouchers[0];
    }


    print form_open('fast_dossier/dossier/save/' . $_dossier->dossier_number . '/' . $_voucher->voucher_number);


    // -- dossier_id
    $data = array(
        'name' => 'data_dossier_id',
        'id' => 'data_dossier_id',
        'type' => 'hidden',
        'value' => $_dossier->id);

    print form_input($data);

    // -- voucher_id
    $data = array(
        'name' => 'data_voucher_id',
        'type' => 'hidden',
        'id' => 'data_voucher_id',
        'value' => $_voucher->id);

    print form_input($data);
    ?>


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
                    <?php print mdate('%d/%m/%Y', strtotime($_dossier->call_date)); ?>
                </div>
            </div>

            <div class="idbar__item">
                <div class="idbar__label">
                    <div class="icon--clock"></div>
                </div>
                <div class="idbar__value">
                    <?php print asTime($_dossier->call_date); ?>
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
                    <?php print form_input('call_number', $_dossier->call_number); ?>
                </div>

                <div class="form-item-horizontal less_padded">
                    <label>Perceel&nbsp;:</label>

                    <div class="value"><?php print $_dossier->allotment_name; ?></div>
                </div>

                <div class="form-item-horizontal less_padded">
                    <label>Toegewezen aan&nbsp;:</label>

                    <div class="value"><?php print $_dossier->company_name; ?></div>
                </div>
            </div>

            <div class="detailbar__row" style="padding-left: 15px;">

                <div class="form-item-horizontal less_padded">
                    <label>Richting&nbsp;:</label>
                    <?php print listbox_ajax('allotment_direction_id', $_dossier->allotment_direction_id); ?>
                </div>

                <div class="form-item-horizontal less_padded">
                    <label>KM Paal&nbsp;:</label>
                    <?php print listbox_ajax('allotment_direction_indicator_id', $_dossier->allotment_direction_indicator_id); ?>
                </div>

                <div class="form-item-horizontal less_padded">
                    <label>Gemeente&nbsp;:</label>

                    <div class="value">
                        <?php
                        if ($_dossier->indicator_zip) {
                            printf("%s - %s", $_dossier->indicator_zip, $_dossier->indicator_city);
                        }
                        ?>
                    </div>
                </div>

                <div class="form-item-horizontal less_padded">
                    <label>Rijstrook&nbsp;:</label>

                    <div class="value"><?php print $_dossier->traffic_lane_name; ?></div>
                </div>
            </div>

        </div>

        <div class="dossierbar">

            <div class="dossierbar__vouchers">
                <select name="voucher_switcher" id="voucher_switcher"
                        data-did="<?php print $_dossier->dossier_number; ?>">
                    <?php
                    foreach ($_dossier->towing_vouchers as $_v) {
                        $_is_selected = ($_v->voucher_number == $_voucher->voucher_number);

                        $sel = '';

                        if ($_is_selected || count($_dossier->towing_vouchers) == 1) {
                            $sel = 'selected';
                        }
                        print '<option value="' . $_v->voucher_number . '"' . $sel . '>' . sprintf("%s (%s)", $_v->voucher_number, $_v->status) . '</option>';
                    };
                    ?>
                </select>
            </div>

            <div class="dossierbar__mainactions">
                <div class="dossierbar__mainaction__item">
                    <div class="btn--icon--highlighted bright">
                        <a class="icon--add" href="/fast_dossier/dossier/voucher/<?php print $_dossier->id; ?>"
                           onclick="return confirm('Bent u zeker dat u een nieuwe takelbon wenst aan te maken?');">Add</a>
                    </div>
                </div>
            </div>

            <div class="dossierbar__actions">
                <?php
                if ($_voucher->status == 'READY FOR INVOICE') {
                    print generateInvoiceDropdownButton();
                }

                print generateEmailDropdownButton();
                print generateNoteDropdownButton();
                print generateAttachmentDropdownButton();
                print generateVoucherReportDropdownButton($_dossier->id, $_voucher->id);
                ?>
            </div>
        </div>

        <?php
        print generateValidationMessagesBlock($_voucher->status);
        ?>

        <div class="box unpadded dsform">
            <div class="inner_padding">

                <!--SIGNA-->
                <div class="signa-container">
                    <div class="signa-container__left">
                        <div class="form-item-horizontal signa-container__signa" style="width: 100%;">
                            <label>Signa:</label>
                            <?php /* print form_input('signa_by', $_voucher->signa_by);*/ ?>
                            <?php print listbox_ajax('signa_id', $_voucher->signa_id); ?>


                            <?php
                            $data = array(
                                'name' => 'signa_by_vehicle',
                                'type' => 'hidden',
                                'value' => $_voucher->signa_by_vehicle);

                            print form_input($data);
                            ?>
                        </div>
                    </div>

                    <div class="signa-container__right">
                        <div class="form-item-horizontal signa-container__arrival">
                            <label>Aankomst:</label>

                            <?php print displayVoucherTimeField($_voucher->signa_arrival, 'signa_arrival'); ?>
                        </div>

                        <div class="form-item-horizontal signa-container__arrival">
                            <label>Afmelding CIC:</label>

                            <?php print displayVoucherTimeField($_voucher->cic, 'cic'); ?>
                        </div>
                    </div>
                </div>
                <!-- END SIGNA -->

                <!--TOWED BY-->
                <div class="towedby-container">
                    <div class="towedby-container__left">
                        <div class="form-item-horizontal towedby-container__towedby">
                            <label>Takelaar:</label>
                            <?php /* print form_input('towed_by', $_voucher->towed_by);*/ ?>
                            <?php print listbox_ajax('towing_id', $_voucher->towing_id); ?>
                        </div>

                        <div class="form-item-horizontal towedby-container__licenceplate">
                            <label>Voertuig:</label>
                            <?php
                            // $data = array(
                            //   'name'        => 'towed_by_vehicle',
                            //   'value'       => $_voucher->towed_by_vehicle,
                            //   'readonly'    => 'readonly',
                            //   'style'       => 'background: #F0F0F0'
                            // );
                            //
                            // print form_hidden($data);

                            print listbox_ajax('towing_vehicle_id', $_voucher->towing_vehicle_id);
                            ?>
                        </div>
                    </div>

                    <div class="towedby-container__right">
                        <div class="form-item-horizontal towedby-container__call">
                            <label>Oproep:</label>
                            <?php print displayVoucherTimeField($_voucher->towing_called, 'towing_called'); ?>
                        </div>

                        <div class="form-item-horizontal towedby-container__arival">
                            <label>Aankomst:</label>
                            <?php print displayVoucherTimeField($_voucher->towing_arrival, 'towing_arrival'); ?>
                        </div>

                        <div class="form-item-horizontal towedby-container__start">
                            <label>Start:</label>
                            <?php print displayVoucherTimeField($_voucher->towing_start, 'towing_start'); ?>
                        </div>

                        <div class="form-item-horizontal towedby-container__completed">
                            <label>Stop:</label>
                            <?php print displayVoucherTimeField($_voucher->towing_completed, 'towing_completed'); ?>
                        </div>

                    </div>
                </div>
                <!-- END TOWEDBY -->

                <!-- VEHICULE -->
                <div class="vehicule-container">
                    <div class="vehicule-container__left">
                        <div class="form-item-horizontal vehicule-container__vehicule">
                            <label>Voertuig:</label>
                            <?php print form_input('vehicule', $_voucher->vehicule); ?>
                        </div>

                        <div class="form-item-horizontal vehicule-container__license">
                            <label>Kleur:</label>
                            <?php print form_input('vehicule_color', $_voucher->vehicule_color); ?>
                        </div>
                    </div>

                    <div class="vehicule-container__right">
                        <div class="form-item-horizontal vehicule-container__keypresent">
                            <label>Sleutels aanwezig?</label>
                            <?php print form_checkbox('vehicule_keys_present', 1, ($_voucher->vehicule_keys_present == 1)); ?>
                        </div>

                        <div class="form-item-horizontal vehicule-container__country">
                            <label>Land:</label>
                            <?php print listbox_ajax('licence_plate_country', $_voucher->vehicule_country); ?>
                        </div>
                    </div>

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


                </div>
                <!-- END CAR -->

<?php
function tofloat($num)
{
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
    );
}

function showDossierList($ctx, $data, $title)
{
    if (count($data) > 0) {
        $last = $ctx->uri->total_segments();
        $url_dossier_id = $ctx->uri->segment($last - 1);
        //$url_takelbon_id = $ctx->uri->segment($last);

        $ctx->table->set_heading($title);

        //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
        //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`
        //$prev = '';
        $vouchers = $data;

        if ($vouchers && count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {
                $class = 'inactive';

                if ($voucher->dossier_number === $url_dossier_id) {
                    $class = 'active bright';
                }

                // if($prev !== $voucher->dossier_number){

                // $prev = $voucher->dossier_number;

                $ctx->table->add_row(
                    array('class' => $class,
                        'data' => sprintf('<a class="id__cell" href="/fast_dossier/dossier/%s/%s">
                                            <span class="id__cell__icon icon--map"></span>
                                            <span class="id__cell__text__type">%s</span>
                                            <span class="id__cell__text">
                                              <span class="id__cell__text__data">
                                                <span class="id__cell__text__info">Oproepnummer: %s</span>
                                                <span class="id__cell__text__nr">%s</span>
                                                <span class="id__cell__text__info">%s %s</span>
                                              </span>
                                            </span></a>', $voucher->dossier_number, $voucher->voucher_number,
                            $voucher->voucher_number, $voucher->call_number, $voucher->incident_type,
                            $voucher->direction_name, $voucher->indicator_name))
                );

                // }
            }
        }

        return $ctx->table->generate();
    }

    return '';
}

function generateInvoiceDropdownButton() {
    return '<div class="dossierbar__action__item">
                        <!-- <input type="button" value="Factuur aanmaken" id="create-invoice-button" /> -->
                        <div class="btn--dropdown">
                            <div class="btn--dropdown--btn btn--icon">
                                <span class="icon--invoice">Facturatie</span>
                            </div>
                            <ul class="btn--dropdown--drop">
                                <li><a id="generate-invoice-link" href="#generate-invoice-form">Factuur aanmaken</a>
                                </li>
                            </ul>
                        </div>
                    </div>';
}

function generateEmailDropdownButton() {
    return '<div class="dossierbar__action__item">
                    <div class="btn--dropdown">
                        <div class="btn--dropdown--btn btn--icon">
                            <span class="icon--email">Email</span>
                        </div>
                        <ul class="btn--dropdown--drop">
                            <li><a id="add-email-link" href="#add-email-form">Email verzenden</a></li>
                            <li><a id="view-email-link" href="#view-email-container">Emails bekijken</a></li>
                            <li><a id="send-voucher-email-awv-link" href="#send-voucher-email-awv-container">Takelbon
                                    verzenden naar AW&amp;V</a></li>
                        </ul>
                    </div>
                </div>';
}

function generateNoteDropdownButton() {
    return '<div class="dossierbar__action__item">
                    <div class="btn--dropdown">
                        <div class="btn--dropdown--btn btn--icon">
                            <span class="icon--nota">Nota</span>
                        </div>
                        <ul class="btn--dropdown--drop">
                            <li><a id="add-nota-link" href="#add-nota-form">Nota toevoegen</a></li>
                            <li><a id="view-nota-link" href="#view-nota-container">Notas bekijken</a></li>
                        </ul>
                    </div>
                </div>';
}

function generateAttachmentDropdownButton() {
    return '<div class="dossierbar__action__item">
                    <div class="btn--dropdown">
                        <div class="btn--dropdown--btn btn--icon">
                            <span class="icon--attachement">Bijlage</span>
                        </div>
                        <ul class="btn--dropdown--drop">
                            <li><a id="add-attachment-link" href="#add-attachment-form">Bijlage Toevoegen</a></li>
                            <li><a id="view-attachment-link" href="#view-attachment-container">Bijlages bekijken</a>
                            </li>
                        </ul>
                    </div>
                </div>';
}

function generateVoucherReportDropdownButton($dossier_id, $voucher_id)
{
    return sprintf('<div class="dossierbar__action__item">
                    <div class="btn--dropdown">
                        <div class="btn--dropdown--btn btn--icon">
                            <span class="icon--print">Print</span>
                        </div>
                        <ul class="btn--dropdown--drop">
                            <li>
                                <a href="/fast_dossier/report/voucher/towing/%s/%s">Exemplaar
                                    Takeldienst</a></li>
                            <li>
                                <a href="/fast_dossier/report/voucher/collector/%s/%s">Exemplaar
                                    Afhaler</a></li>
                            <li>
                                <a href="/fast_dossier/report/voucher/customer/%s/%s">Exemplaar
                                    Klant</a></li>
                            <li>
                                <a href="/fast_dossier/report/voucher/other/%s/%s">Exemplaar
                                    op Aanvraag</a></li>
                        </ul>
                    </div>
                </div>',
        $dossier_id, $voucher_id,
        $dossier_id, $voucher_id,
        $dossier_id, $voucher_id,
        $dossier_id, $voucher_id);
}

function generateValidationMessagesBlock($status) {
    if ($status === 'TO CHECK' || $status == 'READY FOR INVOICE') {
        return '<div class="unpadded" style="background-color: #feec8a; padding-left: 15px; padding-right: 15px; padding-top: 15px; padding-bottom: 15px; margin-bottom: 15px; color: #7f2710;" id="validation_messages"></div>';
    }

    return '';
}
?>
