<?php
global $db;
global $session;
global $router;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
if ($userRole == 'Superadmin') {
    $router->trigger404();
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Mofi admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Mofi admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>J.R. BUILDERS - Information Management System</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/tagify.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/selectize.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/datatables.css">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
</head>
<style>
    .select2-search--dropdown {
        display: block;
        padding: 4px;
        border: 1px solid var(--bs-);
    }

    .login-card .login-main {
        width: 600px;
    }

    .line-break {
        white-space: pre-line;
        /* Preserves whitespace and line breaks */
    }

    .login-card .login-main {
        width: 1000px !important;
    }

    body {
        background: url(../../assets/images/official_logo.png) !important;
        background-position: center !important;
        background-size: 45% !important;
        background-repeat: no-repeat !important;
    }

    a.fixed-button {
        z-index: 99;
        width: 100px;
        position: absolute;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        font-size: 16px;
    }
</style>

<body>
    <a class="fixed-button btn btn-dark" href="/logout"><i class="fa fa-arrow-left"></i><br>Logout</a>

    <div class="loader-wrapper">
        <div class="loader loader-1">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
            <div class="loader-inner-1"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <!-- Unlock page start-->
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-top">
                                    <h4>Projects</h4>
                                    <div><button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#modal_add">Add Project</button></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <table class="display" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>Project Title</th>
                                                <th>Project Description</th>
                                                <th>Project Address</th>
                                                <th>Project Status</th>
                                                <th>Employees</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $db->query("SELECT * FROM tbl_project ORDER BY project_title");
                                        foreach ($db->set() as $row):
                                            $db->query("SELECT count(*) as total FROM tbl_employee WHERE project_id = ?");
                                            $db->bind(1, $row['id']);
                                            $employee = $db->single()['total'];
                                        ?>
                                            <tr>
                                                <td><?= $row['project_title'] ?></td>
                                                <td><?= $row['project_description'] ?></td>
                                                <td><?= $row['project_address'] ?></td>
                                                <td><?= ($row['status'] == 'In Progress') ? '<span class="badge badge-warning">In Progress</span>' : '<span class="badge badge-success">Completed</span>' ?>
                                                </td>
                                                <td><?= $employee ?></td>
                                                <td>
                                                    <button class="btn btn-primary" onclick="setProject(<?= $row['id'] ?>)">Open</button>
                                                    <button class="btn btn-success" onclick="updateProject(<?= $row['id'] ?>);">Update
                                                    </button>
                                                    <?php if ($userRole == 'Superadmin'): ?>
                                                        <button class="btn btn-danger" onclick="deleteProject(<?= $row['id'] ?>);">Delete
                                                        </button>
                                                    <?php endif; ?>
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

            <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_update"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                            <h4 class="modal-header justify-content-center border-0 text-dark">Update Project</h4>
                            <div class="modal-body">
                                <form id="form_update" class="row g-3 needs-validation" novalidate="">
                                    <div class="col-md-12">
                                        <div class="mb-3" hidden>
                                            <label class="form-label" for="project_id">Project Id</label>
                                            <input id="project_id" class="form-control" name="project_id" type="text"
                                                placeholder="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_title">Project Title</label>
                                            <input id="project_title" class="form-control upper" name="project_title"
                                                type="text" placeholder="" required disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_title">Description</label>
                                            <textarea name="project_description" id="project_description"
                                                class="form-control upper" required disabled></textarea >
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_address">Address</label>
                                            <textarea name="project_address" id="project_address"
                                                class="form-control upper" required disabled></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_address">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
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
            <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                            <h4 class="modal-header justify-content-center border-0 text-dark">Add Project</h4>
                            <div class="modal-body">
                                <form id="form_add" class="row g-3 needs-validation" novalidate="">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="project_title">Project Title</label>
                                            <input class="form-control upper" name="project_title" type="text"
                                                placeholder="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_title">Description</label>
                                            <textarea name="project_description" class="form-control upper"
                                                required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_address">Address</label>
                                            <textarea name="project_address" class="form-control upper"
                                                required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="project_address">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
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
            <div class="modal fade" id="deleteProject" tabindex="-1" role="dialog" aria-labelledby="deleteProject"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-toggle-wrapper">
                                <ul class="modal-img">
                                    <li> <img src="../assets/images/gif/danger.gif" alt="error"></li>
                                </ul>
                                <h4 class="text-center pb-2">Warning</h4>
                                <p class="text-center">Are you sure you want to delete this project? <br>This action
                                    cannot be
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
            <!-- latest jquery-->
            <script src="../assets/js/jquery.min.js"></script>
            <!-- Bootstrap js-->
            <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
            <!-- feather icon js-->
            <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
            <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
            <!-- scrollbar js-->
            <!-- Sidebar jquery-->
            <script src="../assets/js/config.js"></script>
            <script src="../assets/js/sweet-alert/sweetalert.min.js"></script>
            <script src="../assets/js/selectize.min.js"></script>
            <script src="../assets/js/select2.min.js"></script>
            <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
            <!-- Theme js-->
            <script src="../assets/js/script.js"></script>
            <script src="/src/js/axios.min.js"></script>
            <script src="/src/js/api.js"></script>
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
                const API = new APIRequest();

                // JavaScript to replace \n with actual line breaks
                document.addEventListener('DOMContentLoaded', () => {
                    const options = document.querySelectorAll('.line-break');
                    options.forEach(option => {
                        option.textContent = option.textContent.replace(/\\n/g, '\n');
                    });
                });
                $('#project').selectize();
                $('.form-select').selectize();

                function setProject(id) {
                    (async () => {
                        try {
                            const result = await $.ajax({
                                url: '/setProject',
                                method: 'POST',
                                data: {
                                    project: id
                                },
                            });
                            if (result) {
                                window.location.assign('/home');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    })();
                }
                $('#project_form').submit(function(e) {
                    e.preventDefault();
                    if (this.checkValidity()) {
                        let formData = ($(this).serialize());
                        (async () => {
                            try {
                                const result = await $.ajax({
                                    url: '/setProject',
                                    method: 'POST',
                                    data: formData,
                                });
                                if (result) {
                                    window.location.assign('/home');
                                }
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        })();
                    } else {
                        swal("Notification", "Please select a project", "info");
                    }
                });
                $("#basic-1").DataTable();

                function updateProject(id) {
                    $('#project_id').val(id);
                    $.post("/getProject", {
                            id: id
                        },
                        function(data) {

                            if (data.success) {
                                const row = data.rows[0];
                                console.log(row.project_title);
                                $('#project_id').val(row.id);
                                $('#project_title').val(row.project_title);
                                $('#project_description').val(row.project_description);
                                $('#project_address').val(row.project_address);
                                $('#status').val(row.status).change();
                                $('#modal_update').modal('show');
                            }
                        },
                        "json"
                    );
                }
                $('#form_add').submit(function(e) {
                    if (this.checkValidity()) {
                        $.post("/addProject", $(this).serialize(),
                            function(data, textStatus, jqXHR) {
                                if (data.success) {
                                    window.location.reload();
                                    $('#modal_add').modal('hide');
                                    $(this).removeClass("was-validated");
                                    $(this)[0].reset();
                                } else {
                                    swal({
                                        title: "Warning",
                                        text: "Already exist. Try a different name.",
                                        icon: "warning",
                                        dangerMode: true,
                                    })
                                }
                            },
                            "json"
                        );
                        return false;
                    }
                    e.preventDefault();
                });
                $('#form_update').submit(function(e) {
                    if (this.checkValidity()) {
                        $.post("updateProject", $(this).serialize(),
                            function(data, textStatus, jqXHR) {
                                if (data.success) {
                                    window.location.reload();
                                    $('#modal_update').modal('hide');
                                    $(this).removeClass("was-validated");
                                    $(this)[0].reset();
                                } else {
                                    swal({
                                        title: "Warning",
                                        text: "Already exist. Try a different name.",
                                        icon: "warning",
                                        dangerMode: true,
                                    })
                                }
                            },
                            "json"
                        );

                        return false;
                    }
                    e.preventDefault();
                });

                var projectId;

                function deleteProject(id) {
                    projectId = id;
                    $('#deleteProject').modal('show');
                }
                $('.delete').click(function(e) {
                    $.post("deleteProject", {
                            id: projectId
                        },
                        function(data) {
                            if (data.success) {
                                window.location.reload();
                            }
                        },
                        "json"
                    );
                    e.preventDefault();

                });
            </script>
            <!-- Plugin used-->
        </div>
    </div>
</body>

</html>