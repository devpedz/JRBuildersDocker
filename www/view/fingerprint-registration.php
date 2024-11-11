<?php include 'header.php';
global $db;
global $session;
$username = ($session->get('user_data')['username']);
$userId = ($session->get('user_data')['id']);
$db->query("SELECT * FROM view_employee WHERE id = $employee_id");
$employee = $db->single();
?>
<link rel="stylesheet" href="/src/css/custom.css">
<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="edit-profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Employee Information</h4>
                        <div class="card-options"><a class="card-options-collapse" href="#"
                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                    class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="profile-title">
                                <div class="d-flex"> <img class="img-100 rounded-circle" alt=""
                                        src="../uploads/<?= $employee['photo'] ?>">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1"><?= $employee['full_name'] ?></h4>
                                        <p><?= $employee['position'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th>Address:</th>
                                    <td><?= $employee['address'] ?></td>
                                </tr>
                                <tr>
                                    <th>Contact Number:</th>
                                    <td>091234567890</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td><?= $employee['gender'] ?></td>
                                </tr>
                                <tr>
                                    <th>Birthday:</th>
                                    <td><?= ($employee['birthday']) ? date('F d, Y', strtotime($employee['birthday'])) : 'N/A' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td><?= (new DateTime())->diff(new DateTime(($employee['birthday'])))->y; ?></td>
                                </tr>
                                <tr>
                                    <th>Rate/Day:</th>
                                    <td>₱<?= number_format($employee['rate_per_day'], 2) ?></td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td><?= $employee['gender'] ?></td>
                                </tr>
                                <tr>
                                    <th>Member Since:</th>
                                    <td><?= date('F j, Y', strtotime($employee['member_since'])) ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <form class="card" action="#" onsubmit="return false">

                    <div class="card-header">
                        <h4 class="card-title mb-0">Biometrics</h4>
                        <div class="card-options"><a class="card-options-collapse" href="#"
                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                    class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div id="enrollmentStatusField" class="text-center">
                                <!--Enrollment Status will be displayed Here-->
                            </div>
                            <div id="device" hidden>
                                <div class="form-row mt-4">
                                    <div class="col mb-md-0 text-center">
                                        <label for="userIDVerify" class="my-text7 my-pri-color m-0">Specify
                                            UserID</label>
                                        <input type="text" id="userIDVerify" class="form-control mt-1" required
                                            value="<?= $employee_id ?>">
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col mb-3 mb-md-0 text-center">
                                        <label for="enrollReaderSelect" class="my-text7 my-pri-color">Choose
                                            Fingerprint
                                            Reader</label>
                                        <select name="readerSelect" id="enrollReaderSelect" class="form-control"
                                            onclick="beginEnrollment()">
                                            <option selected>Select Fingerprint Reader</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mt-2">
                                    <div class="col mb-3 mb-md-0 text-center">
                                        <label for="userID" class="my-text7 my-pri-color">Specify UserID</label>
                                        <input id="userID" type="text" class="form-control" required
                                            value="<?= $employee_id ?>">
                                    </div>
                                </div>
                                <div class="form-row mt-3" id="userDetails">
                                    <!--this is where user details will be displayed-->
                                </div>
                            </div>
                            <div class="form-row mt-1">
                                <div class="col text-center">
                                    <h3 class="mb-3">Capture Primary Finger</h3>
                                </div>
                            </div>
                            <div id="indexFingers" class="d-flex justify-content-center">
                                <div id="indexfinger1" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                                <div id="indexfinger2" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                                <div id="indexfinger3" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                                <div id="indexfinger4" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                            </div>
                            <div class="form-row mt-1">
                                <div class="col text-center">
                                    <h3 class="mb-3">Capture Backup Finger</h3>
                                </div>
                            </div>
                            <div id="middleFingers" class="d-flex justify-content-center">
                                <div id="middleFinger1" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                                <div id="middleFinger2" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                                <div id="middleFinger3" class="col mb-3 mb-md-0 text-center">
                                    <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                                <div id="middleFinger4" class="col mb-3 mb-md-0 text-center" value="true">
                                    <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-dark" type="button"
                                        onclick="window.location.assign('/employees');">Back</button>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-warning" type="button" onclick="initialize();">Clear</button>
                                    <button class="btn btn-primary" type="submit"
                                        onclick="serverEnroll()">Enroll</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="/src/js/es6-shim.js"></script>
<script src="/src/js/websdk.client.bundle.min.js"></script>
<script src="/src/js/fingerprint.sdk.min.js"></script>
<script src="/src/js/custom.js?<?= uniqid() ?>"></script>
<script>
    initialize();

    function initialize() {
        clearCapture();

        beginEnrollment();
        setTimeout(() => {
            beginCapture();
        }, 1000);
    }
</script>