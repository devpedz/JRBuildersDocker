<?php
global $db;
global $session;
$project_id = $session->get('project_id');
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
$recordsPerPage = 10;
$search = $_POST['search'] ?? null;
$type_id = $_POST['sType'] ?? null;
$availability = $_POST['availability'] ?? null;
$date_acquired = $_POST['sDate'] ?? null;
$like = "((item_no LIKE '%$search%' OR item_name LIKE '%$search%')) AND date_acquired LIKE '%$date_acquired%' AND availability LIKE '%$availability%'";
if (!empty($type_id)) {
    $like .= " AND type_id = $type_id";
}
$db->query("SELECT * FROM tbl_inventory WHERE $like ORDER BY `date_acquired` ASC");
$data = $db->set();

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
        }

        th {
            background-color: #007F7F;
            color: white;
        }

        /* tbody tr:hover {
            background-color: #f1f1f1;
        } */

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

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-3"><img src="../assets/images/logo.png" alt="Company Logo" class="logo" height="150px">
            </div>
            <div class="col-9 text-end">
                <h1>Inventory</h1>
                <p>Printed Date: <?= date('F j, Y') ?></p>

            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col">Item No.</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Date Acquired</th>
                    <th scope="col">Date Borrowed</th>
                    <th scope="col">Availability</th>
                    <th scope="col">Assigned To</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row):
                    $db->query("SELECT * FROM tbl_inventory_types WHERE id = ?");
                    $db->bind(1, $row['type_id']);
                    $type_name = $db->single()['type_name'] ?? '';
                ?>
                    <tr>
                        <td><?= $row['item_no'] ?></td>
                        <td><?= $row['item_name'] ?></td>
                        <td>
                            Unit Cost: ₱<?= number_format($row['unit_cost'], 2) ?><br>
                            Equipment Type: <?= $type_name ?><br>
                            ID/Plate No.: <?= $row['id_plate_no'] ?><br>
                            Description: <?= $row['description'] ?><br>
                        <td><?= date('F j, Y', strtotime($row['date_acquired'])) ?></td>
                        <td><?= $row['date_borrowed'] ? date('F j, Y', strtotime($row['date_borrowed'])) : '' ?></td>
                        <td><?= $row['availability'] ?></td>
                        <td>
                            <?php
                            if (!empty($row['employee_id'])) {
                                $db->query("SELECT * FROM view_employee WHERE id = ?");
                                $db->bind(1, $row['employee_id']);
                                echo $db->single() ? $db->single()['full_name'] : '';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- <div class="row mt-5 mb-0">
            <div class="col-12">
                <div class="col-6 text-center">
                    ______________________________
                </div>

            </div>
            <div class="col-6 text-center">
                <small>Employer's Name and Signature</small>
            </div>
        </div> -->
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