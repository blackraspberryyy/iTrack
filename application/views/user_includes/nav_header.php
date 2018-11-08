<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>

        <!-- Template Custom CSS and FontAwesome CSS -->
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

        <!--Custom Font-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <!-- CUSTOM STYLE -->
        <link rel="stylesheet" href="<?= base_url()?>assets/custom/css/custom.css"/>
        <link rel="stylesheet" href="<?= base_url()?>assets/custom/css/spacing.min.css"/>

        <!-- JQuery and Bootsrap JS -->
        <script src="<?= base_url() ?>assets/lumino_template/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/bootstrap.min.js"></script>

        <!-- Datetime picker -->
        <link rel="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

        <!-- Gijgo WYSIWYG Editor -->
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.10/combined/css/gijgo.min.css"/>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.10/combined/js/gijgo.min.js "></script>
        
        <!-- Data Table -->
        <link rel = "stylesheet" href = "https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
        <script src = "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src = "https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.datatable').DataTable({ "order": [[ 0, "desc" ]] });
            });
        </script>

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/chart-data.js"></script>

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

            /* - SCROLLBAR -*/
            /* width */
            ::-webkit-scrollbar {
                width: 5px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }
            
            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: rgb(244,211,12); 
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: rgb(183, 158, 9); 
            }
            
        </style>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $('.preloader-background').delay(800).fadeOut('slow');
                $('.preloader-wrapper').delay(800).fadeOut();
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
            });
        </script>
        <?php include 'preloader.php' ?>
        <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span></button>
                    <a class="navbar-brand" href="<?= base_url() ?>UserDashboard"><img src = "<?= base_url() ?>images/logo.png"></a>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="<?= base_url() . $currentuser->user_picture ?>" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"><?= $currentuser->user_lastname ?>, <?= $currentuser->user_firstname ?> <?= substr($currentuser->user_middlename, 0, 1) == "" ? "" : substr($currentuser->user_middlename, 0, 1) . "."; ?></div>
                    <div class="profile-usertitle-status"><?= $currentuser->user_number ?></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="divider"></div>
            <ul class="nav menu">
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "UserDashboard") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>UserDashboard"><em class="fa fa-home">&nbsp;</em> Home</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "UserProfile") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>UserProfile"><em class="fa fa-user">&nbsp;</em> <?= ucfirst($currentuser->user_access) ?> Profile</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "UserViolation") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>UserViolation"><em class="fa fa-exclamation-triangle">&nbsp;</em> <?= ucfirst($currentuser->user_access) ?> Violation</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "UserIncidentReport") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>UserIncidentReport"><em class="fa fa-newspaper">&nbsp;</em> Incident Report</a></li>
                <?php if ($currentuser->user_access == "student"): ?>
                    <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "UserDusap") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>UserDusap"><em class="fa fa-clock">&nbsp;</em> DUSAP</a></li>
                <?php endif; ?>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "UserOffenseReport") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>UserOffenseReport"><em class="fa fa-exclamation-circle">&nbsp;</em> Offense Report</a></li>
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "StudentHandbook") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>StudentHandbook"><em class="fa fa-book-open">&nbsp;</em> Student Handbook</a></li>
                <!--<li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "usernotification") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>usernotification"><em class="fa fa-bell">&nbsp;</em> Notifications</a></li>-->
                <li class="<?= strpos(base_url(uri_string()), $this->config->base_url() . "Faq") !== FALSE ? "active" : ""; ?>"><a href="<?= base_url() ?>Faq"><em class="fa fa-lightbulb">&nbsp;</em> FAQ</a></li>
                <li><a href="<?= base_url() ?>Logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
            </ul>
        </div><!--/.sidebar-->

        <?php include_once (APPPATH . "views/show_error/show_error.php"); ?>
        <!-- Start of content -->
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">