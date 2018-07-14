<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <link href="<?= base_url() ?>assets/lumino_template/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <link href="<?= base_url() ?>assets/lumino_template/css/datepicker3.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/lumino_template/css/styles.css" rel="stylesheet">

        <!-- FAVICON COMPATIBILITY -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url() ?>images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>images/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?= base_url() ?>images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= base_url() ?>images/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <script src="<?= base_url() ?>assets/lumino_template/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/bootstrap.min.js"></script>
        <!--Custom Font-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <style>
            /* - CUSTOM STYLE - */
            .navbar-header img {
                max-height: 100%;
                width: auto;
            }
            .navbar-custom{
                background:rgb(244,211,12);
                background: linear-gradient(135deg, rgb(244,211,12) 50%, rgba(0,114,54,1) 50%);
            }

        </style>


    </head>
    <body>

        <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span></button>
                    <a class="navbar-brand" href="<?= base_url() ?>userdashboard"><img src = "<?= base_url() ?>images/logo.png"></a>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="<?= base_url() . $currentuser->user_picture ?>" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"><?= $currentuser->user_lastname ?>, <?= $currentuser->user_firstname . " " . substr($currentuser->user_middlename, 0, 1) . "." ?> </div>
                    <div class="profile-usertitle-status"><?= $currentuser->user_number ?></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="divider"></div>
            <ul class="nav menu">
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "userdashboard") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>userdashboard"><em class="fa fa-home">&nbsp;</em> Home</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "userprofile") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>userprofile"><em class="fa fa-user">&nbsp;</em> <?= ucfirst($currentuser->user_access) ?> Profile</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "userviolation") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>userviolation"><em class="fa fa-exclamation-triangle">&nbsp;</em> <?= ucfirst($currentuser->user_access) ?> Violation</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "userincidentreport") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>userincidentreport"><em class="fa fa-newspaper">&nbsp;</em> Incident Report</a></li>
                <li class="parent">
                    <a data-toggle="collapse" href="#dussap">
                        <em class="fa fa-calendar-alt">&nbsp;</em> DUSSAP <span data-toggle="collapse" href="#dussap" class="icon pull-right"><em class="fa fa-plus"></em></span>
                    </a>
                    <ul class="children collapse" id="dussap">
                        <li>
                            <a class="" href="#">
                                <span class="fa fa-arrow-right">&nbsp;</span> Forms
                            </a>
                        </li>
                        <li>
                            <a class="" href="#">
                                <span class="fa fa-arrow-right">&nbsp;</span> Attendance
                            </a>
                        </li>
                        <li>
                            <a class="" href="#">
                                <span class="fa fa-arrow-right">&nbsp;</span> Time Sheet
                            </a>
                        </li>
                        <li>
                            <a class="" href="#">
                                <span class="fa fa-arrow-right">&nbsp;</span> Departments
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "useroffensereport") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>useroffensereport"><em class="fa fa-exclamation-circle">&nbsp;</em> Offense Report</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "studenthandbook") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>studenthandbook"><em class="fa fa-book-open">&nbsp;</em> Student Handbook</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "usernotification") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>usernotification"><em class="fa fa-bell">&nbsp;</em> Notifications</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "faq") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>faq"><em class="fa fa-lightbulb">&nbsp;</em> FAQ</a></li>
                <li><a href="<?= base_url() ?>logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
            </ul>
        </div><!--/.sidebar-->

        <?php include_once (APPPATH . "views/show_error/show_error.php"); ?>
        <!-- Start of content -->
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">