
<?php
function determineStatus($status){
    if($status == 0){
        echo '<span class = "badge badge-secondary">Finished</span>';
    }else{
        echo '<span class = "badge badge-danger" style = "background:#ff3232;">Active</span>';
    }
}

function get_labels($attendance){
    $labels = array();
    if($attendance){
        foreach($attendance as $att){
            if($att->attendance_starttime == 0){
                array_push($labels, date('F d, Y', $att->attendance_created_at));
            }else{
                array_push($labels, date('F d, Y', $att->attendance_starttime));
            }
        }
    }

    $loop = 0;
    foreach($labels as $l){
        if($loop == (count($labels) - 1)){
            //LAST ITERATION
            echo '"'.$l.'"';
        }else{
            echo '"'.$l.'"'.', ';
        }
        $loop += 1;
    }
}

function get_data($attendance){
    $data = array();
    if($attendance){
        foreach($attendance as $att){
            array_push($data, $att->attendance_hours_rendered);
        }
    }

    $loop = 0;
    foreach($data as $d){
        if($loop == (count($data) - 1)){
            //LAST ITERATION
            echo $d;
        }else{
            echo $d.', ';
        }
        $loop += 1;
    }
}
?>
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
        <li class="active">DUSAP</li>
    </ol>
</div><!--/.row breadcrumb-->
<div class = "row">
    <div class = "col-md-12">
        <h1><?=$cms->dusap_title?></h1>
        <h5><?=$cms->dusap_text?></h5>
    </div>
</div>
<div class="row margin-top-lg">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel panel-heading text-center">Attendance Record</div>
            <div class="panel panel-body">
                <div class="text-right">
                    <?php if(!($total_hours->hours_rendered >= $incident_report->violation_hours)):?>
                        <button type = "button"  data-toggle="modal" data-target="#add_attendance" class="btn btn-primary margin-right-md"><i class="fa fa-plus"></i> Add Attendance Record</button>
                        <button type = "button"  data-toggle="modal" data-target="#finish_attendance" class="btn btn-secondary"><i class="fa fa-check"></i> Finish DUSAP Attendance</button>
                    <?php else:?>
                        <a href="<?=base_url().'adminoffensereport/view_exec/'.$incident_report->incident_report_id?>" class="btn btn-primary"><i class="fa fa-file-alt"></i> See Offense Report</a>
                    <?php endif;?>
                </div>
                <br/><br/><br/>
                <div class ="table-responsive">
                    <?php if($attendance):?>    
                    <table class="table table-striped datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Start Date &amp; Time</th>
                                <th>End Date &amp; Time</th>
                                <th>Hours Rendered</th>
                                <th>Department</th>
                                <th>Supervisor</th>
                                <?php if(!($total_hours->hours_rendered >= $incident_report->violation_hours)):?>
                                    <th>Action</th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($attendance as $a):?>
                            <script>
                                $(document).ready(function () {
                                    <?php if(validation_errors() && $_SESSION['error_modal'] == 'edit'):?>
                                        $('#edit_<?= sha1($a->attendance_id)?>').modal({
                                            show: 'true'
                                        })
                                    <?php elseif(validation_errors() && $_SESSION['error_modal'] == 'add'):?>
                                        $('#add_attendance').modal({
                                            show: 'true'
                                        })
                                    <?php endif;?>
                                });
                            </script>
                            <tr>
                                <td class="text-center">
                                    <?php if($a->attendance_starttime == 0):?>
                                        <span>-</span>
                                    <?php else:?>
                                        <span class = "hidden"><?= $a->attendance_starttime ?></span><?= date('m/d/Y h:iA', $a->attendance_starttime) ?>
                                    <?php endif;?>
                                </td>
                                <td class="text-center">
                                    <?php if($a->attendance_endtime == 0):?>
                                        <span>-</span>
                                    <?php else:?>
                                        <span class = "hidden"><?= $a->attendance_endtime ?></span><?= date('m/d/Y h:iA', $a->attendance_endtime) ?>
                                    <?php endif;?>
                                </td>
                                <td><?= $a->attendance_hours_rendered ?></td>
                                <td><?= $a->attendance_dept ?></td>
                                <td><?= $a->attendance_supervisor ?></td>
                                <?php if(!($total_hours->hours_rendered >= $incident_report->violation_hours)):?>
                                    <td>
                                        <button data-toggle="modal" data-target="#edit_<?= sha1($a->attendance_id)?>" type="button" class="btn btn-warning">Edit</button>
                                    </td>
                                <?php endif;?>
                            </tr>
                            <!-- EDIT ATTENDANCE MODAL -->
                            <div class="modal fade text-left" id="edit_<?= sha1($a->attendance_id)?>" tabindex="-1" role="dialog" aria-labelledby="editTitle" aria-hidden="true">
                                <form action="<?= base_url()?>admindusap/edit_attendance_exec/<?= $a->attendance_id?>" method="POST">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="editTitle">Edit Attendance</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name ="modal_type" value="edit"/>
                                                    <div class = "col-sm-6 <?= !empty(form_error("starttime")) ? "has-error" : ""; ?>">
                                                        <span class="control-label" id="starttime">Start Date &AMP; Time</span>
                                                        <input type="text" class="form-control datetimepicker" name = "starttime" placeholder="Type Here" aria-describedby="starttime" value = "<?= set_value("starttime", date('m/d/Y h:i A', $a->attendance_starttime))?>">
                                                        <small><?= form_error("starttime") ?></small>
                                                    </div>
                                                    <div class = "col-sm-6 <?= !empty(form_error("endtime")) ? "has-error" : ""; ?>">
                                                        <span class="control-label" id="endtime">End Date &AMP; Time</span>
                                                        <input type="text" class="form-control datetimepicker" name = "endtime" placeholder="Type Here" aria-describedby="endtime" value = "<?= set_value("endtime", date('m/d/Y h:i A', $a->attendance_endtime)) ?>">
                                                        <small><?= form_error("endtime") ?></small>
                                                    </div>
                                                    <div class="col-sm-8 col-sm-offset-2 col-xs-12 margin-top-md <?= !empty(form_error("department")) ? "has-error" : ""; ?>">
                                                        <span class="control-label" id="department">Department</span>
                                                        <input type="text" class="form-control" name = "department" placeholder="(e.g. Admissions)" aria-describedby="department" value = "<?= set_value("department", $a->attendance_dept) ?>">
                                                        <small><?= form_error("department") ?></small>
                                                    </div>
                                                    <div class="col-sm-8 col-sm-offset-2 col-xs-12 margin-top-md <?= !empty(form_error("supervisor")) ? "has-error" : ""; ?>">
                                                        <span class="control-label" id="supervisor">Supervisor</span>
                                                        <input type="text" class="form-control" name = "supervisor" placeholder="(e.g. John Doe)" aria-describedby="supervisor" value = "<?= set_value("supervisor", $a->attendance_supervisor) ?>">
                                                        <small><?= form_error("supervisor") ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!--END DETAILS MODAL-->
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <?php else:?>
                    <div class="margin-bottom-lg">
                        <center>
                            <h3>No attendance record yet</h3>
                        </center>
                    </div>
                    <?php endif;?>  
                </div>
            </div>
        </div>
        
    </div>
