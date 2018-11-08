<?php include_once (APPPATH . "views/show_error/show_error.php"); ?>
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>AdminDashboard">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">SMS</li>
        </ol>
    </div><!--/.row breadcrumb-->

    <div class = "row ">
        <div class="col-xs-12">
            <h1><?= $cms->sms_title?></h1>
            <h5><?= $cms->sms_text?></h5>
        </div>
    </div>

    <div class = "row">
        <div class = "col-xs-8 col-xs-offset-2">
            <form action ="<?= base_url() ?>Sms/send_Sms_exec" method="POST">
                <div class="input-group">
                    <span class="input-group-addon"><i class = "fa fa-phone" id="basic-addon1"></i> +63</span>
                    <input type="text" class="form-control" id="mobile" name = "mobile" placeholder="Mobile Number" aria-describedby="basic-addon1" autocomplete="off">
                </div>
                <small style = "text-align: left;">(e.g. +639XXXXXXXXX)</small>
                <br/>
                <br/>
                <textarea name = "message" id = "message" rows="5" class = "form-control" placeholder = "Message" style = "resize: none;"></textarea>
                <br/>
                <center>
                    <button type ="submit" name ="submit" class = "btn btn-primary "><i class = "fa fa-paper-plane"></i> Send SMS</button>
                </center>
            </form>
        </div>
    </div>
