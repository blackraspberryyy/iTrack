<?php
function determineStatus($status){
    if($status == 0){
        echo '<span class = "badge badge-secondary">Finished</span>';
    }else{
        echo '<span class = "badge badge-danger" style = "background:#ff3232;">Active</span>';
    }
}?>
<div class="row">
    <ol class="breadcrumb">
        <li>
            <a href="<?= base_url() ?>admindashboard">
                <em class="fa fa-home"></em>
            </a>
        </li>
        <li>
            <a href="<?= base_url() ?>adminincidentreport">Incident Report</a>
        </li>
        <li class="active">DUSSAP</li>
    </ol>
</div><!--/.row breadcrumb-->
<div class = "row">
    <div class = "col-md-12">
        <h1><?=$cms->dussap_title?></h1>
        <h5><?=$cms->dussap_text?></h5>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class ="table-responsive">
            <table class="table table-striped datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Date &amp; Time</th>
                        <th>Status</th>
                        <th>Student</th>
                        <th>Reported By</th>
                        <th>Violation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($active_incident_reports):?>
                        <?php foreach ($active_incident_reports as $report): ?>
                            <tr>
                                <td><span class = "hidden"><?= $report->incident_report_datetime ?></span><?= date('F d, Y \a\t h:m A', $report->incident_report_datetime) ?></td>
                                <td><?= determineStatus($report->incident_report_status);?></td>
                                <td><?= $report->user_firstname . " " . ($report->user_middlename == "" ? "" : substr($report->user_middlename, 0, 1) .". ").$report->user_lastname; ?></td>
                                <td>
                                    <?php
                                    if ($report->reportedby_id != "") {
                                        //if REPORTED_BY teacher, get user's name 
                                        echo $report->reportedby_firstname . " " . ($report->reportedby_middlename == "" ? "" : substr($report->reportedby_middlename, 0, 1).". "). $report->reportedby_lastname;
                                        echo " <small class = 'text-muted'><b>(".$report->reportedby_access.")</b></small>";
                                    } else {
                                        //if REPORTED_BY admin, get admin's name
                                        echo "Admin";
                                    }
                                    ?>
                                </td>
                                
                                <td><?= ucfirst($report->violation_name) ?></td>
                                <td>
                                    <div class="btn-group-vertical" role="group">
                                        <button type = "button" class="btn btn-primary" data-toggle="modal" data-target="#details_<?= sha1($report->incident_report_id)?>">View Attendance</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    




<!-- <div class="second circle" >
    <strong></strong>
</div> -->
    <script>
window.onload = function () {
    $('.second.circle').circleProgress({
        value: 1,
        animation:{
            duration:4000,
            easing: "circleProgressEasing"
        },
        fill: { color: ["#037236"] }
    }).on('circle-animation-progress', function(event, progress) {
        $(this).find('strong').html(Math.round(100 * progress) + '<i>%</i>');
    });
}
</script>