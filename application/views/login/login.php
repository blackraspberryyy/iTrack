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

        <!--Custom Font-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <style>
            body{
                padding:0;
                margin:0;
                background:#fff;
                background: url('<?= base_url() ?>images/office.jpg') no-repeat;
                background-size:60% 100%;
            }
            .main_div{
                margin:0;
                padding:0;
            }
            .main{
                height:100%;
                width:100%;
                margin:0;
            }
            .yellow{
                background:rgba(244,211,12,0.9);
                height: 100vh;
            }
            .green{
                background:rgba(0,114,54,1);
                background:linear-gradient(190deg, rgba(0,114,54,1) 75%,rgba(244,211,12,0.9) 75%);
                height: 100vh;
            }
            #logo_placement{
                position:relative;
                top:30%;
                text-align:center;
            }
            #logo_placement img{
                width:100%;
            }
            #feu_tech_logo{
                text-align:right;
            }
            #feu_tech_logo img{
                margin-top:20px;
                margin-right:15px;
                width:70px;
            }
            #login{
                margin-top:130px;
            }
            #forgot_password:hover{
                text-decoration:underline;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid main_div">
            <?php include_once (APPPATH . "views/show_error/show_error.php"); ?>
            <div class="row main">
                <div class ="col-sm-7 yellow">
                    <div id = "logo_placement">
                        <img src = "<?= base_url() ?>images/login_logo.png"/>
                    </div>
                </div>
                <div class ="col-sm-5 green">
                    <div id = "feu_tech_logo">
                        <img src = "<?= base_url() ?>images/feutech_logo.png" />
                    </div>
                    <div class = "row" id = "login">
                        <div class ="col-xs-8 col-xs-offset-2">
                            <center>
                                <form action = "<?= base_url() ?>login/login_exec" method ="POST">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class = "fa fa-user" id="basic-addon1"></i></span>
                                        <input type="text" class="form-control" id="usernumber" name = "usernumber" placeholder="User Number" aria-describedby="basic-addon1" autocomplete="off" autofocus="true">
                                    </div>
                                    <br/>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class = "fa fa-lock" id="basic-addon2"></i></span>
                                        <input type="password" class="form-control" id="password" name = "password" placeholder="Password" aria-describedby="basic-addon2">
                                    </div>
                                    <br/>
                                    <button type="submit" class="btn btn-secondary">Login</button>
                                </form>
                                <hr/>
                                <div id = "subform"  style = "margin-top:20px;">
                                    <a href = "<?= base_url() ?>forgotpassword" style = "color:white;">Forgot Password?</a>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
        </div><!--/.main-->

        <script src="<?= base_url() ?>assets/lumino_template/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/chart.min.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/chart-data.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/easypiechart.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/easypiechart-data.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/bootstrap-datepicker.js"></script>
        <script src="<?= base_url() ?>assets/lumino_template/js/custom.js"></script>
    </body>
</html>