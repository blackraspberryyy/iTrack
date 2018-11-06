<style>
    .table > thead > tr > th {
        text-align: center;
    }
    .table > tbody > tr > td {
        text-align: center;
    }
</style>

<div class="row">
    <ol class="breadcrumb">
        <?php if ($this->session->userdata("useraccess") == "admin"): ?>
            <li><a href="<?= base_url() ?>admindashboard">
                <?php else: ?>
                    <li><a href="<?= base_url() ?>userdashboard">
                        <?php endif; ?>
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Dusap</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class="col-xs-12">
        <h1><?= $cms->dusap_title ?></h1>
        <h5><?= $cms->dusap_text ?></h5>
    </div>
</div>

<div class = "row">
    <div class = "col-md-12">
        <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-4'>
                <form method='POST' action='<?= base_url() ?>UserDusap/change_month_exec'>
                    <div class="form-group">
                        <select class="form-control" id="sel1" name="month">
                            <?php $counter = 0; ?>
                            <?php foreach ($months as $month): ?>
                                <?php $counter++ ?>
                                <option value='<?= $counter ?>'><?= $month ?></option>
                            <?php endforeach;
                            ?>
                        </select>
                        <center>
                            <div class="input-group-append" style='margin-top:10px;'>
                                <button class="btn btn-outline-secondary" type="submit">Submit</button>
                            </div>
                        </center>
                    </div>
                </form>
            </div>
            <div class='col-md-4'></div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                <center>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Check Summary</button>
                </center>
            </div>              
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Total Summary</h4>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="panel panel-primary">
                                    <div class="panel panel-heading">Attendance Progress</div>
                                    <?php if ($attendance): ?>
                                        <div class="panel panel-body">
                                            <div class="second circle">
                                                <strong></strong>
                                            </div>
                                            <br/><br/>
                                            <canvas id="attendanceChart"></canvas>
                                        </div>
                                    <?php else: ?>
                                        <div class="margin-bottom-lg">
                                            <center>
                                                <h3>No attendance record yet</h3>
                                            </center>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <center>
                    <h1><?= $currentMonth ?></h1>
                </center>
            </div>
            <div class='col-md-4'></div>   
        </div>
        <?php if (!empty($currentMonthAttendances)): ?>
            <div class ="table-responsive">
                <table class="table table-striped " style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currentMonthAttendances as $currentMonthAttendance): ?>   
                            <tr>    
                                <td><?= date('F d, Y / l', $currentMonthAttendance->attendance_starttime); ?></td>
                                <td><?= date('h:iA', $currentMonthAttendance->attendance_starttime); ?></td>
                                <td><?= date('h:iA', $currentMonthAttendance->attendance_endtime); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <center>
                <h1>You have no schedule for this month</h1>
            </center>
        <?php endif; ?>
    </div>
</div>

<?php

function get_labels($attendance) {
    $labels = array();
    if ($attendance) {
        foreach ($attendance as $att) {
            if ($att->attendance_starttime == 0) {
                array_push($labels, date('F d, Y', $att->attendance_created_at));
            } else {
                array_push($labels, date('F d, Y', $att->attendance_starttime));
            }
        }
    }

    $loop = 0;
    foreach ($labels as $l) {
        if ($loop == (count($labels) - 1)) {
            //LAST ITERATION
            echo '"' . $l . '"';
        } else {
            echo '"' . $l . '"' . ', ';
        }
        $loop += 1;
    }
}

function get_data($attendance) {
    $data = array();
    if ($attendance) {
        foreach ($attendance as $att) {
            array_push($data, $att->attendance_hours_rendered);
        }
    }

    $loop = 0;
    foreach ($data as $d) {
        if ($loop == (count($data) - 1)) {
            //LAST ITERATION
            echo $d;
        } else {
            echo $d . ', ';
        }
        $loop += 1;
    }
}
?>

<script>

    window.onload = function () {
        //Circle Progress Bar
        $('.second.circle').circleProgress({
            size: 160,
            value: <?= $total_hours->hours_rendered / $incident_report->violation_hours ?>,
            animation: {
                duration: 3000,
                easing: "circleProgressEasing"
            },
            fill: {color: ["#037236"]}
        }).on('circle-animation-progress', function (event, progress) {
            $(this).find('strong').html((<?= $total_hours->hours_rendered ? $total_hours->hours_rendered : 0 ?> * progress).toFixed(2).replace(/[.,]00$/, "") + '<i>&nbsp;/&nbsp;</i>' + <?= $incident_report->violation_hours ?> + '<br/>hrs');
        });
        //Bar Chart
        var labels = [' ', <?php get_labels($attendance) ?>];
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: "Hours Rendered",
                        backgroundColor: 'rgba(0, 114, 54, 0.5)',
                        borderColor: 'rgba(0, 114, 54, 1)',
                        data: [0, <?php get_data($attendance) ?>]
                    }],
                options: {
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