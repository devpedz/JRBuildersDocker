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
    <title>J.R. Builders</title>
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
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
    <style>
        .loading-spinner {
            display: none;
            color: white;
            /* Loading spinner color */
        }
    </style>
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="login-main">
                            <div class="col-md-12 text-center">
                                <img class="img-fluid" src="../assets/images/logo.png" alt="logo" width="250">
                            </div>
                            <div id="status"></div>
                            <form id="loginForm" class="theme-form row g-3 needs-validation custom-input" novalidate="">
                                <div class="text-center">
                                    <h4>Sign in to account</h4>
                                    <p>Enter your username & password to login</p>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input id="username" class="form-control" type="text" name="username" required=""
                                        placeholder="Username">
                                    <div class="invalid-tooltip">Invalid username.</div>

                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input id="password" minlength="8" class="form-control" type="password"
                                            name="login[password]" required="" placeholder="*********">
                                        <div class="show-hide"><span class="show"> </span></div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <!-- <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Remember password</label>
                                    </div><a class="link" href="forget-password.html">Forgot password?</a> -->
                                    <div class="text-end mt-3">
                                        <button id="btnLogin" class="btn btn-primary btn-block w-100" type="submit">Sign
                                            in<span class="loading-spinner"><i
                                                    class="spinner-border spinner-border-sm"></i></span>
                                        </button>
                                        <button id="btnBiometrics" class="mt-3 btn btn-success btn-block w-100"
                                            type="button"
                                            onclick="window.location.assign('/biometrics')">Attendance for Employee</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
        <!-- Plugins JS start-->
        <!-- calendar js-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="../assets/js/notify/bootstrap-notify.min.js"></script>
        <script src="../assets/js/form-validation-custom.js"></script>
        <script src="../assets/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <!-- Plugin used-->
    </div>
</body>
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
</script>
<script>
    function showSuccess(message) {
        $('#status').html(`<div class="alert txt-success border-success outline-2x alert-dismissible fade show" role="alert">
                                <i data-feather="thumbs-up"></i>
                                <p>${message}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
    }

    function showError(message) {
        $('#status').html(`<div class="alert txt-danger border-danger outline-2x alert-dismissible fade show" role="alert">
                                <i data-feather="alert-triangle"></i>
                                <p>${message}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
    }
</script>
<script>
    $(document).ready(function() {
        var loadingSpinner = $('.loading-spinner');
        loadingSpinner.hide();
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            if (this.checkValidity()) {
                const btnLogin = $('#btnLogin');
                const formData = $(this).serialize();
                btnLogin.attr("disabled", true);
                loadingSpinner.show();
                (async () => {
                    try {
                        const result = await $.ajax({
                            url: '/login',
                            method: 'POST',
                            data: formData,
                            dataType: 'json',
                        });
                        if (result.success) {
                            window.location.reload();
                        } else {
                            showError(result.message)
                        }
                        btnLogin.attr("disabled", false);
                        loadingSpinner.hide();

                        // Handle the result here
                    } catch (error) {
                        console.error('Error:', error);
                    }
                })();
            }
        });
    });
</script>


</html>