<?php
global $db;
global $session;
$project_id = $session->get('project_id');
$userRole = ($session->get('user_data')['role']);
$date = $_POST['year'] . '-' . $_POST['month'];

if ($userRole == 'Superadmin') {
    $project_id = $_POST['project_id'] ?? null;
    $searchProject = (!empty($_POST['project_id']) ? "project_id = $project_id AND " : null);
    $db->query("SELECT * FROM tbl_expenses WHERE $searchProject`date` LIKE '%$date%' ORDER BY `date` ASC");
} else {
    $db->query("SELECT * FROM tbl_expenses WHERE `date` LIKE '%$date%' AND project_id = $project_id ORDER BY `date` ASC");
}
$data = $db->set();
?>

<div class="table-responsive theme-scrollbar">
    <table class="table table-striped">
        <thead class="tbl-strip-thad-bdr">
            <tr class="bg-dark" style="color:white !important">
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Receipt/Invoice</th>
                <th scope="col">Category</th>
                <?= ($userRole == 'Superadmin') ? '<th scope="col">Project</th>' : null ?>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!$data) {
                echo "<script>$('#btnPrint').attr('disabled',true);</script>";
                echo "<tr><td colspan='7' class='text-center'><h4>No records found.</h4></td></tr>";
            } else {
                echo "<script>$('#btnPrint').attr('disabled',false);</script>";
            }
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
                    <?php if ($userRole == 'Superadmin'):
                        $db->query("SELECT * FROM tbl_project WHERE id = ?");
                        $db->bind(1, $row['project_id']);
                        $project_title = $db->single()['project_title']
                    ?>
                        <td><?= $project_title ?></td>
                    <?php endif; ?>
                    <td><?= number_format($row['amount'], 2) ?></td>
                </tr>
            <?php
                $curdate = $row['date'];
            endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="bg-dark" style="color:white !important">
                <th scope="col" colspan="<?= ($userRole == 'Superadmin') ? 5 : 4 ?>">Total</th>
                <th scope="col"><?= number_format($total_amount, 2) ?></th>
            </tr>
        </tfoot>
    </table>
</div>