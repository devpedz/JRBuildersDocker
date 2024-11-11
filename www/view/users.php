<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$project_id = $session->get('project_id');
$userRole = ($session->get('user_data')['role']);

if ($userRole != 'Superadmin') {
    echo "<script>window.location.href ='/home'</script>";
}

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
                            <h4>Users</h4>
                            <div>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Add User </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" id="search" name="search" placeholder=""
                                        required="" oninput="loadUsers()">
                                    <label class="form-label" for="search">Search Name</label>
                                </div>
                            </div>
                        </div>
                        <div id="tbl_user">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade" id="modal_update_pw" tabindex="-1" role="dialog" aria-labelledby="modal_update_pw"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h4 class="modal-header justify-content-center border-0 text-dark">Update User Password</h4>
                    <div class="modal-body">
                        <form id="form_update_pw" class="row g-3 needs-validation" novalidate="">
                            <div class="col-12" hidden>
                                <div class="mb-3 form-floating">
                                    <input id="_userId" name="id" class="form-control" type="text" required
                                        placeholder>
                                    <label class="form-label">User ID</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="password" id="password" name="password" placeholder="password" minlength="8" required>
                                    <label class="form-label" for="password">Password</label>
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
    <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_update"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h4 class="modal-header justify-content-center border-0 text-dark">Update User</h4>
                    <div class="modal-body">
                        <form id="form_update" class="row g-3 needs-validation" novalidate="">
                            <div class="col-12" hidden>
                                <div class="mb-3 form-floating">
                                    <input id="userId" name="id" class="form-control" type="text" required
                                        placeholder>
                                    <label class="form-label">User ID</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" id="full_name" name="full_name" placeholder="Full name" required>
                                    <label class="form-label" for="full_name">Full name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" id="username" name="username" placeholder="Username" required>
                                    <label class="form-label" for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <select id="role" class="form-control btn-square" name="role" required>
                                        <option value="Superadmin">Superadmin</option>
                                        <option value="User">User</option>
                                    </select>
                                    <label class="form-label">Role</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <select id="status" class="form-control btn-square" name="status" required>
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                    <label class="form-label">Status</label>
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
                    <h4 class="modal-header justify-content-center border-0 text-dark">Add User</h4>
                    <div class="modal-body">
                        <form id="form_add" class="row g-3 needs-validation" novalidate="">
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" name="full_name" placeholder="Full name" required>
                                    <label class="form-label" for="full_name">Full name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" name="username" placeholder="Username" required>
                                    <label class="form-label" for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <select class="form-control btn-square" name="role" required>
                                        <option value="Superadmin">Superadmin</option>
                                        <option value="User">User</option>
                                    </select>
                                    <label class="form-label">Role</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="password" name="password" placeholder="Password" required minlength="8">
                                    <label class="form-label" for="password">Password</label>
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
<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
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

    var userId;

    function deleteUser(id) {
        userId = id;
    }

    $('.delete').click(function(e) {
        $.post("/deleteUser", {
                id: attendanceId
            },
            function(data, textStatus, jqXHR) {
                if (data.success) {
                    loadUsers();
                    $('#deleteUser').modal('hide');
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
        loadUsers();
    }

    function loadUsers() {
        const formData = {
            page: page,
            name: $('#search').val(),
        };
        $.post("/loadUsers", formData,
            function(data) {
                $('#tbl_user').html(data);
            },
            "text"
        );
    }
    loadUsers();

    $('#form_add').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/addUser", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_add').removeClass("was-validated");
                        $('#form_add')[0].reset();
                        loadUsers();
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

    function updateUserPw(id) {
        $('#_userId').val(id);
        $('#modal_update_pw').modal('show');
    }
    $('#form_update_pw').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/updateUserPw", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_update_pw').removeClass("was-validated");
                        $('#form_update_pw')[0].reset();
                        loadUsers();
                        $('#modal_update_pw').modal('hide');
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

    function updateUser(id) {
        $('#userId').val(id);
        $('#modal_update').modal('show');
        $.post("/getUser", {
                id: id
            },
            function(data) {
                if (data.success) {
                    const row = data.rows;
                    $('#full_name').val(row.full_name);
                    $('#username').val(row.username);
                    $('#role').val(row.role).change();
                    $('#status').val(row.status).change();
                }
            }, "json"
        );
    }
    $('#form_update').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/updateUser", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_update').removeClass("was-validated");
                        $('#form_update')[0].reset();
                        loadUsers();
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
</script>