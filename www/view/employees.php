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
                            <h4>Employee List</h4>
                            <div><button class="btn btn-secondary" type="button"
                                    onclick="window.location.assign('/add-employee');">Add Employee</button></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" type="text" id="search" name="search" placeholder=""
                                        required="" oninput="loadEmployees()">
                                    <label class="form-label" for="search">Search name...</label>
                                </div>
                            </div>
                        </div>
                        <div id="tbl_employee">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade" id="deleteEmployee" tabindex="-1" role="dialog" aria-labelledby="deleteEmployee"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img src="../assets/images/gif/danger.gif" alt="error"></li>
                        </ul>
                        <h4 class="text-center pb-2">Warning</h4>
                        <p class="text-center">Are you sure you want to delete this employee? <br>This action cannot be
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

    var page = 1;
    var employeeId;

    function deleteEmployee(id) {
        employeeId = id;
    }
    // $(".select2").select2();
    function setPage(_page) {
        page = _page;
        loadEmployees();
    }

    $('.delete').click(function(e) {
        $.post("/deleteEmployee", {
                id: employeeId
            },
            function(data) {
                if (data.success) {
                    loadEmployees();
                    $('#deleteEmployee').modal('hide');
                }
            },
            "json"
        );
        e.preventDefault();

    });

    function re_enroll(id) {
        Swal.fire({
            title: "Fingerprint Re-enrollment",
            text: "Fingerprints are already set up. Do you want to re-enroll it?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.assign(`fingerprint-registration/${id}`);
            }
        });
        // swal.fire({
        //     title: "Fingerprint Re-enrollment",
        //     text: "Fingerprints are already set up. Do you want to re-enroll it?",
        //     icon: "warning",
        //     showCloseButton: true,
        //     showCancelButton: true,
        //     dangerMode: true,
        // }).then((enroll) => {
        //     if (enroll) {
        //         window.location.assign(`fingerprint-registration/${id}`);
        //     }
        // });

    }

    function loadEmployees() {
        const formData = {
            page: page,
            name: $('#search').val(),
        };
        $.post("/loadEmployees", formData,
            function(data) {
                $('#tbl_employee').html(data);
            },
            "text"
        );


    }
    loadEmployees();
</script>