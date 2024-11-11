<?php
global $db;
global $session;
$userRole = ($session->get('user_data')['role']);
$project_id = ($userRole == 'Superadmin' ? $_POST['project_id'] : $session->get('project_id'));
$dateString = $_POST['full_date'];
$payroll_date = new DateTime($dateString);
$date = new DateTime($dateString);
$endDate = $date->format('Y-m-d');
$date->modify('-6 days');
$startDate = $date->format('Y-m-d');
$db->query("SELECT DISTINCT(employee_id) FROM view_attendance WHERE `DATE` >= '$startDate' AND `DATE` <= '$endDate' AND project_id = $project_id");
$employee_ids = $db->set();
$employee_ids = array_column($employee_ids, 'employee_id');
$employee_id_list = implode(', ', $employee_ids);
$like = "(id IN ($employee_id_list) AND project_id = $project_id)";
$db->query("SELECT * FROM view_employee WHERE $like ORDER BY full_name ASC");
$data = $db->set(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <link rel="stylesheet" href="/assets/css/payslip.css">
</head>

<body>
    <?php
    $firstDayOfMonth = new DateTime($payroll_date->format('Y-m-01'));
    $weekNumber = ceil(($payroll_date->format('j') + $firstDayOfMonth->format('N') - 1) / 7);
    ?>
    <?php
    $total_net_pay = 0;
    foreach ($data as $row):
        $db->query("SELECT count(*) as total FROM view_attendance WHERE `DATE` >= '$startDate' AND `DATE` <= '$endDate' AND employee_id = ?");
        $db->bind(1, $row['id']);
        $days_worked = $db->single()['total'];
        $grosspay = $days_worked * $row['rate_per_day'];
        $cash_advance = '';
        $db->query("SELECT * FROM view_payments WHERE employee_id = ? and payment_date = '$endDate'");
        $db->bind(1, $row['id']);
        $view_payments = $db->single();
        if ($view_payments) {
            $cash_advance = $view_payments['payment_amount'];
        }
        $netpay = $grosspay - intval($cash_advance);
        $total_net_pay += $netpay;
        ?>
        <div class="payslip-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="header">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="assets/images/logo.png" style="width:100%; max-width:120px;">
                                </td>
                                <td>
                                    <h2>PAYSLIP</h2>
                                    <p>Date: <?= $date->format('F d, Y'); ?><br><span>Period: Week <?= $weekNumber ?></span>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="employee-details">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <strong>Employee:</strong> <?= $row['full_name'] ?><br>
                                    <strong>Employee ID:</strong> <?= sprintf('%04d', $row['id']) ?><br>
                                    <strong>Position:</strong> <?= $row['position'] ?>
                                </td>
                                <td>
                                    <strong>Working Days:</strong> <?= $days_worked ?><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="heading">
                    <td>Earnings</td>
                    <td>Amount</td>
                </tr>

                <tr class="item">
                    <td>Gross Pay</td>
                    <td><?= number_format($grosspay, 2) ?></td>
                </tr>
                <tr class="heading">
                    <td>Deductions</td>
                    <td>Amount</td>
                </tr>
                <tr class="item">
                    <td>Cash Advance</td>
                    <td><?= number_format(intval($cash_advance), 2) ?></td>
                </tr>
                <tr class="total">
                    <td></td>
                    <td>
                        Net Pay(₱): <?= number_format($netpay, 2) ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>

</body>
<script>
    window.print();
    window.onafterprint = function () {
        history.back()
    }
</script>

</html>