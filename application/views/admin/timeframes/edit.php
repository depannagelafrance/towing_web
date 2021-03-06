<?php echo form_open('admin/timeframe/edit/' . $timeframe_id);?>
<?php
$errors = validation_errors();

if($errors) {
  printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}
?>

<div class="box unpadded dsform admin_form">
    <table>
        <thead>
            <tr>
                <th rowspan="2">Type activiteit</th>
                <th colspan="2"><?php echo $timeframe_data['name']; ?></th>
            </tr>
            <tr>
                <th>excl</th>
                <th>incl</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($activities as $activity){?>
                    <tr>
                        <td>
                            <?php echo $activity->name; ?>
                        </td>
                            <?php foreach($fees as $fee){?>
                                <?php if($fee->timeframe_activity_id == $activity->id){
                                      $excl = array(
                                          'name'        => "fee_excl_vat[]",
                                          'value'       => $fee->fee_excl_vat,
                                          'maxlength'   => '30',
                                          'size'        => '40',
                                          'style'       => 'width: 30%; text-align: right;',
                                    );

                                    $incl = array(
                                            'name'        => "fee_incl_vat[]",
                                            'value'       => $fee->fee_incl_vat,
                                            'maxlength'   => '30',
                                            'size'        => '40',
                                            'style'       => 'width: 30%; text-align: right;',
                                    );
                                ?>
                        <td align="center">
                                <?php
                                  print form_hidden("timeframe_activity_id[]", $fee->timeframe_activity_id);
                                  print form_input($excl);
                                ?>
                        </td>
                        <td align="center">
                                <?php print form_input($incl); ?>
                        </td>
                             <?php    }
                            }?>
                <?php }
            ?>


        </tbody>
    </table>
    <?php print form_hidden('timeframe_id', $timeframe_data['id']);?>
      <div class="form__actions">
          <div class="form__actions__cancel">
              <div class="form-item-horizontal">
                  <a href="/admin/timeframe">Annuleren</a>
              </div>
          </div>
          <div class="form__actions__save">
              <div class="form-item-horizontal">
                  <input type="submit" value="Bewaren" name="submit">
              </div>
          </div>
      </div>

  </div>
</div>
<?php echo form_close();?>
