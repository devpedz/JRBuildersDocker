<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
if ($userRole == 'Superadmin') {
    $db->query("SELECT DISTINCT employee_id FROM tbl_attendance WHERE `date` = ?");
    $db->bind(1, date('Y-m-d'));
    $present = count($db->set());
    $db->query("SELECT DISTINCT id FROM tbl_employee WHERE `status` = 'ACTIVE'");
    $total_employee = count($db->set());
    $absent = $total_employee - $present;
    $db->query("SELECT SUM(amount) AS total_amount FROM tbl_expenses WHERE DATE_FORMAT(date, '%Y-%m') = ?;");
    $db->bind(1, date('Y-m'));
    $totalExpenses = $db->single()['total_amount'];
    $db->query("SELECT * FROM view_attendance ORDER BY `date` DESC,`timeIn` DESC, full_name ASC LIMIT 5");
    $attendance = $db->set();
} else {
    $project_id = $session->get('project_id');
    $db->query("SELECT * FROM view_attendance WHERE project_id = $project_id ORDER BY `date` DESC,`timeIn` DESC, full_name ASC LIMIT 5");
    $attendance = $db->set();
    $db->query("SELECT DISTINCT employee_id FROM tbl_attendance WHERE `date` = ? AND project_id = $project_id");
    $db->bind(1, date('Y-m-d'));
    $present = count($db->set());
    $db->query("SELECT DISTINCT id FROM tbl_employee WHERE `status` = 'ACTIVE' AND project_id = $project_id");
    $total_employee = count($db->set());
    $absent = $total_employee - $present;
    $db->query("SELECT SUM(amount) AS total_amount FROM tbl_expenses WHERE DATE_FORMAT(date, '%Y-%m') = ? AND project_id = $project_id;");
    $db->bind(1, date('Y-m'));
    $totalExpenses = $db->single()['total_amount'];
}
$db->query("SELECT COUNT(*) as total,`availability` FROM tbl_inventory GROUP BY `availability`;");
$inv = $db->set();
$availableCount = array_sum(array_column(array_filter($inv, fn($item) => $item['availability'] === 'Available'), 'total'));
$unavailableCount = array_sum(array_column(array_filter($inv, fn($item) => $item['availability'] === 'Unavailable'), 'total'));
$inventoryTotal = $availableCount + $unavailableCount;

$db->query("SELECT COUNT(*) as total,`status` FROM tbl_project GROUP BY `status`");
$proj = $db->set();
$projectCompleted = array_sum(array_column(array_filter($proj, fn($item) => $item['status'] === 'Completed'), 'total'));
$projectInprogress = array_sum(array_column(array_filter($proj, fn($item) => $item['status'] === 'In Progress'), 'total'));
$projectTotal = $projectCompleted + $projectInprogress;
?>
<style>

</style>
<!-- Page Sidebar Ends-->
<div class="page-body">
    <!-- Container-fluid starts-->
    <?php
    if ($userRole == 'Superadmin') {
        include 'home.admin.php';
    } else {
        include 'home.user.php';
    }

    ?>
    <!-- Container-fluid Ends-->

</div>

<?php include 'footer.php'; ?>
<script>
    // $('#attendance-table').DataTable({
    //     "bFilter": false,
    //     "bPaginate": false
    // });
</script>