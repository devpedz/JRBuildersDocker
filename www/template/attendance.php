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
$name = isset($_REQUEST['name']) ? ($_REQUEST['name']) : null;

$name_param = !empty($name) ? "&name=$name" : null;
$like = "(full_name LIKE '%$name%' AND project_id = $project_id)";
if ($userRole == 'Superadmin') {
    $like = "full_name LIKE '%$name%'";
}
$currentpage = intval($currentpage);

$db->query("SELECT COUNT(*) as count FROM view_attendance WHERE $like");
$row = $db->single();
$totalRecords = $row['count'];


// Step 4: Calculate necessary variables
$offset = ($currentpage - 1) * $recordsPerPage;
$totalPages = ceil($totalRecords / $recordsPerPage);
$limit = 5; // Number of pagination buttons to display

// Step 5: Retrieve the paginated data
$db->query("SELECT * FROM view_attendance WHERE $like ORDER BY `date` DESC, timeIn DESC, full_name ASC LIMIT $offset, $recordsPerPage");
$data = $db->set();

// Step 7: Create the pagination links
$startPage = max(1, $currentpage - floor($limit / 2));
$endPage = min($startPage + $limit - 1, $totalPages);

?>
<?php if (!empty($name)): ?>
    <p class="h5"><strong><?= number_format($totalRecords) ?></strong> results for <strong><?= $name ?></strong></p>
    <hr>
<?php endif; ?>
<style>
    div .action i {
        font-size: 25px !important;
    }

    div .action .edit i {
        color: var(--bs-primary) !important;
    }

    div .action .fingerprint_registered i {
        margin-right: 5px;
        color: var(--bs-success) !important;
    }

    div .action .fingerprint_not_registered i {
        margin-right: 5px;

        color: var(--bs-danger) !important;
    }
</style>
<div class="table-responsive theme-scrollbar">
    <table class="table table-striped">
        <thead class="tbl-strip-thad-bdr">
            <tr class="bg-dark" style="color:white !important">
                <th scope="col">Date</th>
                <th scope="col">Employee ID</th>
                <th scope="col">Name</th>
                <th scope="col">Time In</th>
                <th scope="col">Time Out</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row):
            ?>
                <tr>
                    <td> <?= ($d = DateTime::createFromFormat('Y-m-d', $row['date'])) ? $d->format('F j, Y') : '-'; ?>
                    </td>
                    <th scope="row"><?= sprintf('%04d', $row['employee_id']) ?></th>
                    <td> <img class="img-30 me-2" src="uploads/<?= $row['photo'] ?>" alt="&nbsp;"><?= $row['full_name'] ?>
                    </td>
                    <td>
                        <?= ($row['timeIn'] && $d = DateTime::createFromFormat('H:i:s', $row['timeIn'])) ? $d->format('h:i A') : '-'; ?>
                    </td>
                    <td>
                        <?= ($row['timeOut'] && $d = DateTime::createFromFormat('H:i:s', $row['timeOut'])) ? $d->format('h:i A') : '-'; ?>

                    </td>
                    <td>
                        <ul class="action">
                            <li class="edit"> <a href="javascript:void(0);" onclick="updateAttendance(<?= $row['id'] ?>)"><i
                                        class="icon-pencil-alt"></i>
                                </a>
                            </li>
                            <?php if ($userRole == 'Superadmin'): ?>
                                <li class="delete"><a href="javascript:void(0);" onclick="deleteAttendance(<?= $row['id'] ?>)"
                                        data-bs-toggle="modal" data-bs-target="#deleteAttendance"><i class="icon-trash"></i></a>
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
            <ul class="pagination pagination-primary pagin-border-primary">
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