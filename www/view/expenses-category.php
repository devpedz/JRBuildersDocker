<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
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
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h4>Category List</h4>
                            <div>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Add Category</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3 form-floating">
                                        <input class="form-control" type="text" id="search" name="search" placeholder=""
                                            required="" oninput="loadCategories()">
                                        <label class="form-label" for="search">Search category...</label>
                                    </div>
                                </div>
                            </div>
                            <div id="tbl_category">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_update_category"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                        <h4 class="modal-header justify-content-center border-0 text-dark">Add Category</h4>
                        <div class="modal-body">
                            <form id="form_update" class="row g-3 needs-validation" novalidate="">
                                <div class="col-md-12">
                                    <div class="mb-3" hidden>
                                        <label class="form-label" for="category_id">Category Id</label>
                                        <input id="category_id" class="form-control" name="category_id" type="text"
                                            placeholder="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="category_name">Category Name</label>
                                        <input id="category_name" class="form-control upper" name="category_name"
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
        <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add_category"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                        <h4 class="modal-header justify-content-center border-0 text-dark">Add Category</h4>
                        <div class="modal-body">
                            <form id="form_add" class="row g-3 needs-validation" novalidate="">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="category_name">Category Name</label>
                                        <input class="form-control upper" name="category_name" type="text"
                                            placeholder="" required>
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
    <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategory"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img src="../assets/images/gif/danger.gif" alt="error"></li>
                        </ul>
                        <h4 class="text-center pb-2">Warning</h4>
                        <p class="text-center">Are you sure you want to delete this category? <br>This action cannot be
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
    // Then, you can safely use it

    const API = new APIRequest();
    var page = 1;
    var categoryId;

    function deleteCategory(id) {
        categoryId = id;
    }

    $('.delete').click(function (e) {
        $.post("/deleteCategory", { id: categoryId },
            function (data) {
                if (data.success) {
                    loadCategories();
                    $('#deleteCategory').modal('hide');
                }
            },
            "json"
        );

        e.preventDefault();

    });

    function setPage(_page) {
        page = _page;
        loadCategories();
    }


    function re_enroll(id) {
        swal({
            title: "Fingerprint Re-enrollment",
            text: "Fingerprints are already set up. Do you want to re-enroll it?",
            icon: "warning",
            buttons: {
                cancel: 'No',
                yes: true,
            },
            dangerMode: true,
        }).then((enroll) => {
            if (enroll) {
                window.location.assign(`fingerprint-registration/${id}`);
            }
        });

    }
    function loadCategories() {
        const formData = {
            page: page,
            name: $('#search').val(),
        };
        API.post('/loadCategories', formData)
            .then(data => {
                $('#tbl_category').html(data);
            })
            .catch(error => {
                $(this).attr('disabled', false);
                $(this).html("Reload Data");
                console.error('Error:', error);
            });

    }
    loadCategories();
    $('.upper').on('input', function () {
        var capitalizedText = $(this).val().toUpperCase();
        $(this).val(capitalizedText);
    });
</script>
<script>
    "use strict";
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
    $('#form_update').submit(function (e) {
        if (this.checkValidity()) {
            API.post('/updateCategory', $(this).serialize())
                .then(data => {
                    if (data.success) {
                        loadCategories();
                        $('#modal_update').modal('hide');
                    } else {
                        swal({
                            title: "Warning",
                            text: "Already exist. Try a different name.",
                            icon: "warning",
                            dangerMode: true,
                        })
                    }
                });
            form.classList.remove("was-validated");
            form.reset();
            return false;
        }
        e.preventDefault();
    });
    $('#form_add').submit(function (e) {
        if (this.checkValidity()) {
            $.post("/addCategory", $(this).serialize(),
                function (data) {
                    if (data.success) {
                        loadCategories();
                        $('#modal_add').modal('hide');
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
            form.classList.remove("was-validated");
            form.reset();
            return false;
        }
        e.preventDefault();
    });

    function updateCategory(id) {
        $('#category_id').val(id);
        $.post("/getCategory", { id: id },
            function (data) {
                if (data.success) {
                    $('#category_name').val(data.category_name);
                    $('#modal_update').modal('show');
                }
            },
            "json"
        );
    }
</script>