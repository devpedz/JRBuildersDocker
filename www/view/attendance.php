<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
$project_id = $session->get('project_id');


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
                            <h4>Attendance</h4>
                            <div>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Add Attendance </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" id="search" name="search" placeholder=""
                                        required="" oninput="loadAttendance()">
                                    <label class="form-label" for="search">Search Name</label>
                                </div>
                            </div>
                        </div>
                        <div id="tbl_attendance">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_update"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h4 class="modal-header justify-content-center border-0 text-dark">Update Attendance</h4>
                    <div class="modal-body">
                        <form id="form_update" class="row g-3 needs-validation" novalidate="">
                            <div class="col-12" hidden>
                                <div class="mb-3 form-floating">
                                    <input id="attendanceId" name="id" class="form-control" type="text" required
                                        placeholder>
                                    <label class="form-label">Attendance ID</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 form-group">
                                    <div class="mb-3 form-floating">
                                        <input id="employee_name" name="employee_name" class="form-control" type="text"
                                            readonly placeholder>
                                        <label class="form-label">Employee</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3 form-floating">
                                    <input id="date" name="date" class="form-control" type="date" required placeholder>
                                    <label class="form-label">Date</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3 form-floating">
                                    <input id="timeIn" name="timeIn" class="form-control" type="time" required
                                        placeholder>
                                    <label class="form-label">Time-In</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3 form-floating">
                                    <input id="timeOut" name="timeOut" class="form-control" type="time" required
                                        placeholder>
                                    <label class="form-label">Time-Out</label>
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
    <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h4 class="modal-header justify-content-center border-0 text-dark">Add Attendance</h4>
                    <div class="modal-body">
                        <form id="form_add" class="row g-3 needs-validation" novalidate="">
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="first_name">Select Employee</label>
                                    <select id="employee" name="employee_id" class="form-control" required>
                                        <option value=""></option>
                                        <?php
                                        if ($userRole === 'Superadmin') {
                                            $db->query("SELECT * FROM view_employee ORDER BY full_name ASC");
                                        } else {
                                            $db->query("SELECT * FROM view_employee WHERE project_id = $project_id ORDER BY full_name ASC");
                                        }
                                        foreach ($db->set() as $employee):
                                        ?>
                                            <option value="<?= $employee['id'] ?>">
                                                <?= $employee['full_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3 form-floating">
                                    <input id="date1" name="date" class="form-control" type="date" required placeholder>
                                    <label class="form-label">Date</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3 form-floating">
                                    <input id="time1" name="timeIn" class="form-control" type="time" required
                                        placeholder>
                                    <label class="form-label">Time-In</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3 form-floating">
                                    <input id="time2" name="timeOut" class="form-control" type="time" required
                                        placeholder>
                                    <label class="form-label">Time-Out</label>
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
</div>
<div class="modal fade" id="deleteAttendance" tabindex="-1" role="dialog" aria-labelledby="deleteAttendance"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-toggle-wrapper">
                    <ul class="modal-img">
                        <li> <img src="../assets/images/gif/danger.gif" alt="error"></li>
                    </ul>
                    <h4 class="text-center pb-2">Warning</h4>
                    <p class="text-center">Are you sure you want to delete this attendance? <br>This action cannot be
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
<script>
    "use strict";
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
    // Then, you can safely use it
    var page = 1;
    // $(".select2").select2();
    $('#employee').selectize();
    $('#employee_id').selectize();

    var attendanceId;

    function deleteAttendance(id) {
        attendanceId = id;
    }

    $('.delete').click(function(e) {
        $.post("/deleteAttendance", {
                id: attendanceId
            },
            function(data, textStatus, jqXHR) {
                if (data.success) {
                    loadAttendance();
                    $('#deleteAttendance').modal('hide');
                }
            },
            "json"
        );
        e.preventDefault();

    });

    // const date1 = flatpickr("#date1", {
    //     altInput: true,
    //     altFormat: "F j, Y",
    //     dateFormat: "Y-m-d",
    //     allowInput: true,
    // });
    // const time1 = flatpickr("#time1", {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: "H:i",
    // });

    function setPage(_page) {
        page = _page;
        loadAttendance();
    }

    function loadAttendance() {
        const formData = {
            page: page,
            name: $('#search').val(),
        };
        $.post("/loadAttendance", formData,
            function(data) {
                $('#tbl_attendance').html(data);
            },
            "text"
        );
    }
    loadAttendance();

    $('#form_add').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/addAttendance", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_add').removeClass("was-validated");
                        $('#form_add')[0].reset();
                        loadAttendance();
                        $('#modal_add').modal('hide');
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

    function updateAttendance(id) {
        $('#attendanceId').val(id);
        $('#modal_update').modal('show');
        $.post("/getAttendance", {
                id: id
            },
            function(data) {
                if (data.success) {
                    const row = data.rows;
                    $('#employee_name').val(row.full_name);
                    $('#date').val(row.date);
                    $('#timeIn').val(row.timeIn);
                    $('#timeOut').val(row.timeOut);
                }
            }, "json"
        );
        $('#form_update').submit(function(e) {
            if (this.checkValidity()) {
                $.post("/updateAttendance", $(this).serialize(),
                    function(data) {
                        if (data.success) {
                            $('#form_update').removeClass("was-validated");
                            $('#form_update')[0].reset();
                            loadAttendance();
                            $('#modal_update').modal('hide');
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
    }
</script>