</div>
<div class="row margin-top-lg">
    <div class="col-xs-12 col-sm-5 col-md-4 text-center">
        <div class="panel panel-primary">
            <div class="panel panel-heading">Incident Report Information</div>
            <div class="panel panel-body">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <center>
                            <img src="<?= base_url().$incident_report->user_picture?>" class="img-responsive img-circle" width="150">
                            <h4><?= $incident_report->user_firstname.' '.($incident_report->user_middlename!='' ? $incident_report->user_middlename:'').' '.$incident_report->user_lastname?></h4>
                            <h5><?= ucfirst($incident_report->user_access)?></h5>
                            <h6><?= determineStatus($incident_report->incident_report_status)?></h6>
                        </center>
                    </div>
                    <div class="col-xs-6 margin-top-lg text-center">
                        <h5><strong>Reported By:</strong></h5>
                        <span><?php
                            if ($incident_report->reportedby_id != "") {
                                //if REPORTED_BY teacher, get user's name 
                                echo $incident_report->reportedby_firstname . " " . ($incident_report->reportedby_middlename == "" ? "" : substr($incident_report->reportedby_middlename, 0, 1).". "). $incident_report->reportedby_lastname;
                                echo " <small class = 'text-muted'><b>(".$incident_report->reportedby_access.")</b></small>";
                            } else {
                                //if REPORTED_BY admin, get admin's name
                                echo "Admin";
                            }
                        ?></span>
                        <br/>
                        <br/>
                        <h5><strong>Place</strong></h5>
                        <span><?= $incident_report->incident_report_place?></span>
                    </div>
                    <div class="col-xs-6  margin-top-lg  text-center">
                        <h5><strong>Violation</strong></h5>
                        <span><?= ucfirst($incident_report->violation_name)?></span>
                        <br/>
                        <br/>
                        <h5><strong>Time</strong></h5>
                        <span><?= date('F d, Y \a\t h:i A', $incident_report->incident_report_datetime)?></span>
                    </div>
                    <div class="col-xs-12 text-center">
                        <br/>
                        <h5><strong>Message</strong></h5>
                        <p><?= $incident_report->incident_report_message?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-7 col-md-8 text-center">
        <div class="panel panel-primary">
            <div class="panel panel-heading">Attendance Progress</div>
            <?php if($attendance):?>
            <div class="panel panel-body">
                <div class="second circle">
                    <strong></strong>
                </div>
                <br/><br/>
                <canvas id="attendanceChart"></canvas>
            </div>
            <?php else:?>
                <div class="margin-bottom-lg">
                    <center>
                        <h3>No attendance record yet</h3>
                    </center>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
