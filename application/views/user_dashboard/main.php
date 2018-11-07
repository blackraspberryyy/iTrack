<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>userdashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Home</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class = "row">
    <div class = "col-md-12">
        <div class="panel panel-primary box-shadow" style="padding: 4px 24px 16px 24px; margin-top:10px;">
            <div class="panel pane-body">
                <h2><?= $cms->announcement_title ?></h2>
                <?= $cms->announcement_text ?>
            </div>
        </div>
    </div>
</div>
<?php if($currentuser->user_access == "student"):?>
<div class="row">
    <div class="col-sm-12">
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
<?php endif;?>

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