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
$data = $db->set();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll</title>
    <link rel="stylesheet" href="../../assets/css/vendors/bootstrap.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container1 {
            background: white;
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            /* Set the width of the logo */
            height: auto;
            /* Maintain aspect ratio */
            margin-bottom: 10px;
            /* Space below the logo */
        }

        h1 {
            color: #333;
            font-size: 1.5em;
            margin-top: -10px;
            /* Adjust header font size */
        }

        p {
            margin-top: -12px;
        }

        table {
            width: 100%;
            /* Set width to 80% to make the table smaller */
            margin: 0 auto;
            /* Center the table */
            border-collapse: collapse;
            font-size: 0.9em;
            /* Reduce font size for table */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            /* Reduce padding for smaller table */
            text-align: center;
        }

        th {
            background-color: #007F7F;
            color: white;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        footer {
            text-align: center;
        }

        button {
            position: fixed;
            top: 50px;
            right: 50px;
            padding: 8px 16px;
            /* Adjust button padding */
            background-color: #007F7F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005454;
        }

        @media print {
            button {
                display: none;
            }
        }

        .signature-line {
            border-top: 1px solid black;
            width: 100%;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <?php
    $firstDayOfMonth = new DateTime($payroll_date->format('Y-m-01'));
    $weekNumber = ceil(($payroll_date->format('j') + $firstDayOfMonth->format('N') - 1) / 7);
    ?>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-3"><img src="../assets/images/logo.png" alt="Company Logo" class="logo" height="150px">
            </div>
            <div class="col-9 text-end">
                <h1>PAYROLL</h1>
                <p>Pay Date: <?= $payroll_date->format('F d, Y'); ?><br><span>Period: Week
                        <?= $weekNumber ?></span></p>
                <p>Printed Date: <?= date('F j, Y') ?></p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Days Worked</th>
                    <th>Gross Pay</th>
                    <th>Cash Advance</th>
                    <th>Net Pay</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_net_pay = 0;
                foreach ($data as $row):
                    $db->query("SELECT count(*) as total FROM view_attendance WHERE `DATE` >= '$startDate' AND `DATE` <= '$endDate' AND employee_id = ?");
                    $db->bind(1, $row['id']);
                    $days_worked = $db->single()['total'];
                    $today = date('Y-m-d');
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
                    <tr>
                        <td><?= $row['full_name'] ?></td>
                        <td><?= $days_worked ?></td>
                        <td><?= number_format($grosspay, 2) ?></td>
                        <td class="font-danger"><?= number_format(intval($cash_advance), 2) ?></td>
                        <td><?= number_format($netpay, 2) ?></td>

                    </tr>
                <?php endforeach; ?>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Total (₱):</strong></td>
                    <td><strong><?= number_format($total_net_pay, 2) ?></strong></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
        <div class="row mt-5 mb-0">
            <div class="col-6 text-center">
                ______________________________
            </div>
            <div class="col-6 text-center">
                ______________________________
            </div>
        </div>
        <div class="row">
            <div class="col-6 text-center">
                <small>Prepared By:</small>
            </div>
            <div class="col-6 text-center">
                <small>Approved By:</small>
            </div>
        </div>

    </div>
    <script>
        document.getElementById('date').innerText = new Date().toLocaleDateString();
    </script>
</body>
<script>
    window.print();
    window.onafterprint = function() {
        history.back()
    }
</script>

</html>