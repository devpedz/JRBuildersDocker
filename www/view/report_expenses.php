<?php include 'header.php';
global $db;
global $session;
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
                            <h4>Expenses</h4>
                        </div>
                        <div class="header mt-3">
                            <form id="form" action="print/expense<?= ($userRole == 'Superadmin') ? 's' : '' ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="range-date">Date Range </label>
                                            <div class="input-group flatpicker-calender">
                                                <input class="form-control" id="range-date" name="range-date" type="date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3 form-floating">
                                            <select oninput="loadReportExpenses()" id="s_project_id" name="project_id" class="form-control">
                                                <option value=""> All Projects </option>
                                                <?php $db->query("SELECT * FROM tbl_project WHERE `status` = 'In Progress' ORDER BY project_title ASC");
                                                foreach ($db->set() as $project):
                                                ?>
                                                    <option value="<?= $project['id'] ?>">
                                                        <?= $project['project_title'] . " - " . $project['project_address'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label class="form-label" for="project_id">Project </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mt-4">
                                            <div class="btn-group" role="group" aria-label="Large button group">
                                                <label for=""></label>
                                                <button id="btnPrint" disabled
                                                    class="btn btn-secondary ripple-button btn-lg" type="submit"><i
                                                        class="fa fa-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-end">

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" id="search" name="search" placeholder=""
                                        required="" oninput="loadEmployees()">
                                    <label class="form-label" for="search">Search name...</label>
                                </div>
                            </div>
                        </div> -->
                        <div id="tbl">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade" id="deleteEmployee" tabindex="-1" role="dialog" aria-labelledby="deleteEmployee"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img src="../assets/images/gif/danger.gif" alt="error"></li>
                        </ul>
                        <h4 class="text-center pb-2">Warning</h4>
                        <p class="text-center">Are you sure you want to delete this employee? <br>This action cannot be
                            undone.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger delete" type="button">Delete</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="../assets/js/custom-btn-ripple.js"></script>
<script>
    var page = 1;
    var employeeId;
    var payrollDate;
    var rangePicker = flatpickr("#range-date", {
        mode: "range",
        dateFormat: "Y-m-d", // Specify the desired date format
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                loadReportExpenses();
                console.log(`Start date: ${dateStr.split(' to ')[0]}\nEnd date: ${dateStr.split(' to ')[1]}`);
            } else {
                // alert('No date selected.');
            }
        }
    });

    $('#form').submit(function(e) {
        if ($('#btnPrint').attr('disabled')) {
            e.preventDefault();
        }
    });

    function setPage(_page) {
        page = _page;
        loadReportExpenses();
    }

    function loadReportExpenses() {
        const selectedDates = rangePicker.selectedDates;
        const startDate = selectedDates[0].toLocaleDateString('en-CA'); // Format as YYYY-MM-DD
        const endDate = selectedDates[1].toLocaleDateString('en-CA');
        const project_id = $('#s_project_id').val();

        const formData = {
            page: page,
            start_date: startDate,
            end_date: endDate,
            project_id: project_id
        };
        $.post("/loadReportExpenses", formData,
            function(data) {
                $('#tbl').html(data);
            }
        );
    }
    // loadPayroll();
</script>