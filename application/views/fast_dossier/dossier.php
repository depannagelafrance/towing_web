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
