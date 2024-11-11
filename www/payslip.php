<?php
global $db;
global $session;
$project_id = $session->get('project_id');
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
                                <p>Pay Date: June 30, 2024<br><span>Period: Week 5</span></p>
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
                                <strong>Employee:</strong> John Doe<br>
                                <strong>Employee ID:</strong> 12345<br>
                                <strong>Position:</strong> Senior Accountant
                            </td>
                            <td>
                                <strong>No. of Days:</strong> 6<br>
                                <strong>Rate/Day:</strong> ₱500.00
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
                <td>Basic Salary</td>
                <td>₱3,000.00</td>
            </tr>
            <tr class="heading">
                <td>Deductions</td>
                <td>Amount</td>
            </tr>
            <tr class="item">
                <td>Cash Advance</td>
                <td>₱300.00</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>
                    Net Salary: ₱2,700.00
                </td>
            </tr>
        </table>
    </div>
</body>

</html>