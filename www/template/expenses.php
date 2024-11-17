<?php
global $db;
global $session;
$project_id = $session->get('project_id') ?? null;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
$recordsPerPage = 10;
$currentpage = isset($_POST['page']) ? $_POST['page'] : 1;
$receipt_invoice = isset($_REQUEST['receipt_invoice']) ? ($_REQUEST['receipt_invoice']) : null;

$name_param = !empty($receipt_invoice) ? "&name=$receipt_invoice" : null;
$like = "(receipt_invoice LIKE '%$receipt_invoice%' AND project_id = $project_id)";
if ($userRole == 'Superadmin') {
    $like = "(receipt_invoice LIKE '%$receipt_invoice%')";
    if (!empty($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
        $like = "(receipt_invoice LIKE '%$receipt_invoice%' AND project_id = $project_id)";
    }
}
$currentpage = intval($currentpage);
$db->query("SELECT COUNT(*) as count FROM view_expenses WHERE $like");
$row = $db->single();
$totalRecords = $row['count'];
$offset = ($currentpage - 1) * $recordsPerPage;
$totalPages = ceil($totalRecords / $recordsPerPage);
$limit = 5; // Number of pagination buttons to display

$db->query("SELECT * FROM view_expenses WHERE $like ORDER BY `date` ASC LIMIT $offset, $recordsPerPage");
$data = $db->set();

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
                <th scope="col">Date</th>
                <th scope="col">Category</th>
                <th scope="col">Description</th>
                <th scope="col">Amount</th>
                <th scope="col">Receipt/Invoice No.</th>
                <?php if ($userRole == 'Superadmin'): ?>
                    <th scope="col">Project</th>
                    <th scope="col">Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row):
            ?>
                <tr>
                    <td> <?= ($d = DateTime::createFromFormat('Y-m-d', $row['date'])) ? $d->format('F j, Y') : '-'; ?>
                    </td>
                    <td><?= $row['category_name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= number_format($row['amount'], 2) ?></td>
                    <td><?= $row['receipt_invoice'] ?></td>
                    <?php if ($userRole == 'Superadmin'):
                        $db->query("SELECT * FROM tbl_project WHERE id = ?");
                        $db->bind(1, $row['project_id']);
                        $project = $db->single();
                    ?>
                        <td><?= $project['project_title'] ?></td>
                        <td>
                            <ul class="action">
                                <li class="edit"> <a href="javascript:void(0);" onclick="updateExpenses(<?= $row['id'] ?>);"><i
                                            class="icon-pencil-alt"></i></a>
                                </li>

                                <li class="delete"><a href="javascript:void(0);" onclick="deleteExpenses(<?= $row['id'] ?>);"
                                        data-bs-toggle="modal" data-bs-target="#deleteExpenses"><i class="icon-trash"></i></a>
                                </li>
                            </ul>
                        </td>
                    <?php endif; ?>
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