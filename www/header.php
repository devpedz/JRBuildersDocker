<?php
error_reporting(0);
global $db;
global $session;
$userId = $session->get('user_data')['id'];
$userRole = $session->get('user_data')['role'];
$project_id = $session->get('project_id') ?? '';
$db->query("SELECT full_name,username,`role` FROM tbl_user WHERE id = $userId");
$user = json_decode(json_encode($db->single()));
if ($userRole != 'Superadmin') {
    $db->query("SELECT * FROM tbl_project WHERE id = $project_id");
    $project = json_decode(json_encode($db->single()));
}
?>
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
    <link rel="icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <title>J.R. BUILDERS - Information Management System</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../assets/css/font-awesome.css">
    <!-- ico-font-->

    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/prism.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/selectize.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/intltelinput.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/tagify.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/photoswipe.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->

    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/selectize.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/datatables.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive.css">
    <style>
        .page-wrapper .page-header .header-wrapper .nav-right>ul>li:last-child {
            background-color: transparent;
            border-radius: 0px;
            margin-right: 50px;
        }

        .page-wrapper .page-header .header-wrapper .nav-right .profile-dropdown {
            width: 200px;
        }
    </style>
</head>

<body>

    <div class="loader-wrapper">
        <div class="loader loader-1">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
            <div class="loader-inner-1"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <div class="page-header row">
            <div class="header-logo-wrapper col-auto">
                <div class="logo-wrapper"><a href="/home"><img class="img-fluid for-light"
                            src="../../assets/images/logo/logo.png" alt="" /><img class="img-fluid for-dark"
                            src="../../assets/images/logo/logo_light.png" alt="" /></a></div>
            </div>
            <div class="col-4 col-xl-4 page-title">
                <h4 class="f-w-700"><?= $project->project_title ?></h4>
                <nav>
                    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
                        <li class="breadcrumb-item f-w-400"><?= $project->project_address ?></li>
                    </ol>
                </nav>
            </div>
            <!-- Page Header Start-->
            <div class="header-wrapper col m-0">
                <div class="row">
                    <div class="header-logo-wrapper col-auto p-0">
                        <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                    src="../../assets/images/logo/logo.png" alt=""></a></div>
                        <div class="toggle-sidebar">
                            <svg class="stroke-icon sidebar-toggle status_toggle middle">
                                <use href="../../assets/svg/icon-sprite.svg#toggle-icon"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="nav-right col-xxl-8 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                        <ul class="nav-menus">
                            <li> <span class="header-search">
                                    <svg>
                                        <use href="../../assets/svg/icon-sprite.svg#search"></use>
                                    </svg></span></li>


                            <li>
                                <div class="mode">
                                    <svg>
                                        <use href="../../assets/svg/icon-sprite.svg#moon"></use>
                                    </svg>
                                </div>
                            </li>

                            <li class="profile-nav onhover-dropdown px-0 py-0">
                                <div class="d-flex profile-media align-items-center"><img class="img-30"
                                        src="../../assets/images/dashboard/user.png" alt="">
                                    <div class="flex-grow-1"><span><?= $user->full_name ?></span>
                                        <p class="mb-0 font-outfit"><?= $user->role ?><i class="fa fa-angle-down"></i></p>
                                    </div>
                                </div>
                                <ul class="profile-dropdown onhover-show-div">
                                    <li><a href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal_account"><i data-feather="user"></i><span>Account
                                            </span></a></li>
                                    <li><a href="/biometrics"><i
                                                class="icofont icofont-finger-print"></i><span>&nbsp;&nbsp;Biometrics</span></a>
                                    </li>
                                    <li><a href="/change-project"><i
                                                class="icofont icofont-exchange"></i><span>&nbsp;&nbsp;Change
                                                Project</span></a></li>
                                    <li><a href="/logout"><i data-feather="log-out"> </i><span>Log
                                                Out</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <script class="result-template" type="text/x-handlebars-template">
                        <div class="ProfileCard u-cf">                        
              <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
              <div class="ProfileCard-details">
              <div class="ProfileCard-realName">{{name}}</div>
              </div>
              </div>
            </script>
                    <script class="empty-template"
                        type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
                </div>
            </div>
            <!-- Page Header Ends                              -->
        </div>

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg">
                <div>
                    <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                src="../../assets/images/logo/logo_light.png" alt=""></a>
                        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                        <div class="toggle-sidebar">
                            <svg class="stroke-icon sidebar-toggle status_toggle middle">
                                <use href="../../assets/svg/icon-sprite.svg#toggle-icon"></use>
                            </svg>
                            <svg class="fill-icon sidebar-toggle status_toggle middle">
                                <use href="../../assets/svg/icon-sprite.svg#fill-toggle-icon"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                                src="../../assets/images/logo/logo-icon.png" alt=""></a></div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                            src="../../assets/images/logo/logo-icon.png" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                            aria-hidden="true"></i></div>
                                </li>
                                <li class="pin-title sidebar-main-title">
                                    <div>
                                        <h6>Pinned</h6>
                                    </div>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6 class="lan-81">menu</h6>
                                    </div>
                                </li>

                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
                                    <a class="sidebar-link sidebar-title link-nav" href="/home">
                                        <svg class="stroke-icon">
                                            <use href="../../assets/svg/icon-sprite.svg#stroke-home"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="../../assets/svg/icon-sprite.svg#fill-home"></use>
                                        </svg><span>Home</span></a>
                                </li>
                                <?php if ($userRole == 'Superadmin'): ?>

                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
                                        <a class="sidebar-link sidebar-title link-nav" href="/manage-projects">
                                            <i data-feather="map" class="text-white"></i><span>Projects</span></a>
                                    </li>
                                <?php endif; ?>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        class="sidebar-link sidebar-title" href="javascript:void(0)">
                                        <i data-feather="users" class="text-white"></i><span>Employees</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="/employees">List</a></li>
                                        <!-- <li><a href="/positions">Positions</a></li> -->
                                        <li><a href="/cash-advance">Cash Advance</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
                                    <a class="sidebar-link sidebar-title link-nav" href="/attendance">
                                        <i data-feather="calendar" class="text-white"></i><span>Attendance</span></a>
                                </li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        class="sidebar-link sidebar-title" href="javascript:void(0)">
                                        <i data-feather="dollar-sign" class="text-white"></i><span>Expenses</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="/expenses/list">List</a></li>
                                        <li><a href="/expenses/category">Category</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        class="sidebar-link sidebar-title" href="javascript:void(0)">
                                        <i data-feather="box" class="text-white"></i><span>Inventory</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="/inventory">List</a></li>
                                        <li><a href="/types">Type</a></li>
                                    </ul>
                                </li>

                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        class="sidebar-link sidebar-title" href="javascript:void(0)">
                                        <i data-feather="clipboard" class="text-white"></i><span>Reports</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="/report-expenses">Expenses</a></li>
                                        <li><a href="/report-payroll">Payroll</a></li>
                                    </ul>
                                </li>
                                <?php if ($userRole == 'Superadmin'): ?>
                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
                                        <a class="sidebar-link sidebar-title link-nav" href="/users">
                                            <i data-feather="user" class="text-white"></i><span>Users</span></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>
            </div>