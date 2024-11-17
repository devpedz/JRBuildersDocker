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
    <title>J.R Builders - Information Management System</title>
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
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/animate.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
</head>
<style>
    .comingsoon-bgimg {
        background: rgb(0, 0, 0, 0)
    }


    @import url("https://fonts.googleapis.com/css?family=Roboto+Condensed:300");

    body {
        text-align: center;
        font-family: "Roboto Condensed", sans-serif;
        font-weight: 300;
        overflow: hidden;
    }

    .column,
    .colon {
        display: inline-block;
        vertical-align: top;
        font-size: 86px;
        line-height: 86px;
    }

    .column {
        transition: transform 300ms;
    }

    .colon {
        transition: transform 300ms;
        transform: translateY(calc(50vh - 43px));
    }

    .colon:after {
        content: ":";
    }

    .num {
        transition: opacity 500ms, text-shadow 100ms;
        opacity: 0.025;
    }

    .num.visible {
        opacity: 1;
        text-shadow: 1px 1px 0px #336699;
    }

    .num.close {
        opacity: 0.25;
    }

    .num.far {
        opacity: 0.15;
    }

    .num.distant {
        opacity: 0.11;
    }

    a.fixed-button {
        z-index: 99;
        width: 100px;
        position: absolute;
        bottom: 20px;
        /* Adjust this value to control the vertical position */
        right: 20px;
        /* Adjust this value to control the horizontal position */
        padding: 10px 20px;
        /* Optional: Adjust padding as per your button's content */
        font-size: 16px;
        /* Optional: Adjust font size */
    }

    div.fixed-date {
        z-index: 99;
        width: 400px;
        position: absolute;
        bottom: 20px;
        /* Adjust this value to control the vertical position */
        left: 20px;
        /* Adjust this value to control the horizontal position */
        padding: 10px 20px;
        /* Optional: Adjust padding as per your button's content */
        font-size: 40px;
        /* Optional: Adjust font size */
    }

    div.fixed-video {
        z-index: 99;
        width: 400px;
        position: absolute;
        bottom: 60px;
        /* Adjust this value to control the vertical position */
        left: 20px;
        /* Adjust this value to control the horizontal position */
        padding: 10px 20px;
        /* Optional: Adjust padding as per your button's content */
        font-size: 40px;
        /* Optional: Adjust font size */
    }

    div.fixed-video video {
        outline: none;
        border: none;
        width: 100%;
    }

    .page-wrapper {
        background: url(assets/images/official_logo.png);
        background-color: white;
        background-position: center;
        background-size: 45%;
        background-repeat: no-repeat;
    }

    #section2 {
        background-color: #fff;
        -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);
        box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 20px;
    }
</style>

