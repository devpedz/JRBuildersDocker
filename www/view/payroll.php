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
                            <h4>Payroll</h4>
                        </div>
                        <div class="header mt-3">
                            <?php if ($userRole == 'Superadmin'): ?>
                                <form id="form" method="POST">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="mb-3 form-floating">
                                                <select id="project_id" name="project_id" class="form-control" required>
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
                                        <div class="col-md-2">
                                            <div class="mb-3 form-floating">
                                                <select class="form-control" id="year">
                                                    <option value="">Select Year</option>
                                                    <?php
                                                    $currentYear = date("Y");
                                                    for ($year = 2024; $year <= $currentYear; $year++) {
                                                        $selected = ($currentYear == $year) ? 'selected' : '';
                                                        echo "<option value=\"$year\" $selected>$year</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <label for="year">Year</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3 form-floating">
                                                <select class="form-control" id="month">
                                                    <option value="">Select Month</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">January</option>
                                                </select>
                                                <label for="month">Month</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3 form-floating">
                                                <select class="form-control" id="days">
                                                    <option value="">Select Day</option>
                                                    <!-- Sundays will be populated here -->
                                                </select>
                                                <label for="days">Day</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="full_date" id="full_date" required>
                                        <div class="col-md-3">
                                            <div class="btn-group1" role="group" aria-label="Large button group">
                                                <button id="btnPayroll" disabled
                                                    class="btn btn-primary ripple-button btn-lg" type="button"><i
                                                        class="fa fa-print"></i> Payroll</button>
                                                <button id="btnPayslip" disabled
                                                    class="btn btn-secondary ripple-button btn-lg" type="button"><i
                                                        class="fa fa-print"></i> Payslip</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form id="form" method="POST">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3 form-floating">
                                                <select class="form-control" id="year">
                                                    <option value="">Select Year</option>
                                                    <?php
                                                    $currentYear = date("Y");
                                                    for ($year = 2024; $year <= $currentYear; $year++) {
                                                        $selected = ($currentYear == $year) ? 'selected' : '';
                                                        echo "<option value=\"$year\" $selected>$year</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <label for="year">Year</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3 form-floating">
                                                <select class="form-control" id="month">
                                                    <option value="">Select Month</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">January</option>
                                                </select>
                                                <label for="month">Month</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 form-floating">
                                                <select class="form-control" id="days">
                                                    <option value="">Select Day</option>
                                                    <!-- Sundays will be populated here -->
                                                </select>
                                                <label for="days">Day</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="full_date" id="full_date" required>
                                        <div class="col-md-3">
                                            <div class="btn-group1" role="group" aria-label="Large button group">
                                                <button id="btnPayroll" disabled
                                                    class="btn btn-primary ripple-button btn-lg" type="button"><i
                                                        class="fa fa-print"></i> Payroll</button>
                                                <button id="btnPayslip" disabled
                                                    class="btn btn-secondary ripple-button btn-lg" type="button"><i
                                                        class="fa fa-print"></i> Payslip</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
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
    $(function() {
        $('#btnPayroll').click(function() {
            if ($('#full_date').val().trim() === '') {
                alert('Input field cannot be empty!');
                return;
            }
            $('form').attr('action', '/payroll');
            $('form').submit();
        });

        $('#btnPayslip').click(function() {
            if ($('#full_date').val().trim() === '') {
                alert('Input field cannot be empty!');
                return;
            }
            $('form').attr('action', '/payslip');
            $('form').submit();
        });
        const $year = $('#year'),
            $month = $('#month'),
            $days = $('#days'),
            $fullDate = $('#full_date');
        <?php if ($userRole == 'Superadmin'): ?>
            const $project = $('#project_id');
            $project.on('change', updateFullDate);
        <?php endif; ?>
        $year.add($month).on('change', updateDays);
        $days.on('change', updateFullDate);

        function updateDays() {
            const year = $year.val(),
                month = $month.val();
            $days.empty().append('<option value="">Select Day</option>');

            if (year && month) {
                const sundays = getSundays(year, month - 1),
                    now = new Date();
                sundays.forEach(date => {
                    const day = date.getDate(),
                        option = new Option(day, day);
                    option.disabled = new Date(year, month - 1, day) > now;
                    $days.append(option);
                });
            }
            updateFullDate();
        }

        function updateFullDate() {
            const year = $year.val(),
                month = $month.val(),
                day = $days.val();
            const result = year && month && day ? `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}` : '';
            $fullDate.val(result);
            if (result === '') {
                $('#tbl').html("");
            } else {
                loadPayroll();

            }
        }

        function getSundays(year, month) {
            const sundays = [],
                date = new Date(year, month, 1);
            while (date.getMonth() === month) {
                if (date.getDay() === 0) sundays.push(new Date(date));
                date.setDate(date.getDate() + 1);
            }
            return sundays;
        }
    });

    function setPage(_page) {
        page = _page;
        loadPayroll();
    }

    function loadPayroll() {
        const formData = {
            page: page,
            form: $('#form').serialize(),
        };
        $.post("/loadPayroll", formData,
            function(data) {
                $('#tbl').html(data);
            }
        );
    }

    // loadPayroll();
</script>