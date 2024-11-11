<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/src/css/bootstrap.css">
    <link rel="stylesheet" href="/src/css/custom.css">

    <title>Management Information System</title>

</head>

<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/src/js/jquery-3.5.0.min.js"></script>

    <script src="/src/js/bootstrap.bundle.js"></script>
    <script src="/src/js/axios.min.js"></script>
    <script src="/src/js/api.js"></script>
    <script src="/src/js/es6-shim.js"></script>
    <script src="/src/js/websdk.client.bundle.min.js"></script>
    <script src="/src/js/fingerprint.sdk.min.js"></script>
    <script src="/src/js/test.js?<?= uniqid() ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body{
            background-color: darkgray;
        }
    </style>
</body >

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModal1Label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModal1Label">Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Employee details -->
                <div class="text-center">
                    <img src="employee1.jpg" class="img-fluid rounded-circle mb-3" alt="Employee 1">
                    <h4>John Doe</h4>
                    <p>Position: Software Engineer</p>
                    <p>Department: Engineering</p>
                    <p>Email: john.doe@example.com</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="form-row mt-3" hidden>
    <div class="col mb-3 mb-md-0 text-center">
        <label for="enrollReaderSelect" class="my-text7 my-pri-color">Choose Fingerprint Reader</label>
        <select name="readerSelect" id="enrollReaderSelect" class="form-control" onclick="beginEnrollment()">
            <option selected>Select Fingerprint Reader</option>
        </select>
    </div>
</div>

<script>

</script>
<!-- <div class="form-row m-3 mt-md-5 justify-content-center">
    <div class="col-4">
        <button class="btn btn-primary btn-block my-sec-bg my-text-button py-1" type="submit"
            onclick="beginCapture()">Start Capture</button>
    </div>
    <div class="col-4">
        <button class="btn btn-primary btn-block my-sec-bg my-text-button py-1" type="submit"
            onclick="serverEnroll()">Enroll</button>
    </div>
    <div class="col-4">
        <button class="btn btn-secondary btn-outline-warning btn-block my-text-button py-1 border-0" type="button"
            onclick="clearCapture()">Clear</button>
    </div>
</div> -->
<script>
    // Function to get current time and format it
    function getCurrentTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        var ampm = hours >= 12 ? 'PM' : 'AM';
        return `${hours}:${minutes} ${ampm}`;
    }

    // Function to get current date and format it
    function getCurrentDate() {
        const now = new Date();
        const year = now.getFullYear();
        const month = (now.getMonth() + 1).toString().padStart(2, '0');
        const day = now.getDate().toString().padStart(2, '0');
        return `${month}/${day}/${year}`;
    }

    // Function to trigger SweetAlert when employee clocks in
    function clockInAlert(employeeName, imgUrl) {
        const currentTime = getCurrentTime();
        const currentDate = getCurrentDate();

        Swal.fire({
            icon: 'success',
            title: `${employeeName}`,
            html: `
      <p>Time: ${currentTime}</p>
      <p>Date: ${currentDate}</p>
    `,
            imageUrl: `${imgUrl}`, // Replace with actual image URL
            imageWidth: 200, // Width of the image in pixels
            imageHeight: 200, // Height of the image in pixels
            imageAlt: 'Employee Photo',
            showConfirmButton: false,
            timer: 5000 // Automatically close after 5 seconds
        });
    }
    // $('#employeeModal').modal('show');
    beginEnrollment();
    setTimeout(() => {
        beginCapture();
    }, 1000);
</script>

</html>