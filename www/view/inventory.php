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

    .clear-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
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
                            <h4>Inventory</h4>
                            <div>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Add Inventory</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="/print/inventory" method="POST">
                                <div class="row">
                                    <div class="col-sm-4 col-md-3">
                                        <div class="mb-3 form-floating">
                                            <input class="form-control" type="text" id="search" name="search" placeholder="" oninput="loadInventory()">
                                            <label class="form-label" for="search">Item No./Item Name</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mb-3 form-floating">
                                            <select id="sType" name="sType" class="form-control" oninput="loadInventory()">
                                                <option value=""></option>
                                                <?php
                                                $db->query("SELECT * FROM tbl_inventory_types ORDER BY type_name ASC");
                                                foreach ($db->set() as $type):
                                                ?>
                                                    <option value="<?= $type['id'] ?>">
                                                        <?= $type['type_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label class="form-label" for="sType">Item Type</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mb-3 form-floating">
                                            <select id="sAvailability" name="availability" class="form-control" oninput="loadInventory()">
                                                <option value=""></option>
                                                <option value="Available">Available</option>
                                                <option value="Unavailable">Unavailable</option>
                                            </select>
                                            <label class="form-label" for="sAvailability">Availability</label>
                                        </div>
                                    </div>
                                    <div class="col sm-4 col-md-2">
                                        <div class="mb-3">
                                            <small class="form-label" for="sDate">Date</small>
                                            <div class="input-group flatpicker-calender">
                                                <input class="form-control" id="sDate" name="sDate" type="date" placeholder="" oninput="loadInventory()">
                                                <button class="clear-btn" id="clearBtn">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-secondary">Print</button>
                                    </div>
                                </div>
                            </form>
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
                        <h4 class="modal-header justify-content-center border-0 text-dark">Update Inventory</h4>
                        <div class="modal-body">
                            <form id="form_update" class="row g-3 needs-validation" novalidate="">
                                <div class="col-12" hidden>
                                    <div class="mb-3 form-floating">
                                        <input id="item_no" name="item_no" class="form-control" type="text" required
                                            placeholder>
                                        <label class="form-label">itemNo</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input id="date_acquired" name="date_acquired" class="form-control" type="date"
                                            required placeholder>
                                        <label class="form-label">Date Acquired</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <select id="type_id" name="type_id" class="form-control" required>
                                            <option value=""></option>
                                            <?php
                                            $db->query("SELECT * FROM tbl_inventory_types ORDER BY type_name ASC");
                                            foreach ($db->set() as $type):
                                            ?>
                                                <option value="<?= $type['id'] ?>">
                                                    <?= $type['type_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="form-label" for="item_type">Item Type</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input id="item_name" name="item_name" class="form-control" type="text" required
                                            placeholder>
                                        <label class="form-label">Item Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input id="id_plate_no" name="id_plate_no" class="form-control" type="text"
                                            required placeholder>
                                        <label class="form-label">ID/Plate No. (if applicable)</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input id="unit_cost" name="unit_cost" class="form-control cash" type="text"
                                            required placeholder>
                                        <label class="form-label">Unit Cost</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input id="description" name="description" class="form-control" type="text"
                                            required placeholder>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3 form-group">
                                        <label class="form-label" for="employee_id">Assigned To</label>
                                        <select id="employee_id" name="employee_id" class="form-control selectize">
                                            <option value=""></option>
                                            <?php
                                            $db->query("SELECT * FROM view_employee WHERE project_id = $project_id ORDER BY full_name ASC");
                                            if ($userRole == 'Superadmin') {
                                                $db->query("SELECT * FROM view_employee ORDER BY full_name ASC");
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
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <select id="availability" name="availability" class="form-control" required>
                                            <option value="Available">Available</option>
                                            <option value="Unavailable">Unavailable</option>
                                        </select>
                                        <label class="form-label">Availability</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 date_borrowed">
                                    <div class="mb-3 form-floating">
                                        <input id="date_borrowed" name="date_borrowed" class="form-control" type="date"
                                            placeholder>
                                        <label class="form-label">Date Borrowed</label>
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
                        <h4 class="modal-header justify-content-center border-0 text-dark">Add Inventory</h4>
                        <div class="modal-body">
                            <form id="form_add" class="row g-3 needs-validation" novalidate="">
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input id="date_acquired1" name="date_acquired" class="form-control" type="date"
                                            required placeholder>
                                        <label class="form-label">Date Acquired</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <select id="item_type" name="type_id" class="form-control" required>
                                            <option value=""></option>
                                            <?php
                                            $db->query("SELECT * FROM tbl_inventory_types ORDER BY type_name ASC");
                                            foreach ($db->set() as $type):
                                            ?>
                                                <option value="<?= $type['id'] ?>">
                                                    <?= $type['type_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="form-label" for="item_type">Item Type</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input name="item_name" class="form-control" type="text" required placeholder>
                                        <label class="form-label">Item Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-floating">
                                        <input name="id_plate_no" class="form-control" type="text" required placeholder>
                                        <label class="form-label">ID/Plate No. (if applicable)</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input name="description" class="form-control" type="text" required placeholder>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3 form-floating">
                                        <input id="unit_cost1" name="unit_cost" class="form-control cash" type="text"
                                            required placeholder>
                                        <label class="form-label">Unit Cost</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3 form-floating">
                                        <select name="availability" class="form-control" required>
                                            <option value="Available">Available</option>
                                            <option value="Unavailable" disabled>Unavailable</option>
                                        </select>
                                        <label class="form-label">Availability</label>
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
    <div class="modal fade" id="deleteInventory" tabindex="-1" role="dialog" aria-labelledby="deleteInventory"
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
    /**
     * Plugin: "clear_button" (selectize.js)
     * Copyright (c) 2015  Dmitri Piatkov & contributors
     *
     * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
     * file except in compliance with the License. You may obtain a copy of the License at:
     * http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software distributed under
     * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
     * ANY KIND, either express or implied. See the License for the specific language
     * governing permissions and limitations under the License.
     *
     * @author Dmitri Piatkov <dkrnl@yandex.ru>
     */

    Selectize.define("clear_button", function(options) {
        var self = this;
        if (self.settings.mode === "multiple") {
            return;
        }

        options = $.extend({
            label: "<i class=\"fa fa-times\"></i>",
            className: "btn btn-block btn-link",
            append: true
        }, options);

        self.on("initialize", function() {
            self.$clear_button = $("<button type=\"button\" tabindex=\"-1\"></button>");
            self.$clear_button.addClass(options.className).html(options.label);
            self.$clear_button.prop("disabled", !self.items.length);
            self.$dropdown.prepend(self.$clear_button);
            self.$clear_button.click(function() {
                if (self.items.length) {
                    self.setValue("");
                    self.onChange();
                    self.close();
                }
            });
            self.on("change", function() {
                self.$clear_button.prop("disabled", !self.items.length);
            });
        });
    });
    $("select.selectize").each(function() {
        var select = $(this),
            options = {
                plugins: {}
            };
        if (select.prop("multiple")) {
            options.hideSelected = false;
            options.plugins["remove_button"] = {}; // default selectize pluging
            options.plugins["optgroup_checkbox"] = {}; // https://gist.github.com/dkrnl/c97099bd042d8180426b
        } else {
            options.plugins["clear_button"] = {}; // this plugin
        }
        options.allowEmptyOption = true;
        options = $.extend(true, {}, options, select.data());
        select.selectize(options);
    });

    const datepicker = flatpickr("#sDate", {
        altInput: true,
        placeholder: "Select a date",
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        allowInput: true, // Allow typing in the input
        clearButton: true // Show a clear button (X) inside the input
    });
    document.getElementById('clearBtn').addEventListener('click', function() {
        datepicker.clear();
        document.getElementById('sDate').value = ''; // Also clear the input field text
    });
</script>
<script>
    var page = 1;
    var item_no;

    function deleteInventory(no) {
        item_no = no;
    }

    function setPage(_page) {
        page = _page;
        loadInventory();
    }
    const cleave = new Cleave("#unit_cost", {
        numeral: true,
    });
    const cleave1 = new Cleave("#unit_cost1", {
        numeral: true,
    });

    $('#employee').selectize();
    $('#employee_id').selectize();
    var empID = $('#employee_id')[0].selectize;
    $('#employee').change(function() {
        if (this.value === '') {
            $('.date_borrowed1').hide();
            $('#date_borrowed1').val('');
        } else {
            $('.date_borrowed1').show();
        }
    });


    // Initial check on page load
    if ($('#employee').val() === '') {
        $('.date_borrowed1').hide();
    } else {
        $('.date_borrowed1').show();
    }

    if ($('#employee_id').val() === '') {
        $('.date_borrowed').hide();
        $('#date_borrowed').val('');
        $('#date_borrowed').attr('required', false);

    } else {
        $('.date_borrowed').show();
        $('#date_borrowed').attr('required', true);
    }

    $('#employee_id').change(function() {
        if (this.value === '') {
            $('.date_borrowed').hide();
            $('#date_borrowed').val('');
            $('#date_borrowed').attr('required', false);

            // Re-enable Available option if employee_id is empty
            $('#availability option[value="Available"]').prop('disabled', false);

        } else {
            $('.date_borrowed').show();
            $('#date_borrowed').attr('required', true);

            // Set availability to "Unavailable"
            $('#availability').val('Unavailable');

            // Disable the "Available" option
            $('#availability option[value="Available"]').prop('disabled', true);
        }
    });



    $('.delete').click(function(e) {
        $.post("/deleteInventory", {
                item_no: item_no
            },
            function(data, textStatus, jqXHR) {
                if (data.success) {
                    loadInventory();
                    $('#deleteInventory').modal('hide');
                }
            },
            "json"
        );
        e.preventDefault();

    });

    function loadInventory() {
        const formData = {
            page: page,
            search: $('#search').val(),
            date_acquired: $('#sDate').val(),
            type_id: $('#sType').val(),
            availability: $('#sAvailability').val(),
        };
        $.post("/loadInventory", formData,
            function(data) {
                $('#tbl_expenses').html(data);
            },
            "text"
        );
    }
    loadInventory();
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
            $.post("/addInventory", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_add').removeClass("was-validated");
                        $('#form_add')[0].reset();
                        loadInventory();
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
            $.post("/updateInventory", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        loadInventory();
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

    function updateInventory(no) {
        $('#item_no').val(no);
        $.post("/getInventory", {
                item_no: no
            },
            function(data) {
                if (data.success) {
                    const row = data.rows;
                    $('#date_acquired').val(row.date_acquired);
                    $('#type_id').val(row.type_id);
                    $('#item_name').val(row.item_name);
                    $('#id_plate_no').val(row.id_plate_no);
                    $('#unit_cost').val(row.unit_cost);
                    $('#condition').val(row.condition);
                    $('#description').val(row.description);
                    $('#availability').val(row.availability);
                    $('#employee_id').val(row.employee_id).change();
                    empID.setValue(row.employee_id);
                    $('#date_borrowed').val(row.date_borrowed);
                    $('#modal_update').modal('show');
                }
            }, "json"
        );
    }
</script>