<?php
global $db;
global $session;
$project_id = $session->get('project_id');
$userId = ($session->get('user_data')['id']);
$recordsPerPage = 10;
$currentpage = isset($_POST['page']) ? $_POST['page'] : 1;
$name = isset($_REQUEST['name']) ? ($_REQUEST['name']) : null;

$name_param = !empty($name) ? "&name=$name" : null;
$like = "(full_name LIKE '%$name%' AND `id` != $userId)";

$currentpage = intval($currentpage);
$db->query("SELECT COUNT(*) as count FROM tbl_user WHERE $like");
$row = $db->single();
$totalRecords = $row['count'];

$offset = ($currentpage - 1) * $recordsPerPage;
$totalPages = ceil($totalRecords / $recordsPerPage);
$limit = 5; // Number of pagination buttons to display
$db->query("SELECT * FROM tbl_user WHERE $like ORDER BY `role` ASC, full_name ASC LIMIT $offset, $recordsPerPage");
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
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
                <th scope="col">Project</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row):
                $db->query("SELECT * FROM tbl_project WHERE id = ?");
                $db->bind(1, $row['project_id']);
                $project = $db->single()['project_title'];
            ?>
                <tr>
                    <td>
                        <?= $row['full_name']; ?>
                    </td>
                    <td>
                        <?= $row['username']; ?>
                    </td>
                    <td>
                        <?= $row['role']; ?>
                    </td>
                    <td>
                        <?= $row['status']; ?>
                    </td>
                    <td>
                        <?= $project; ?>
                    </td>
                    <td>
                        <button class="btn btn-square rounded btn-sm btn-secondary" title="Update User Details" onclick="updateUser(<?= $row['id'] ?>)"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-square rounded btn-sm btn-warning" title="Update User Password" onclick="updateUserPw(<?= $row['id'] ?>)"><i class="fa fa-lock"></i></button>
                        <button class="btn btn-square rounded  btn-sm btn-danger" title="Delete User" data-bs-toggle="modal" data-bs-target="#deleteUser" onclick="deleteUser(<?= $row['id'] ?>)"><i class="fa fa-trash"></i></button>
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