<!-- ADD MODAL -->
<div class="modal fade text-left" id="add_attendance" tabindex="-1" role="dialog" aria-labelledby="addAttendanceTitle" aria-hidden="true">
    <form action="<?= base_url()?>admindusap/add_attendance_exec" method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="addAttendanceTitle">Add Attendance Record</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name ="modal_type" value="add"/>
                        <div class = "col-sm-6 <?= !empty(form_error("starttime")) ? "has-error" : ""; ?>">
                            <span class="control-label" id="starttime">Start Date &AMP; Time</span>
                            <input type="text" class="form-control datetimepicker" name = "starttime" placeholder="Type Here" aria-describedby="starttime" value = "<?= set_value("starttime")?>">
                            <small><?= form_error("starttime") ?></small>
                        </div>
                        <div class = "col-sm-6 <?= !empty(form_error("endtime")) ? "has-error" : ""; ?>">
                            <span class="control-label" id="endtime">End Date &AMP; Time</span>
                            <input type="text" class="form-control datetimepicker" name = "endtime" placeholder="Type Here" aria-describedby="endtime" value = "<?= set_value("endtime") ?>">
                            <small><?= form_error("endtime") ?></small>
                        </div>
                        <div class="col-sm-8 col-sm-offset-2 col-xs-12 margin-top-md <?= !empty(form_error("department")) ? "has-error" : ""; ?>">
                            <span class="control-label" id="department">Department</span>
                            <input type="text" class="form-control" name = "department" placeholder="(e.g. Admissions)" aria-describedby="department" value = "<?= set_value("department") ?>">
                            <small><?= form_error("department") ?></small>
                        </div>
                        <div class="col-sm-8 col-sm-offset-2 col-xs-12 margin-top-md <?= !empty(form_error("supervisor")) ? "has-error" : ""; ?>">
                            <span class="control-label" id="supervisor">Supervisor</span>
                            <input type="text" class="form-control" name = "supervisor" placeholder="(e.g. John Doe)" aria-describedby="supervisor" value = "<?= set_value("supervisor") ?>">
                            <small><?= form_error("supervisor") ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Record</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade text-left" id="finish_attendance" tabindex="-1" role="dialog" aria-labelledby="finishAttendanceTitle" aria-hidden="true">
    <form action="<?= base_url().'admindusap/finish_attendance_exec'?>" method="POST">
        <input type="hidden" value="<?=$total_hours->hours_rendered?>" name="hours_rendered"/>
        <input type="hidden" value="<?=$incident_report->violation_hours?>" name="violation_hours"/>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="finishAttendanceTitle">Are you sure you want to do this?</h3>
                </div>
                <div class="modal-body">
                    <span>Finishing the attendance will stop the attendance process of the student?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Proceed</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

window.onload = function () {
    //Circle Progress Bar
    $('.second.circle').circleProgress({
        size:160,
        value: <?= $total_hours->hours_rendered/$incident_report->violation_hours?>,
        animation:{
            duration:3000,
            easing: "circleProgressEasing"
        },
        fill: { color: ["#037236"] }
    }).on('circle-animation-progress', function(event, progress) {
        $(this).find('strong').html((<?= $total_hours->hours_rendered ? $total_hours->hours_rendered : 0?> * progress).toFixed(2).replace(/[.,]00$/, "") + '<i>&nbsp;/&nbsp;</i>' + <?= $incident_report->violation_hours?> + '<br/>hrs');
    });
    //Bar Chart
    var labels = [' ', <?php get_labels($attendance)?>];
    var ctx = document.getElementById('attendanceChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Hours Rendered",
                backgroundColor: 'rgba(0, 114, 54, 0.5)',
                borderColor: 'rgba(0, 114, 54, 1)',
                data: [0, <?php get_data($attendance)?>]
            }],
            options:{
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMax: 5,
                            min: 0,
                            stepSize: 1
                        }
                    }]
                }
            }
        }
    });
}
</script>