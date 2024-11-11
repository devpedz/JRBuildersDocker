<?php
include 'header.php';
global $db;
global $session;
global $router;
$project_id = $id;

$db->query("SELECT * FROM tbl_project WHERE id = $project_id");
if (!$db->single()) {
    $router->trigger404();
    return;
}
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);

?>
<style>
    tr.bg-dark>th {
        color: white;
    }
</style>
<!-- Page Sidebar Ends-->
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid basic_table">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <?php
                            $db->query("SELECT * FROM tbl_project WHERE id = $project_id");
                            $project = $db->single();
                            ?>
                        </div>
                        <h4><?= $project['project_title'] ?></h4>
                        <p><?= $project['project_address'] . " - " . $project['project_description'] ?></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Add Employee </button>
                            </div>
                        </div>
                        <?php
                        $db->query("SELECT * FROM view_employee WHERE project_id = $project_id");
                        $data = $db->set();
                        ?>
                        <div class="mt-4 table-responsive theme-scrollbar">
                            <table id="tblemployee" class="display table-striped">
                                <thead class="tbl-strip-thad-bdr">
                                    <tr class="bg-dark" style="color:white !important">
                                        <th scope="col">Employee ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Rate/Day</th>
                                        <th scope="col">Member Since</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $row):
                                    ?>
                                        <tr>
                                            <th scope="row"><?= sprintf('%04d', $row['id']) ?></th>
                                            <td> <img class="img-30 me-2" src="../uploads/<?= $row['photo'] ?>" alt="&nbsp;"><?= $row['full_name'] ?>
                                            </td>
                                            <td><?= $row['address'] ?></td>
                                            <td><?= $row['position'] ?></td>
                                            <td><?= $row['rate_per_day'] ?></td>
                                            <td><?= $row['member_since'] ?></td>
                                            <td> <span
                                                    class="badge badge-<?= $row['status'] == 'ACTIVE' ? 'success' : 'danger' ?>"><?= $row['status'] ?></span>
                                            </td>

                                            <td>
                                                <ul class="action">
                                                    <?php if ($userRole == 'Superadmin'): ?>
                                                        <li class="delete"><a href="javascript:void(0);" onclick="RemoveEmployeeToProject(<?= $row['id'] ?>);"
                                                                data-bs-toggle="modal" data-bs-target="#RemoveEmployeeToProject"><i class="icon-trash"></i></a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h4 class="modal-header justify-content-center border-0 text-dark">Add Employee</h4>
                    <div class="modal-body">
                        <form id="form_add" class="row g-3 needs-validation" novalidate="">
                            <div class="col-md-12">
                                <input type="text" hidden name="project_id" value="<?= $project_id ?>">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="first_name">Select Employee</label>
                                    <select id="employee" name="employee_id" class="form-control" required>
                                        <option value=""></option>
                                        <?php
                                        $db->query("SELECT * FROM view_employee WHERE project_id is null ORDER BY full_name ASC");
                                        foreach ($db->set() as $employee):
                                        ?>
                                            <option value="<?= $employee['id'] ?>">
                                                <?= $employee['full_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-warning" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade" id="RemoveEmployeeToProject" tabindex="-1" role="dialog" aria-labelledby="RemoveEmployeeToProject"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img src="../../assets/images/gif/danger.gif" alt="error"></li>
                        </ul>
                        <h4 class="text-center pb-2">Warning</h4>
                        <p class="text-center">Are you sure you want to remove this employee to the project? <br>This action cannot be
                            undone.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="deleteProjectEmployee" type="button">Yes</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    var employee_id = '';

    function RemoveEmployeeToProject(id) {
        employee_id = id;
    };
    $('#deleteProjectEmployee').click(function(e) {
        $.post("/deleteProjectEmployee", {
                employee_id
            },
            function(data) {
                if (data.success) {
                    window.location.reload();
                }
            },
            "json"
        );
    });
    $(function() {
        $('#employee').selectize();
        $('#tblemployee').DataTable({

        });
    });
    $('#form_add').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/addProjectEmployee", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_add').removeClass("was-validated");
                        $('#form_add')[0].reset();
                        window.location.reload();
                    } else {
                        swal("Warning", data.message, "warning");
                    }
                },
                "json"
            );
            return false;
        }
        e.preventDefault();
    });
</script>