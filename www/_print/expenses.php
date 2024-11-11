<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(0);
global $db;
global $session;
// Given date range
$range_date = $_POST['range-date'];
// Split the range into start and end dates
$dates = array_map('trim', explode(' to ', $range_date));
list($start_date, $end_date) = count($dates) === 2 ? $dates : [$dates[0], $dates[0]];
// list($start_date, $end_date) = explode(' to ', $range_date);

// Optional: Convert to DateTime objects if needed
$start_date = new DateTime($start_date);
$end_date = new DateTime($end_date);
$startDate =  $start_date->format('Y-m-d');
$endDate = $end_date->format('Y-m-d');
function formatDate($start_date, $end_date)
{
    if ($start_date->format('Y-m-d') === $end_date->format('Y-m-d')) {
        return $start_date->format('F j, Y');
    } elseif ($start_date->format('Y') === $end_date->format('Y')) {
        return $start_date->format('F j') . " to " . $end_date->format('F j, Y');
    } else {
        return $start_date->format('F j, Y') . " to " . $end_date->format('F j, Y');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
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

        @media print {
            .page-break {
                page-break-before: always;
                /* Forces a page break before the element */
                /* For better browser support */
                break-before: always;
                /* CSS3 */
                /* Optionally, you can hide the element if not needed in print */
                display: block;
                /* Ensure the element is displayed */
            }
        }
    </style>
</head>

<body>
    <?php
    $db->query("SELECT * FROM tbl_project");
    $projects = $db->set();
    $lastProject = null;
    foreach ($projects as $project):
        $project_id = $project['id'];
        $project_title = $project['project_title'];
        $project_address = $project['project_address'];
        $db->query("SELECT * FROM tbl_expenses WHERE `date` >= '$startDate' AND `date` <= '$endDate' AND project_id = $project_id ORDER BY `date` ASC");
        $data = $db->set();
        if (!$data) {
            break;
        }
    ?>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-3"><img src="../assets/images/logo.png" alt="Company Logo" class="logo" height="150px">
                </div>
                <div class="col-9 text-end">
                    <h1><?= strtoupper($project_title) ?> EXPENSES</h1>
                    <p><?= $project_address ?><br><span>Period: <?= formatDate($start_date, $end_date); ?></span></p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Description</th>
                        <th scope="col">Receipt/Invoice</th>
                        <th scope="col">Category</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_amount = 0;
                    $curdate = '';
                    foreach ($data as $row):
                        $db->query("SELECT category_name FROM tbl_expense_categories WHERE id = ?");
                        $db->bind(1, $row['category_id']);
                        $category_name = $db->single()['category_name'];
                        $total_amount += $row['amount'];
                    ?>
                        <tr>
                            <td><?= ($curdate === $row['date'] ? '' : date('F j, Y', strtotime($row['date']))) ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['receipt_invoice'] ?></td>
                            <td><?= $category_name ?></td>
                            <td><?= number_format($row['amount'], 2) ?></td>

                        </tr>
                    <?php
                        $curdate = $row['date'];
                    endforeach; ?>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total (₱):</strong></td>
                        <td><strong><?= number_format($total_amount, 2) ?></strong></td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
            <div class="row mt-5 mb-0">
                <div class="col-12">
                    <div class="col-6 text-center">
                        ______________________________
                    </div>

                </div>
                <div class="col-6 text-center">
                    <small>Employer's Name and Signature</small>
                </div>
            </div>
        </div>
        <?php if ($project !== end($projects)): ?>
            <div class="page-break"></div>
        <?php endif; ?>

    <?php
    endforeach; ?>
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