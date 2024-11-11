<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
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
                <h4 class="card-title mb-0">REGISTRATION</h4>
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
                                    <div class="social-img"><img src="assets/images/user/7.jpg" alt="profile"></div>
                                    <div class="edit-icon">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group text-center">
                                <input type="file" id="imageFile" name="imageFile" accept="image/*"
                                    class="mt-2 form-control" required />
                                <div class="invalid-feedback text-danger">Please upload a photo </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" id="first_name" name="first_name"
                                placeholder="First name" required>
                            <label class="form-label" for="first_name">First Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="middle_name" placeholder="Middle name">
                            <label class="form-label" for="middle_name">Middle Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" id="" name="last_name" placeholder="Last name"
                                required>
                            <label class="form-label" for="last_name">Last Name</label>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <select class="form-control btn-square" name="suffix">
                                <option value=""></option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select>
                            <label class="form-label">Suffix</label>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <select class="form-control btn-square" name="gender" required>
                                <option value="">--Select--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label class="form-label">Gender</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="mb-3 form-floating">
                            <input name="birthday" id="birthday" class="form-control" type="date" required>
                            <label class="form-label">Birthday</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="address" placeholder="Address" required>
                            <label class="form-label">Address</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="contact_no" placeholder="Contact Number" required
                                value="">
                            <label class="form-label">Contact Number</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="position" placeholder="Position" required>
                            <label class="form-label">Position</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input class="form-control" id="rate_per_day" name="rate_per_day" type="text"
                                placeholder="Rate/Day" required>
                            <label class="form-label" for="rate_per_day">Rate/Day</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <select class="form-control btn-square" required name="status">
                                <option value="ACTIVE" selected>Active</option>
                                <option value="INACTIVE" disabled>Inactive</option>
                            </select>
                            <label class="form-label">Status</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="mb-3 form-floating">
                            <input id="member_since" name="member_since" class="form-control" type="date" required>
                            <label class="form-label">Member Since</label>
                        </div>
                    </div>



                </div>
            </div>
            <div class="card-footer text-end">
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
                    alert('Please upload an image with dimensions <= 2500x2500.');
                }
            });
        }
    });
</script>

<script>
    "use strict";
    (function() {
        flatpickr("#birthday", {
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
        flatpickr("#member_since", {
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
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
            if (!$('#birthday').val()) {
                return;
            }
            var file = $('#imageFile')[0].files[0]; // Assuming you are selecting the file input by ID
            var form = $('#employee_form')[0]; // Assuming you are selecting the form by ID
            var formData = new FormData(form);
            formData.append('imgFile', file);
            const btnSubmit = $('#btnSubmit');
            console.log(formData);
            btnSubmit.attr("disabled", true);
            loadingSpinner.show();
            $.ajax({
                url: '/addEmployee',
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