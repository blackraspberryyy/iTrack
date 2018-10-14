<style>
    .image-cropper {
        width: 180px;
        height: 180px;
        overflow: hidden;
        border-radius: 50%;
        margin:20px auto;
        box-shadow: 0px 0px 10px gray;
    }

    .image-cropper img {
        display: inline;
        margin: 0 auto;
        height: 100%;
        width: auto;
    }
    .form-control:read-only { 
        background-color: white;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    #img-upload{
        width: 100%;
    }
</style>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>userdashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Incident Report</li>
    </ol>
</div><!--/.row breadcrumb-->
<?php

function determineStatus($status) {
    if ($status == 0) {
        echo '<span class = "badge badge-secondary">Finished</span>';
    } else {
        echo '<span class = "badge badge-danger" style = "background:#ff3232;">Active</span>';
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <h1>Offense Report</h1>
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date &amp; Time</th>
                        <th>Status</th>
                        <th>Reported By</th>
                        <th>Violation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php if ($violations): ?>
                    <?php foreach ($violations as $violation): ?>
                        <tbody>
                            <tr>
                                <td><span class = "hidden"><?= $violation->incident_report_datetime ?></span><?= date('F d, Y \a\t h:i A', $violation->incident_report_datetime) ?></td>
                                <td><?= determineStatus($violation->incident_report_status); ?></td>
                                <td>
                                    <?php
                                    if ($violation->reportedby_id != "") {
                                        //if REPORTED_BY teacher, get user's name 
                                        echo $violation->reportedby_firstname . " " . ($violation->reportedby_middlename == "" ? "" : substr($violation->reportedby_middlename, 0, 1) . ". ") . $violation->reportedby_lastname;
                                        echo " <small class = 'text-muted'><b>(" . $violation->reportedby_access . ")</b></small>";
                                    } else {
                                        //if REPORTED_BY admin, get admin's name
                                        echo "Admin";
                                    }
                                    ?>
                                </td>

                                <td><?= ucfirst($violation->violation_name) ?></td>
                                <td>
                        <center>
                            <div class="btn-group-vertical" role="group">
                                <button type = "button" class="btn btn-primary" data-toggle="modal" data-target="#summary_<?= $violation->violation_id ?>">Summary</button>

                            </div>

                        </center>
                        </td>
                        </tr>

                        </tbody>
                    </table>
                    <!-- DETAILS MODAL -->
                    <div class="modal fade text-left" id="summary_<?= $violation->violation_id ?>" tabindex="-1" role="dialog" aria-labelledby="detailsTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="detailsTitle">Summary of the Offense Report</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                                <center>
                                                    <img src="<?= base_url() . $violation->user_picture ?>" class="img-responsive img-circle" width="150">
                                                    <h4><?= $violation->user_firstname . ' ' . ($violation->user_middlename != '' ? $violation->user_middlename : '') . ' ' . $violation->user_lastname ?></h4>
                                                    <h5><?= ucfirst($violation->user_access) ?></h5>
                                                    <h6><?= determineStatus($violation->incident_report_status) ?></h6>
                                                </center>
                                            <div class="table-responsive">

                                                <table class="table table-striped" width="100%" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Nature of the Violation committed</th>
                                                            <td><?= $violation->violation_name ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Date and Time</th>
                                                            <td><?= date('F d, Y \a\t h:i A', $violation->incident_report_datetime) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Classification of the Offense</th>
                                                            <td><?= $violation->violation_type ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Place of the Offense</th>
                                                            <td><?= $violation->incident_report_place ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Reported By</th>
                                                            <td><?= $violation->reportedby_lastname ?>, <?= $violation->reportedby_firstname ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Course/Section/Year</th>
                                                            <td>
                                                                <?php
                                                                if ($violation->reportedby_access == "student") {
                                                                    echo $violation->reportedby_course . "/" . $violation->incident_report_section_year;
                                                                } else {
                                                                    echo "Teacher";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Student/Teacher Number</th>
                                                            <td><?= $violation->reportedby_number ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Comments</th>
                                                            <td><?= $violation->incident_report_message ?></td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div> <!--END DETAILS MODAL-->
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