<body>

    <div id="device" hidden>
        <div class="form-row mt-3">
            <div class="col mb-3 mb-md-0 text-center">
                <label for="enrollReaderSelect" class="my-text7 my-pri-color">Choose
                    Fingerprint
                    Reader</label>
                <select name="readerSelect" id="enrollReaderSelect" class="form-control" onclick="beginEnrollment()">
                    <option selected>Select Fingerprint Reader</option>
                </select>
            </div>
        </div>
    </div>
    <div class="fixed-video">
        <video muted="muted" autoplay loop="true" oncontextmenu="return false;">
            <source src="assets/video/fingerprint-scanning.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="fixed-date">

        <?= date('l, F j') ?>
    </div>
    <a class="fixed-button btn btn-dark" href="/attendance"><i class="fa fa-arrow-left"></i><br>Back</a>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <div class="modal fade" id="employee_error_modal" tabindex="-1" role="dialog"
            aria-labelledby="employee_error_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered bounceIn  animated" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="justify-items-center mb-3">
                                <!-- <img id="error_img" src="/res/svg/fingerprint_error.svg" alt="fingerprint_error"
                                    class="rounded-circle me-3" width="80" height="80"> -->
                                <video id="fingerprint-error" muted="muted" oncontextmenu="return false;">
                                    <source src="assets/video/fingerprint-error.webm" type="video/webm">
                                    Your browser does not support the video tag.
                                </video>
                                <h2>Failed to verify</h2>
                                <p>
                                    Please ensure your fingerprint is correctly placed and try again. If the issue
                                    persists, consider cleaning your device's fingerprint sensor or contact support for
                                    assistance.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="employee_modal" tabindex="-1" role="dialog" aria-labelledby="employee_modal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered bounceIn  animated" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="col-md-5" id="section1">
                                    <div class="align-items-center mb-3 mt-5">
                                        <video id="fingerprint-success" muted="muted" oncontextmenu="return false;">
                                            <source src="assets/video/fingerprint-success.webm" type="video/webm">
                                            Your browser does not support the video tag.
                                        </video>
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" width="140"
                                            height="140">
                                            <path
                                                d="M39.548828 7C37.636968 7.023654 35.761158 7.1988235 33.929688 7.5136719 A 1.0001 1.0001 0 1 0 34.267578 9.484375C35.996107 9.1872234 37.768078 9.022346 39.574219 9L39.841797 9C49.230683 9 57.925506 12.736603 64.376953 19.539062 A 1.0002374 1.0002374 0 1 0 65.828125 18.162109C59.009572 10.97257 49.762911 7 39.841797 7L39.556641 7L39.548828 7 z M 26.1875 9.859375 A 1.0001 1.0001 0 1 0 26.1875 11.859375 A 1.0001 1.0001 0 1 0 26.1875 9.859375 z M 23.166016 11.371094L22.365234 11.771484L22.207031 12.654297L22.818359 13.308594L23.166016 13.371094L23.966797 12.96875L24.125 12.085938L23.511719 11.431641L23.166016 11.371094 z M 39.611328 12C33.779973 12.07232 28.318753 13.781591 23.675781 16.681641 A 1.0001 1.0001 0 1 0 24.736328 18.376953C29.081356 15.663002 34.180074 14.067676 39.636719 14L39.841797 14C42.413739 14 44.918693 14.32723 47.318359 14.962891 A 1.0001 1.0001 0 1 0 47.832031 13.03125C45.263698 12.35091 42.583855 12 39.841797 12L39.617188 12L39.611328 12 z M 20.28125 13.130859L19.480469 13.533203L19.322266 14.414062L19.933594 15.068359L20.28125 15.130859L21.082031 14.730469L21.240234 13.847656L20.628906 13.193359L20.28125 13.130859 z M 52.517578 14.794922L51.716797 15.197266L51.558594 16.078125L52.171875 16.732422L52.517578 16.794922L53.318359 16.394531L53.476562 15.511719L52.865234 14.857422L52.517578 14.794922 z M 17.589844 15.177734 A 1.0001 1.0001 0 1 0 17.589844 17.177734 A 1.0001 1.0001 0 1 0 17.589844 15.177734 z M 56.009766 16.740234L55.208984 17.140625L55.050781 18.023438L55.664062 18.677734L56.009766 18.740234L56.810547 18.337891L56.96875 17.457031L56.357422 16.802734L56.009766 16.740234 z M 39.673828 17C28.025562 17.144537 18.16483 25.060033 15.035156 35.755859 A 1.0003133 1.0003133 0 1 0 16.955078 36.318359C19.840874 26.456 28.940211 19.13608 39.693359 19C43.578109 18.97308 47.296376 19.849947 50.638672 21.552734 A 1.0001 1.0001 0 1 0 51.546875 19.771484C47.917171 17.922272 43.874938 16.970924 39.679688 17L39.677734 17L39.673828 17 z M 59.207031 19.138672L58.40625 19.539062L58.248047 20.421875L58.861328 21.076172L59.207031 21.138672L60.007812 20.736328L60.166016 19.855469L59.554688 19.199219L59.207031 19.138672 z M 62.056641 21.939453L61.255859 22.341797L61.097656 23.224609L61.708984 23.878906L62.056641 23.939453L62.857422 23.539062L63.015625 22.65625L62.404297 22.001953L62.056641 21.939453 z M 39.736328 22C34.52981 22.065055 29.764933 24.037391 26.125 27.248047 A 1.0001 1.0001 0 1 0 27.447266 28.748047C30.743332 25.840703 35.042284 24.058945 39.759766 24C51.015693 23.859396 59.671684 33.747017 58.933594 45.021484 A 1.000126 1.000126 0 0 0 60.929688 45.150391C61.739598 32.778858 52.176401 21.844604 39.736328 22 z M 16.035156 24.056641 A 1.0001 1.0001 0 0 0 15.197266 24.466797C11.310377 29.647937 9 36.075659 9 42.998047L9 45.998047 A 1.0001 1.0001 0 1 0 11 45.998047L11 42.998047C11 36.520435 13.159716 30.518828 16.798828 25.667969 A 1.0001 1.0001 0 0 0 16.035156 24.056641 z M 57.863281 24.720703 A 1.0001 1.0001 0 0 0 57.121094 26.417969C61.586968 31.12693 64.048669 37.470038 63.974609 43.988281 A 1.0001 1.0001 0 1 0 65.974609 44.011719C66.054549 36.975962 63.402391 30.134055 58.572266 25.041016 A 1.0001 1.0001 0 0 0 57.863281 24.720703 z M 64.525391 25.083984L63.722656 25.484375L63.566406 26.367188L64.177734 27.021484L64.525391 27.083984L65.326172 26.681641L65.484375 25.800781L64.871094 25.144531L64.525391 25.083984 z M 40 26.998047C31.17552 26.998047 24 34.173567 24 42.998047 A 1.0001 1.0001 0 1 0 26 42.998047C26 35.254527 32.25648 28.998047 40 28.998047C45.877801 28.998047 50.896209 32.611677 52.976562 37.730469 A 1.0001 1.0001 0 1 0 54.828125 36.976562C52.44848 31.121355 46.698199 26.998047 40 26.998047 z M 67.287109 30.087891 A 1.0001 1.0001 0 0 0 66.408203 31.501953C68.252236 35.692409 69.142793 40.301585 68.949219 44.958984 A 1.0001 1.0001 0 1 0 70.947266 45.041016C71.153691 40.074415 70.204248 35.164809 68.238281 30.697266 A 1.0001 1.0001 0 0 0 67.287109 30.087891 z M 22.701172 31.984375 A 1.0001 1.0001 0 0 0 21.818359 32.496094C20.027234 35.586992 19 39.177975 19 42.998047L19 45.998047 A 1.0001 1.0001 0 1 0 21 45.998047L21 42.998047C21 39.536119 21.927953 36.295149 23.548828 33.498047 A 1.0001 1.0001 0 0 0 22.701172 31.984375 z M 40 31.998047 A 1.0001 1.0001 0 1 0 40 33.998047C44.981375 33.998047 49 38.016672 49 42.998047C49 45.358244 48.43691 48.885955 46.861328 52.607422 A 1.0003209 1.0003209 0 0 0 48.703125 53.388672C50.387543 49.410139 51 45.66985 51 42.998047C51 36.935421 46.062625 31.998047 40 31.998047 z M 35 33.335938 A 1.0001 1.0001 0 1 0 35 35.335938 A 1.0001 1.0001 0 1 0 35 33.335938 z M 32.123047 35.847656L31.322266 36.25L31.164062 37.130859L31.777344 37.785156L32.123047 37.847656L32.925781 37.447266L33.082031 36.564453L32.470703 35.910156L32.123047 35.847656 z M 40 36.96875C36.705135 36.96875 34 39.638977 34 42.941406 A 1.0001 1.0001 0 1 0 36 42.941406C36 40.719836 37.772865 38.96875 40 38.96875C42.214812 38.96875 44 40.775478 44 42.996094C44 42.873146 43.9935 43.624338 43.847656 44.677734C43.701834 45.73113 43.417189 47.203754 42.867188 48.880859C41.767181 52.23507 39.615796 56.396715 35.376953 59.777344 A 1.0001 1.0001 0 1 0 36.623047 61.341797C41.230204 57.667425 43.579083 53.127945 44.767578 49.503906C45.361825 47.691887 45.668635 46.10526 45.828125 44.953125C45.987615 43.80099 46 43.198041 46 42.996094C46 39.69471 43.309188 36.96875 40 36.96875 z M 30.398438 39.25L29.595703 39.650391L29.439453 40.533203L30.050781 41.1875L30.398438 41.25L31.199219 40.847656L31.357422 39.966797L30.744141 39.3125L30.398438 39.25 z M 14.984375 41.984375 A 1.0001 1.0001 0 0 0 14 42.998047L14 45.998047 A 1.0001 1.0001 0 1 0 16 45.998047L16 42.998047 A 1.0001 1.0001 0 0 0 14.984375 41.984375 z M 39.984375 41.984375 A 1.0001 1.0001 0 0 0 39 42.998047C39 42.998047 39.000281 47.113934 36.251953 51.4375C33.503625 55.761066 28.075262 60.289868 16.708984 60.923828 A 1.0005731 1.0005731 0 1 0 16.820312 62.921875C28.690036 62.259835 34.878781 57.326652 37.939453 52.511719C41.000125 47.696785 41 42.998047 41 42.998047 A 1.0001 1.0001 0 0 0 39.984375 41.984375 z M 54.984375 41.984375 A 1.0001 1.0001 0 0 0 54 42.998047C54 44.230644 53.90625 45.523247 53.712891 46.855469 A 1.000726 1.000726 0 1 0 55.693359 47.144531C55.900004 45.720753 56 44.33145 56 42.998047 A 1.0001 1.0001 0 0 0 54.984375 41.984375 z M 29.871094 43.041016L29.070312 43.443359L28.912109 44.324219L29.523438 44.980469L29.871094 45.041016L30.671875 44.640625L30.830078 43.757812L30.216797 43.103516L29.871094 43.041016 z M 34.070312 45.986328 A 1.0001 1.0001 0 0 0 33.169922 46.626953C31.697908 50.302823 27.782193 55.42791 15.955078 55.955078 A 1.0001 1.0001 0 1 0 16.044922 57.953125C28.447811 57.400293 33.317357 51.639271 35.027344 47.369141 A 1.0001 1.0001 0 0 0 34.070312 45.986328 z M 28.208984 46.451172L27.408203 46.853516L27.25 47.736328L27.861328 48.390625L28.208984 48.451172L29.009766 48.050781L29.167969 47.167969L28.556641 46.513672L28.208984 46.451172 z M 64 48C55.178 48 48 55.178 48 64C48 72.822 55.178 80 64 80C72.822 80 80 72.822 80 64C80 55.178 72.822 48 64 48 z M 25.201172 48.798828L24.400391 49.201172L24.242188 50.082031L24.853516 50.736328L25.201172 50.798828L26.001953 50.396484L26.160156 49.515625L25.548828 48.861328L25.201172 48.798828 z M 64 50C71.72 50 78 56.28 78 64C78 71.72 71.72 78 64 78C56.28 78 50 71.72 50 64C50 56.28 56.28 50 64 50 z M 21.621094 50.158203L20.818359 50.560547L20.662109 51.441406L21.273438 52.095703L21.621094 52.158203L22.421875 51.757812L22.580078 50.875L21.966797 50.220703L21.621094 50.158203 z M 17.839844 50.814453L17.037109 51.216797L16.880859 52.097656L17.492188 52.751953L17.839844 52.814453L18.640625 52.414062L18.798828 51.53125L18.185547 50.876953L17.839844 50.814453 z M 14 50.998047 A 1.0001 1.0001 0 1 0 14 52.998047 A 1.0001 1.0001 0 1 0 14 50.998047 z M 46 54.998047 A 1 1 0 0 0 45 55.998047 A 1 1 0 0 0 46 56.998047 A 1 1 0 0 0 47 55.998047 A 1 1 0 0 0 46 54.998047 z M 44 57.998047 A 1 1 0 0 0 43 58.998047 A 1 1 0 0 0 44 59.998047 A 1 1 0 0 0 45 58.998047 A 1 1 0 0 0 44 57.998047 z M 70.779297 58.226562L61.285156 67.515625L57.638672 63.798828L56.210938 65.197266L61.255859 70.341797L72.177734 59.65625L70.779297 58.226562 z M 43.630859 61.630859C42.09819 61.701821 40.582176 62.249998 39.324219 63.277344L39.324219 63.275391C35.756685 66.186382 30.991592 68.612931 24.791016 69.931641 A 1.0001 1.0001 0 1 0 25.208984 71.886719C31.694408 70.507429 36.765424 67.94518 40.587891 64.826172C41.812614 63.825967 43.364412 63.450984 44.839844 63.691406 A 1.0001 1.0001 0 1 0 45.160156 61.71875C44.654514 61.636356 44.141749 61.607205 43.630859 61.630859 z M 30 63.115234 A 1.0001 1.0001 0 1 0 30 65.115234 A 1.0001 1.0001 0 1 0 30 63.115234 z M 26.757812 64.292969L25.957031 64.693359L25.798828 65.576172L26.410156 66.230469L26.757812 66.292969L27.558594 65.890625L27.716797 65.007812L27.105469 64.353516L26.757812 64.292969 z M 23.40625 65.109375L22.605469 65.509766L22.447266 66.392578L23.058594 67.046875L23.40625 67.109375L24.207031 66.707031L24.365234 65.824219L23.753906 65.169922L23.40625 65.109375 z M 20 65.664062 A 1.0001 1.0001 0 1 0 20 67.664062 A 1.0001 1.0001 0 1 0 20 65.664062 z M 43.990234 66.625C43.456381 66.6207 42.920747 66.79486 42.484375 67.150391C40.636749 68.658201 38.611982 69.980733 36.419922 71.113281 A 1.0002023 1.0002023 0 1 0 37.337891 72.890625C39.647831 71.697173 41.789673 70.299362 43.748047 68.701172C43.879303 68.594232 44.068311 68.591841 44.214844 68.712891 A 1.0002993 1.0002993 0 0 0 45.488281 67.169922C45.055548 66.812445 44.524088 66.629339 43.990234 66.625 z"
                                                fill="#29AD0F" />
                                        </svg> -->
                                    </div>
                                </div>
                                <div class="col-md-7" id="section">
                                    <div class="col-md-12">
                                        <img id="employee_photo" src="assets/images/user/7.jpg" alt="Employee Photo"
                                            class="rounded-circle me-3 mb-3" width="125" height="125">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="2" class="bg-dark">
                                                        <h5 id="employee_name" class="text-light f-w-700"></h5>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <h6>Employee ID</h6>
                                                    </th>
                                                    <th>
                                                        <h6>Position</h6>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td> <span id="employee_id" class="text-center"></span>

                                                    </td>
                                                    <td>
                                                        <span id="employee_position"></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <div class="col-12">
                                <div class="">
                                    <h1 id="timeStatus"></h1>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="">
                                    <h2 id="attendance_date"></h2>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="">
                                    <h3 id="attendance_time"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Body Start-->
        <div class="container-fluid p-0 m-0">
            <div class="row">
                <!-- <button id="success">TEST</button> -->
            </div>
            <div class="comingsoon comingsoon-bgimg">
                <div class="mb-3 row">
                    <div class="col-md-9">

                    </div>
                </div>
                <div class="comingsoon-inner text-center"><img src="" alt="">

                    <div class="column">
                        <div class="num">0</div>
                        <div class="num">1</div>
                        <div class="num">2</div>
                    </div>
                    <div class="column">
                        <div class="num">0</div>
                        <div class="num">1</div>
                        <div class="num">2</div>
                        <div class="num">3</div>
                        <div class="num">4</div>
                        <div class="num">5</div>
                        <div class="num">6</div>
                        <div class="num">7</div>
                        <div class="num">8</div>
                        <div class="num">9</div>
                    </div>
                    <div class="colon"></div>
                    <div class="column">
                        <div class="num">0</div>
                        <div class="num">1</div>
                        <div class="num">2</div>
                        <div class="num">3</div>
                        <div class="num">4</div>
                        <div class="num">5</div>
                    </div>
                    <div class="column">
                        <div class="num">0</div>
                        <div class="num">1</div>
                        <div class="num">2</div>
                        <div class="num">3</div>
                        <div class="num">4</div>
                        <div class="num">5</div>
                        <div class="num">6</div>
                        <div class="num">7</div>
                        <div class="num">8</div>
                        <div class="num">9</div>
                    </div>
                    <div class="colon"></div>
                    <div class="column">
                        <div class="num">0</div>
                        <div class="num">1</div>
                        <div class="num">2</div>
                        <div class="num">3</div>
                        <div class="num">4</div>
                        <div class="num">5</div>
                    </div>
                    <div class="column">
                        <div class="num">0</div>
                        <div class="num">1</div>
                        <div class="num">2</div>
                        <div class="num">3</div>
                        <div class="num">4</div>
                        <div class="num">5</div>
                        <div class="num">6</div>
                        <div class="num">7</div>
                        <div class="num">8</div>
                        <div class="num">9</div>
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
    <script src="../assets/js/jquery.blockUI.js"></script>
    <!-- Plugins JS start-->
    <!-- calendar js-->
    <script src="../assets/js/sweet-alert/sweetalert.min.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="/src/js/axios.min.js"></script>
    <script src="/src/js/api.js"></script>
    <script src="/src/js/es6-shim.js"></script>
    <script src="/src/js/websdk.client.bundle.min.js"></script>
    <script src="/src/js/fingerprint.sdk.min.js"></script>
    <script src="/src/js/biometrics.js?<?= uniqid() ?>"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        var employee_modal_timeout;
        var employee_error_modal_timeout;

        $('#employee_modal').on('shown.bs.modal', function() {
            $('.fixed-video').fadeOut();
            clearTimeout(employee_modal_timeout);
            var video = $('#fingerprint-success')[0];
            video.pause();
            video.currentTime = 0;
            video.loop = false; // Ensure loop is disabled
            video.play();
            employee_modal_timeout = setTimeout(function() {
                $('#employee_modal').modal('hide');
            }, 3000);
        }).on('hide.bs.modal', function() {
            $('.fixed-video').fadeIn();
            const title = "J.R Builders - Information Management System";
            $('title').html(title);
            clearTimeout(employee_modal_timeout);
        });

        $('#employee_error_modal').on('shown.bs.modal', function() {
            $('.fixed-video').fadeOut();
            clearTimeout(employee_error_modal_timeout);
            var video = $('#fingerprint-error')[0];
            // video.currentTime = 0;
            video.loop = false; // Ensure loop is disabled
            video.play();
            employee_error_modal_timeout = setTimeout(function() {
                $('#employee_error_modal').modal('hide');
            }, 1500);
        }).on('hide.bs.modal', function() {
            $('.fixed-video').fadeIn();
            const title = "J.R Builders - Information Management System";
            $('title').html(title);
            clearTimeout(employee_error_modal_timeout);
        });
        beginEnrollment();
        setTimeout(() => {
            beginCapture();
        }, 1000);
        let size = 86;
        let columns = Array.from(document.getElementsByClassName('column'));
        let d, c;
        let classList = ['visible', 'close', 'far', 'far', 'distant', 'distant'];
        let use24HourClock = true;

        function padClock(p, n) {
            return p + ('0' + n).slice(-2);
        }

        function getClock() {
            d = new Date();
            return [
                use24HourClock ? d.getHours() : d.getHours() % 12 || 12,
                d.getMinutes(),
                d.getSeconds()
            ].

            reduce(padClock, '');
        }

        function getClass(n, i2) {
            return classList.find((class_, classIndex) => Math.abs(n - i2) === classIndex) || '';
        }

        let loop = setInterval(() => {
            c = getClock();
            const _date = new Date().toLocaleString('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
            });
            $('.fixed-date').html(_date);

            columns.forEach((ele, i) => {
                let n = +c[i];
                let offset = -n * size;
                ele.style.transform = `translateY(calc(50vh + ${offset}px - ${size / 2}px))`;
                Array.from(ele.children).forEach((ele2, i2) => {
                    ele2.className = 'num ' + getClass(n, i2);
                });
            });
        }, 200 + Math.E * 10);
    </script>
    <!-- Plugin used-->
</body>

</html>