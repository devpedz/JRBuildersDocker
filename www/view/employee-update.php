<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$db->query("SELECT * FROM tbl_employee WHERE id = $employee_id");
$employee = $db->single();
?>
<style>
    .loading-spinner {
        display: none;
        color: white;
        /* Loading spinner color */
    }

    .social-img img {
        height: 100px;
        border-radius: 100%;
    }

    #imagePreview {
        cursor: pointer;
    }

    #imageFile {
        display: none;
    }
</style>

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="col-xl-12">
        <form id="employee_form" class="card needs-validation" novalidate>
            <div class="card-header">
                <h4 class="card-title mb-0">UPDATE EMPLOYEE</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3 d-flex justify-content-center mb-3">
                        <div class="col-5">
                            <div id="imagePreview" onclick="$('#imageFile').click();" class="text-center">
                                <div class="social-img-wrap">
                                    <div class="social-img"><img src="/uploads/<?= $employee['photo'] ?>" alt="profile">
                                    </div>
                                    <div class="edit-icon">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group text-center">
                                <input type="file" id="imageFile" name="imageFile" accept="image/*"
                                    class="mt-2 form-control" />
                                <div class="invalid-feedback text-danger">Please upload a photo </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title">Employee ID: <?= $employee_id ?></h4>

                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" id="first_name" name="first_name"
                                placeholder="First name" required value="<?= $employee['first_name'] ?>">
                            <label class="form-label" for="first_name">First Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="middle_name" placeholder="Middle name"
                                value="<?= $employee['middle_name'] ?>">
                            <label class="form-label" for="middle_name">Middle Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" id="" name="last_name" placeholder="Last name"
                                value="<?= $employee['last_name'] ?>">
                            <label class="form-label" for="last_name">Last Name</label>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <select class="form-control btn-square" name="suffix">
                                <option value=""></option>
                                <option value="Jr." <?= $employee['suffix'] == 'Jr.' ? 'selected' : '' ?>>Jr.</option>
                                <option value="Sr." <?= $employee['suffix'] == 'Sr.' ? 'selected' : '' ?>>Sr.</option>
                                <option value="I" <?= $employee['suffix'] == 'I' ? 'selected' : '' ?>>I</option>
                                <option value="II" <?= $employee['suffix'] == 'II' ? 'selected' : '' ?>>II</option>
                                <option value="III" <?= $employee['suffix'] == 'III' ? 'selected' : '' ?>>III</option>
                                <option value="IV" <?= $employee['suffix'] == 'IV' ? 'selected' : '' ?>>IV</option>
                                <option value="V" <?= $employee['suffix'] == 'V' ? 'selected' : '' ?>>V</option>
                            </select>
                            <label class="form-label">Suffix</label>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <select class="form-control btn-square" name="gender" required>
                                <option value="">--Select--</option>
                                <option value="Male" <?= $employee['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $employee['gender'] == 'Female' ? 'selected' : '' ?>>Female
                                </option>
                            </select>
                            <label class="form-label">Gender</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="mb-3 form-floating">
                            <input name="birthday" id="birthday" class="form-control" type="date" required
                                value="<?= $employee['birthday'] ?>">
                            <label class="form-label">Birthday</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="address" placeholder="Address" required
                                value="<?= $employee['address'] ?>">
                            <label class="form-label">Address</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="contact_no" placeholder="Contact Number" required
                                value="<?= $employee['contact_no'] ?>">
                            <label class="form-label">Contact Number</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="position" placeholder="Position" required
                                value="<?= $employee['position'] ?>">
                            <label class="form-label">Position</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" id="rate_per_day" name="rate_per_day" type="text"
                                placeholder="Rate/Day" required value="<?= $employee['rate_per_day'] ?>">
                            <label class="form-label" for="rate_per_day">Rate/Day</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <select class="form-control btn-square" required name="status">
                                <option value="ACTIVE" <?= $employee['status'] == 'ACTIVE' ? 'selected' : '' ?>>Active
                                </option>
                                <option value="INACTIVE" <?= $employee['status'] == 'INACTIVE' ? 'selected' : '' ?>>
                                    Inactive</option>
                            </select>
                            <label class="form-label">Status</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input id="member_since" name="member_since" class="form-control" type="date" required
                                value="<?= $employee['member_since'] ?>">
                            <label class="form-label">Member Since</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-end">
                <a class="btn btn-dark" href="/employees">Back</a>
                <button id="btnSubmit" class="btn btn-primary" type="submit">Submit<span class="loading-spinner"><i
                            class="spinner-border spinner-border-sm"></i></span></button>
            </div>
        </form>
        <form id="imageUploadForm" enctype="multipart/form-data">

        </form>

    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    var loadingSpinner = $('.loading-spinner');
    var cleave = new Cleave("#rate_per_day", {
        numeral: true,
    });
    flatpickr("#birthday", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });
    flatpickr("#member_since", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });


    // Function to validate image dimensions
    function validateImage(file, callback) {
        var img = new Image();
        img.onload = function() {
            var isValid = (this.width <= 2500 && this.height <= 2500); // Adjust dimensions as per your requirement
            callback(isValid);
        };
        img.src = URL.createObjectURL(file);
    }
    // Preview selected image
    $('#imageFile').change(function() {
        $('#imagePreview img').attr('src', 'assets/images/user/7.jpg');
        var file = this.files[0];
        if (file) {
            validateImage(file, function(valid) {
                if (valid) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imageFile').val('');
                    alert('Please upload an image with dimensions <= 400x400.');
                }
            });
        }
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
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    $('#employee_form').submit(function(e) {
        e.preventDefault();
        if (this.checkValidity()) {
            var file = $('#imageFile')[0].files[0]; // Assuming you are selecting the file input by ID
            var form = $('#employee_form')[0]; // Assuming you are selecting the form by ID
            var formData = new FormData(form);
            formData.append('imgFile', file);
            const btnSubmit = $('#btnSubmit');
            console.log(formData);
            btnSubmit.attr("disabled", true);
            loadingSpinner.show();
            $.ajax({
                url: '/updateEmployee/<?= $employee_id ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        btnSubmit.attr("disabled", false);
                        loadingSpinner.hide();
                        window.location.assign(data.redirect);
                    } else {
                        btnSubmit.attr("disabled", false);
                        loadingSpinner.hide();
                        swal("Error", data.message, "error");
                    }
                },
                dataType: 'json'
            });
        }
    });
</script>