<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$userRole = ($session->get('user_data')['role']);
$type_id = $session->get('type_id');

?>
<style>
    tr.bg-dark>th {
        color: white;
    }
</style>
<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid p-0">
        <!-- Unlock page start-->
        <div class="container">
            <div class="row">
                <div class="col-8 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-top">
                                <h4>Inventory Types</h4>
                                <div><button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal_add">Add New</button></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive theme-scrollbar">
                                <table class="display" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Type Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $db->query("SELECT * FROM tbl_inventory_types ORDER BY type_name");
                                    foreach ($db->set() as $row):
                                    ?>
                                        <tr>

                                            <td><?= $row['type_name'] ?></td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit" title="edit"> <a href="javascript:void(0);"
                                                            onclick="updateType(<?= $row['id'] ?>);"><i class="icon-pencil-alt"></i></a>
                                                    </li>
                                                    <?php if ($userRole == 'Superadmin'): ?>
                                                        <li class="delete" title="delete"><a href="javascript:void(0);"
                                                                onclick="deleteType(<?= $row['id'] ?>);" data-bs-toggle="modal"
                                                                data-bs-target="#deleteInventory"><i class="icon-trash"></i></a>
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

        <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_update"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                        <h4 class="modal-header justify-content-center border-0 text-dark">Update Inventory Type</h4>
                        <div class="modal-body">
                            <form id="form_update" class="row g-3 needs-validation" novalidate="">
                                <div class="col-md-12">
                                    <div class="mb-3" hidden>
                                        <label class="form-label" for="type_id">Inventory Type Id</label>
                                        <input id="type_id" class="form-control" name="type_id" type="text"
                                            placeholder="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="type_name">Type Name</label>
                                        <input id="type_name" class="form-control upper" name="type_name"
                                            type="text" placeholder="" required>
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
                        <h4 class="modal-header justify-content-center border-0 text-dark">Add Inventory Type</h4>
                        <div class="modal-body">
                            <form id="form_add" class="row g-3 needs-validation" novalidate="">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="type_name">Type Name</label>
                                        <input id="type_name" class="form-control upper" name="type_name"
                                            type="text" placeholder="" required>
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
        <div class="modal fade" id="deleteType" tabindex="-1" role="dialog" aria-labelledby="deleteType"
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
    $("#datatable").DataTable();

    function updateType(id) {
        const row = event.target.closest('tr');
        const firstTd = row.querySelector('td:first-child');
        const typeName = firstTd.textContent.trim();
        $('#type_id').val(id);
        $('#type_name').val(typeName);
        $('#modal_update').modal('show');

    }
    $('#form_add').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/addType", $(this).serialize(),
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
            $.post("updateType", $(this).serialize(),
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

    var typeId;

    function deleteType(id) {
        typeId = id;
        $('#deleteType').modal('show');
    }
    $('.delete').click(function(e) {
        $.post("deleteType", {
                id: typeId
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