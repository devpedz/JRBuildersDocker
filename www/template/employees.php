<?php
global $db;
global $session;
$project_id = $session->get('project_id');
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
$recordsPerPage = 10;
$currentpage = isset($_POST['page']) ? $_POST['page'] : 1;
$name = isset($_REQUEST['name']) ? ($_REQUEST['name']) : null;

$name_param = !empty($name) ? "&name=$name" : null;
$like = "(full_name LIKE '%$name%' AND project_id = $project_id)";
if ($userRole == 'Superadmin') {
    $like = "(full_name LIKE '%$name%')";
}
$currentpage = intval($currentpage);

$db->query("SELECT COUNT(*) as count FROM view_employee WHERE $like");
$row = $db->single();
$totalRecords = $row['count'];
$offset = ($currentpage - 1) * $recordsPerPage;
$totalPages = ceil($totalRecords / $recordsPerPage);
$limit = 5; // Number of pagination buttons to display
$db->query("SELECT * FROM view_employee WHERE $like LIMIT $offset, $recordsPerPage");
$data = $db->set();
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
                <th scope="col">Employee ID</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Position</th>
                <th scope="col">Rate/Day</th>
                <th scope="col">Member Since</th>
                <th scope="col">Status</th>
                <?php if ($userRole == 'Superadmin'): ?>
                    <th>Project</th>
                <?php endif; ?>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row):
            ?>
                <tr>
                    <th scope="row"><?= sprintf('%04d', $row['id']) ?></th>
                    <td> <img class="img-30 me-2" src="uploads/<?= $row['photo'] ?>" alt="&nbsp;"><?= $row['full_name'] ?>
                    </td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['position'] ?></td>
                    <td><?= $row['rate_per_day'] ?></td>
                    <td><?= isset($row['member_since']) && $row['member_since'] ? DateTime::createFromFormat('Y-m-d', $row['member_since'])->format('F j, Y') : '-'; ?></td>
                    <td> <span
                            class="badge badge-<?= $row['status'] == 'ACTIVE' ? 'success' : 'danger' ?>"><?= $row['status'] ?></span>
                    </td>
                    <?php if ($userRole == 'Superadmin'):
                        $db->query("SELECT * FROM tbl_project WHERE id = ?");
                        $db->bind(1, $row['project_id']);
                        $project_title = $db->single()['project_title'] ?? '-';
                    ?>
                        <td><?= $project_title ?></td>
                    <?php endif; ?>
                    <td>
                        <ul class="action">
                            <?php if (!empty($row['indexfinger']) || !empty($row['middlefinger'])): ?>
                                <li class="fingerprint_registered">
                                    <a href="javascript:re_enroll(<?= $row['id'] ?>)"><i
                                            class=" icofont icofont-finger-print"></i></a>
                                </li>
                            <?php else: ?>
                                <li class="fingerprint_not_registered">
                                    <a href="/fingerprint-registration/<?= $row['id'] ?>"><i
                                            class="icofont icofont-finger-print"></i></a>
                                </li>
                            <?php endif; ?>

                            <li class="edit"> <a href="update-employee/<?= $row['id'] ?>"><i
                                        class="icon-pencil-alt"></i></a>
                            </li>
                            <?php if ($userRole == 'Superadmin'): ?>
                                <li class="delete"><a href="javascript:void(0);" onclick="deleteEmployee(<?= $row['id'] ?>);"
                                        data-bs-toggle="modal" data-bs-target="#deleteEmployee"><i class="icon-trash"></i></a>
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