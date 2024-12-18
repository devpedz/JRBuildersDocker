<?php
global $db;
global $session;
$userRole = ($session->get('user_data')['role']);
$formData = $_POST['form'];
parse_str($formData, $form);
if ($userRole == 'Superadmin') {
    $project_id = $form['project_id'];
} else {
    $project_id = $session->get('project_id');
}
$dateString = $form['full_date'];
$date = new DateTime($dateString);
$endDate = $date->format('Y-m-d');
$date->modify('-6 days');
$startDate = $date->format('Y-m-d');
$db->query("SELECT DISTINCT(employee_id) FROM view_attendance WHERE `DATE` >= '$startDate' AND `DATE` <= '$endDate' AND project_id = $project_id");
$employee_ids = $db->set();
$employee_ids = array_column($employee_ids, 'employee_id');
$employee_id_list = implode(', ', $employee_ids);
$recordsPerPage = 10;
if ($employee_ids) {
    $currentpage = isset($_POST['page']) ? $_POST['page'] : 1;
    $name = isset($_REQUEST['name']) ? ($_REQUEST['name']) : null;

    $name_param = !empty($name) ? "&name=$name" : null;

    $currentpage = intval($currentpage);
    $like = "(id IN ($employee_id_list) AND project_id = $project_id)";

    $db->query("SELECT COUNT(*) as count FROM view_employee WHERE $like");
    $row = $db->single();
    $totalRecords = $row['count'];
    $offset = ($currentpage - 1) * $recordsPerPage;
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $limit = 0; // Number of pagination buttons to display
    $db->query("SELECT * FROM view_employee WHERE $like ORDER BY full_name ASC");
    $data = $db->set();
    $startPage = max(1, $currentpage - floor($limit / 2));
    $endPage = min($startPage + $limit - 1, $totalPages);
} else {
    $data = [];
}
?>

<div class="table-responsive theme-scrollbar">
    <table class="table table-striped">
        <thead class="tbl-strip-thad-bdr">
            <tr class="bg-dark" style="color:white !important">
                <th scope="col">Name</th>
                <th scope="col">ID</th>
                <th scope="col">Days Worked</th>
                <th scope="col">Daily Rate</th>
                <th scope="col">Gross Pay</th>
                <th scope="col">Cash Advance</th>
                <th scope="col">Net Pay</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!$data) {
                echo "<script>$('#btnPayroll').attr('disabled',true);</script>";
                echo "<script>$('#btnPayslip').attr('disabled',true);</script>";
                echo "<tr><td colspan='7' class='text-center'><h4>No records found.</h4></td></tr>";
            } else {
                echo "<script>$('#btnPayroll').attr('disabled',false);</script>";
                echo "<script>$('#btnPayslip').attr('disabled',false);</script>";
            }
            foreach ($data as $row):
                $db->query("SELECT * FROM view_attendance WHERE `DATE` >= '$startDate' AND `DATE` <= '$endDate' AND employee_id = ?");
                $db->bind(1, $row['id']);
                $days_worked = 0;
                foreach ($db->set() as $attendance) {
                    $days_worked++;
                    $timeIn = !empty($attendance['timeIn']) ? DateTime::createFromFormat('H:i:s', $attendance['timeIn']) : null;
                    $timeOut = !empty($attendance['timeOut']) ? DateTime::createFromFormat('H:i:s', $attendance['timeOut']) : null;
                    if ($timeIn && $timeOut) {
                        $interval = $timeIn->diff($timeOut);
                        $working_hours = $interval->h + ($interval->days * 24);
                        $working_hoursDecimalHours = $interval->h + $interval->i / 60 + ($interval->days * 24);
                    } else {
                        $working_hours = 0;
                    }
                }
                if ($working_hours > 8) {
                    $grosspay = $days_worked * $row['rate_per_day'];
                } else {
                    $grosspay = $days_worked * ($row['rate_per_day'] / 2);
                }
                $today = date('Y-m-d');

                $db->query("SELECT * FROM tbl_cash_advance WHERE employee_id = ? AND balance > 0 AND `date` <= '$endDate'");
                $db->bind(1, $row['id']);
                $ca_row = $db->single(); //Cash Advance Row
                if ($ca_row) {
                    $db->query("SELECT * FROM tbl_cash_advance_payments WHERE cash_advance_id = ? and payment_date = '$endDate'");
                    $db->bind(1, $ca_row['id']);
                    if ($db->single()) { //Check if exist
                        //Update cash advance
                        $db->query("SELECT SUM(payment_amount) as payments FROM tbl_cash_advance_payments WHERE cash_advance_id = ?");
                        $db->bind(1, $ca_row['id']);
                        $ca_payments = $db->single()['payments'];
                        $update_balance = $ca_row['amount'] - $ca_payments;
                        $update_status = ($update_balance == 0) ? 'Paid' : 'Unpaid';
                        $db->query("UPDATE tbl_cash_advance SET balance = ?,`status` = ? WHERE id = ?");
                        $db->bind(1, $update_balance);
                        $db->bind(2, $update_status);
                        $db->bind(3, $ca_row['id']);
                        $db->execute();
                    } else {
                        if ($endDate <= $ca_row['payoff_date']) {
                            $db->query("INSERT INTO tbl_cash_advance_payments(cash_advance_id,payment_amount,payment_date) VALUES (?,?,?)");
                            $db->bind(1, $ca_row['id']);
                            $db->bind(2, $ca_row['weekly_deduction']);
                            $db->bind(3, $endDate);
                            $db->execute();
                            //Update cash advance
                            $db->query("SELECT SUM(payment_amount) as payments FROM tbl_cash_advance_payments WHERE cash_advance_id = ?");
                            $db->bind(1, $ca_row['id']);
                            $ca_payments = $db->single()['payments'];
                            $update_balance = $ca_row['amount'] - $ca_payments;
                            $update_status = ($update_balance == 0) ? 'Paid' : 'Unpaid';
                            $db->query("UPDATE tbl_cash_advance SET balance = ?,`status` = ? WHERE id = ?");
                            $db->bind(1, $update_balance);
                            $db->bind(2, $update_status);
                            $db->bind(3, $ca_row['id']);
                            $db->execute();
                        }
                    }
                }
                $cash_advance = '';
                $db->query("SELECT * FROM view_payments WHERE employee_id = ? and payment_date = '$endDate'");
                $db->bind(1, $row['id']);
                $view_payments = $db->single();
                if ($view_payments) {
                    $cash_advance = $view_payments['payment_amount'];
                }
                $netpay = $grosspay - intval($cash_advance);

            ?>
                <tr>
                    <td><?= $row['full_name'] ?></td>
                    <th scope="row"><?= sprintf('%04d', $row['id']) ?></th>
                    <td><?= $days_worked ?></td>
                    <td><?= number_format($row['rate_per_day'], 2) ?></td>
                    <td><?= number_format($grosspay, 2) ?></td>
                    <td class="font-danger"><?= $cash_advance ?></td>
                    <td><?= number_format($netpay, 2) ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>