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
                            <div>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Add Expenses</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3 form-floating">
                                        <input class="form-control" type="text" id="search" name="search" placeholder=""
                                            required="" oninput="loadExpenses()">
                                        <label class="form-label" for="search">Receipt/Invoice No.</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3" <?= ($userRole == 'User') ? 'hidden' : '' ?>>
                                    <div class="mb-3 form-floating">
                                        <select oninput="loadExpenses()" id="s_project_id" name="s_project_id" class="form-control" required>
                                            <option value=""> All Projects </option>
                                            <?php $db->query("SELECT * FROM tbl_project WHERE `status` = 'In Progress' ORDER BY project_title ASC");
                                            foreach ($db->set() as $project):
                                            ?>
                                                <option value="<?= $project['id'] ?>" <?= $disabled ?>>
                                                    <?= $project['project_title'] . " - " . $project['project_address'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="form-label" for="project_id">Project </label>
                                    </div>
                                </div>
                            </div>
                            <div id="tbl_expenses">

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
                        <h4 class="modal-header justify-content-center border-0 text-dark">Update Expenses</h4>
                        <div class="modal-body">
                            <form id="form_update" class="row g-3 needs-validation" novalidate="">
                                <div class="col-12" hidden>
                                    <div class="mb-3 form-floating">
                                        <input id="expenseId" name="id" class="form-control" type="text" required
                                            placeholder>
                                        <label class="form-label">expenseId</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input id="expense_date" name="date" class="form-control" type="date" required
                                            placeholder>
                                        <label class="form-label">Date</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <select id="category_id" name="category_id" class="form-control" required>
                                            <option value=""></option>
                                            <?php $db->query("SELECT * FROM tbl_expense_categories ORDER BY category_name ASC");
                                            foreach ($db->set() as $category):
                                            ?>
                                                <option value="<?= $category['id'] ?>">
                                                    <?= $category['category_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="form-label" for="first_name">Category</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 form-floating">
                                        <input id="description" name="description" class="form-control" type="text"
                                            required placeholder>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input id="amount" name="amount" class="form-control cash" type="text" required
                                            placeholder>
                                        <label class="form-label">Amount</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input id="receipt_invoice" name="receipt_invoice" class="form-control"
                                            type="text" required placeholder>
                                        <label class="form-label">Receipt/Invoice No.</label>
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
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                        <h4 class="modal-header justify-content-center border-0 text-dark">Add Expenses</h4>
                        <div class="modal-body">
                            <form id="form_add" class="row g-3 needs-validation" novalidate="">
                                <?php if ($userRole == 'Superadmin'): ?>
                                    <div class="col-sm-12">
                                        <div class="mb-3 form-floating">
                                            <select name="project_id" class="form-control" required>
                                                <option value=""></option>
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
                                <?php endif; ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input id="expense_date2" name="date" class="form-control" type="date" required
                                            placeholder>
                                        <label class="form-label">Date</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <select name="category_id" class="form-control" required>
                                            <option value=""></option>
                                            <?php $db->query("SELECT * FROM tbl_expense_categories ORDER BY category_name ASC");
                                            foreach ($db->set() as $category):
                                            ?>
                                                <option value="<?= $category['id'] ?>">
                                                    <?= $category['category_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="form-label" for="category_id">Category</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 form-floating">
                                        <input name="description" class="form-control" type="text" required placeholder>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input id="amount1" name="amount" class="form-control cash" type="text" required
                                            placeholder>
                                        <label class="form-label">Amount</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input name="receipt_invoice" class="form-control" type="text" required
                                            placeholder>
                                        <label class="form-label">Receipt/Invoice No.</label>
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
    <div class="modal fade" id="deleteExpenses" tabindex="-1" role="dialog" aria-labelledby="deleteExpenses"
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
    var page = 1;
    var expenseId;

    function deleteExpenses(id) {
        expenseId = id;
    }

    function setPage(_page) {
        page = _page;
        loadExpenses();
    }
    const cleave = new Cleave("#amount", {
        numeral: true,
    });
    const cleave1 = new Cleave("#amount1", {
        numeral: true,
    });
    const expense_date = flatpickr("#expense_date", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        allowInput: true,
    });
    const expense_date2 = flatpickr("#expense_date2", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        allowInput: true
    });

    $('.delete').click(function(e) {

        $.post("/deleteExpenses", {
                id: expenseId
            },
            function(data, textStatus, jqXHR) {
                if (data.success) {
                    loadExpenses();
                    $('#deleteExpenses').modal('hide');
                }
            },
            "json"
        );
        e.preventDefault();

    });

    function loadExpenses() {
        const formData = {
            page: page,
            receipt_invoice: $('#search').val(),
            project_id: $('#s_project_id').val()
        };
        $.post("/loadExpenses", formData,
            function(data) {
                $('#tbl_expenses').html(data);
            },
            "text"
        );
    }
    loadExpenses();
    $('.upper').on('input', function() {
        var capitalizedText = $(this).val().toUpperCase();
        $(this).val(capitalizedText);
    });
</script>
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
    $('#form_add').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/addExpenses", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_add').removeClass("was-validated");
                        $('#form_add')[0].reset();
                        loadExpenses();
                        $('#modal_add').modal('hide');
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
            $.post("/updateExpenses", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        loadExpenses();
                        $('#modal_update').modal('hide');
                        $('#form_update').removeClass("was-validated");
                        $('#form_update')[0].reset();
                    }
                },
                "json"
            );
            return false;
        }
        e.preventDefault();
    });

    function updateExpenses(id) {
        $('#expenseId').val(id);
        $.post("/getExpenses", {
                id: id
            },
            function(data) {
                if (data.success) {
                    const row = data.rows;
                    expense_date.setDate(row.date, true);
                    $('#category_id').val(row.category_id).change();
                    $('#description').val(row.description);
                    $('#amount').val(row.amount);
                    $('#receipt_invoice').val(row.receipt_invoice);
                    $('#modal_update').modal('show');
                }
            }, "json"
        );
    }
</script>