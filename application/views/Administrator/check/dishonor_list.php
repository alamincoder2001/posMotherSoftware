<div class="row">
  <div class="col-xs-12">
    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>Cheque Date</th>
          <th>Cheque No</th>
          <th>Bank Name - Branch Name</th>
          <th>Customer Name</th>
          <th>Reminder Date</th>
          <th>Cheque Amount</th>
        </tr>
      </thead>

      <tbody id="tBody">
        <?php $i = 1;
        if (isset($checks) && $checks) : foreach ($checks as $check) : ?>
            <tr style="<?= ($check->check_status == 'Di') ? 'background-color:#ff000036;' : '' ?>">
              <td>
                <?php
                $date = new DateTime($check->check_date);
                echo date_format($date, 'd M Y');
                ?>
              </td>
              <td><?= $check->check_no; ?></td>
              <td><?= $check->bank_name . '-' . $check->branch_name; ?></td>
              <td><?= $check->Customer_Code . ' - ' . $check->Customer_Name; ?></td>

              <td>
                <?php
                $date = new DateTime($check->remid_date);
                echo date_format($date, 'd M Y');
                ?>
              </td>
              <td><?= number_format($check->check_amount, 2); ?></td>

            </tr>
        <?php endforeach;
        endif; ?>
      </tbody>
    </table>
  </div>
</div>