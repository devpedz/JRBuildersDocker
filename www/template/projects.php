<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(0);
global $db;
global $session;
$project_id = $session->get('project_id');
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
// $towns = !empty($user['town']) ? $user['town'] : 'SAN ANTONIO,SAN NARCISO,SAN FELIPE,CABANGAN,BOTOLAN,IBA,PALAUIG,MASINLOC,CANDELARIA,SANTA CRUZ';
// error_reporting(0);
// Step 1: Connect to the database

// Using PDO
// Step 3: Set the number of records per page and current page
$recordsPerPage = 10;
// echo $_POST['page'];

if (empty($_POST)) {
    // exit();
}
$currentpage = isset($_POST['page']) ? $_POST['page'] : 1;
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : null;

// $name_param = !empty($search) ? "&name=$search" : null;
$like = "((item_no LIKE '%$search%' OR item_name LIKE '%$search%') AND project_id = $project_id)";
if ($userRole == 'Superadmin') {
    $like = "((item_no LIKE '%$search%' OR item_name LIKE '%$search%'))";
}
$currentpage = intval($currentpage);
// Step 2: Retrieve the total number of records
// if (!empty($name)) {
//     $like = "(full_name LIKE '%$name%')";
// }

$db->query("SELECT COUNT(*) as count FROM tbl_inventory WHERE $like");
$row = $db->single();
$totalRecords = $row['count'];


// Step 4: Calculate necessary variables
$offset = ($currentpage - 1) * $recordsPerPage;
$totalPages = ceil($totalRecords / $recordsPerPage);
$limit = 5; // Number of pagination buttons to display

// Step 5: Retrieve the paginated data
$db->query("SELECT * FROM tbl_inventory WHERE $like ORDER BY `date_acquired` ASC LIMIT $offset, $recordsPerPage");
$data = $db->set();

// Step 7: Create the pagination links
$startPage = max(1, $currentpage - floor($limit / 2));
$endPage = min($startPage + $limit - 1, $totalPages);

?>
<?php if (!empty($name)): ?>
    <p class="h5"><strong><?= number_format($totalRecords) ?></strong> results for <strong><?= $name ?></strong></p>
    <hr>
<?php endif; ?>
<div class="table-responsive theme-scrollbar">
    <table class="table table-striped">
        <thead class="tbl-strip-thad-bdr">
            <tr class="bg-dark" style="color:white !important">
                <th scope="col">Item No.</th>
                <th scope="col">Item Name</th>
                <th scope="col">Details</th>
                <th scope="col">Date Acquired</th>
                <th scope="col">Date Borrowed</th>
                <th scope="col">Availability</th>
                <th scope="col">Assigned To</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row):
            ?>
                <tr>
                    <td><?= $row['item_no'] ?></td>
                    <td><?= $row['item_name'] ?></td>
                    <td>
                        Unit Cost: <?= number_format($row['unit_cost'], 2) ?><br>
                        Equipment Type: <?= $row['equipment_type'] ?><br>
                        ID/Plate No.: <?= $row['id_plate_no'] ?><br>
                        Description: <?= $row['description'] ?><br>
                        Condition: <?= $row['condition'] ?>
                    <td><?= $row['date_acquired'] ?></td>
                    <td><?= $row['date_borrowed'] ?></td>
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
                    <td>
                        <ul class="action">
                            <li class="edit"> <a href="javascript:void(0);"
                                    onclick="updateInventory(<?= $row['item_no'] ?>);"><i class="icon-pencil-alt"></i></a>
                            </li>
                            <?php if ($userRole == 'Superadmin'): ?>
                                <li class="delete"><a href="javascript:void(0);"
                                        onclick="deleteInventory(<?= $row['item_no'] ?>);" data-bs-toggle="modal"
                                        data-bs-target="#deleteInventory"><i class="icon-trash"></i></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <div class="col-sm-12 col-md-5">
        <span class="mr-2">Showing <?php echo number_format($offset + 1); ?> to
            <?php echo number_format(min($offset + $recordsPerPage, $totalRecords)); ?> of
            <?php echo number_format($totalRecords); ?> entries</span>

    </div>
    <div class="col-sm-12 col-md-7">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-   primary pagin-border-primary">
                <?php if ($currentpage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="javascript:setPage(1);">First</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:setPage(<?= $currentpage - 1; ?>)">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                    <li class="page-item<?php if ($page == $currentpage)
                                            echo ' active'; ?>">
                        <a class="page-link" href="javascript:setPage(<?= $page ?>)"><?php echo $page; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentpage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="javascript:setPage(<?= $currentpage + 1 ?>);">Next</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:setPage(<?= $totalPages ?>);">Last</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>