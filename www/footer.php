<!-- footer start-->
<?php
global $session;
global $db;
$userId = $session->get('user_data')['id'];
$db->query("SELECT full_name,username,`role` FROM tbl_user WHERE id = $userId");
$userData = $db->single();
?>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright d-flex flex-wrap align-items-center justify-content-between">
                <p class="mb-0 f-w-600">Copyright 2024 © J.R. Builders </p>
                <p class="mb-0 f-w-600">Hand crafted & made with
                    <svg class="footer-icon">
                        <use href="../../assets/svg/icon-sprite.svg#footer-heart"> </use>
                    </svg>
                </p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<div class="modal fade" id="modal_account" tabindex="-1" role="dialog" aria-labelledby="modal_account" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <h4 class="modal-header justify-content-center border-0 text-dark">Account Setting</h4>
                <div class="modal-body">
                    <form id="form_account" class="row g-3 needs-validation" novalidate="">
                        <div class="col-md-12">
                            <div class="mb-3 form-floating">
                                <input class="form-control" type="text" name="full_name" placeholder="Full name" required value="<?= $userData['full_name'] ?>">
                                <label class="form-label" for="full_name">Full name</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3 form-floating">
                                <input class="form-control" type="text" name="username" placeholder="Username" required value="<?= $userData['username'] ?>">
                                <label class="form-label" for="username">Username</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="password" name="current_password" placeholder="Current Password" required minlength="8">
                                    <label class="form-label" for="current_password">Current Password</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="password" name="new_password" placeholder="New Password" required minlength="8">
                                    <label class="form-label" for="new_password">New Password</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password" required minlength="8">
                                    <label class="form-label" for="confirm_password">Confirm Password</label>
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
<!-- latest jquery-->
<script src="../../assets/js/jquery.min.js"></script>
<!-- Bootstrap js-->
<script src="../../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- feather icon js-->
<script src="../../assets/js/icons/feather-icon/feather.min.js"></script>
<script src="../../assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- scrollbar js-->
<script src="../../assets/js/scrollbar/simplebar.js"></script>
<script src="../../assets/js/scrollbar/custom.js"></script>
<!-- Sidebar jquery-->
<script src="../../assets/js/config.js"></script>
<!-- Plugins JS start-->
<script src="../../assets/js/sidebar-menu.js"></script>
<script src="../../assets/js/sidebar-pin.js"></script>
<script src="../../assets/js/slick/slick.min.js"></script>
<script src="../../assets/js/slick/slick.js"></script>
<script src="../../assets/js/header-slick.js"></script>
<script src="../../assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="../../assets/js/cleave/cleave.min.js"></script>
<script src="../../assets/js/sweet-alert/sweetalert.min.js"></script>
<script src="../../assets/js/select2/tagify.js"></script>
<script src="../../assets/js/select2/tagify.polyfills.min.js"></script>
<script src="../../assets/js/select2/intltelinput.min.js"></script>
<script src="../../assets/js/selectize.min.js"></script>
<script src="../../assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="../../assets/js/photoswipe/photoswipe.min.js"></script>
<script src="../../assets/js/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="../../assets/js/flat-pickr/flatpickr.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script> -->
<script src="../../assets/js/cleave/cleave.min.js"></script>
<script src="../../assets/js/height-equal.js"></script>
<script src="/src/js/axios.min.js"></script>
<script src="/src/js/api.js"></script>
<!-- Plugins JS Ends-->

<script src="../../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/datatable/datatables/datatable.custom.js"></script>
<!-- Theme js-->
<script src="../../assets/js/script.js"></script>
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
    $('#form_account').submit(function(e) {
        if (this.checkValidity()) {
            $.post("/updateAccount", $(this).serialize(),
                function(data) {
                    if (data.success) {
                        $('#form_account').removeClass("was-validated");
                        $('#form_account')[0].reset();
                        $('#modal_account').modal('hide');
                        Swal.fire("Saved!", "", "success");
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
<!-- <script src="../../assets/js/theme-customizer/customizer.js"></script> -->
</body>

</html>