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
    foreach($attendance as $att){
        array_push($labels, date('F d, Y', $att->attendance_created_at));
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
    foreach($attendance as $att){
        array_push($data, $att->attendance_hours_rendered);
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
        <li class="active">DUSSAP</li>
    </ol>
</div><!--/.row breadcrumb-->
<div class = "row">
    <div class = "col-md-12">
        <h1><?=$cms->dussap_title?></h1>
        <h5><?=$cms->dussap_text?></h5>
    </div>
</div>
<div class="row margin-top-lg">
    <div class="col-xs-12 col-sm-4 text-center">
        <div class="panel panel-primary">
            <div class="panel panel-heading">Attendance Progress</div>
            <div class="panel panel-body">
                <div class="second circle">
                    <strong></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 text-center">
        <div class="panel panel-primary">
            <div class="panel panel-heading">Student Profile</div>
            <div class="panel panel-body">
                <center>
                    <img src="<?= base_url().$incident_report->user_picture?>" class="img-responsive img-circle" width="150">
                    <h4><?= $incident_report->user_firstname.' '.($incident_report->user_middlename!='' ? $incident_report->user_middlename:'').' '.$incident_report->user_lastname?></h4>
                    <h5><?= ucfirst($incident_report->user_access)?></h5>
                    <h6><?= determineStatus($incident_report->incident_report_status)?></h6>
                </center>
            </div>
        </div>
    </div>
    <div class="col-xs-12 text-center">
        <div class="panel panel-secondary">
            <div class="panel panel-heading chart-header">Attendance Chart</div>
            <div class="panel panel-body chart-body">
                
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>
</div>
    
<script>

window.onload = function () {
    //Circle Progress Bar
    $('.second.circle').circleProgress({
        size:200,
        value: <?= $total_hours->hours_rendered/$incident_report->violation_hours?>,
        animation:{
            duration:3000,
            easing: "circleProgressEasing"
        },
        fill: { color: ["#037236"] }
    }).on('circle-animation-progress', function(event, progress) {
        $(this).find('strong').html((<?= $total_hours->hours_rendered?> * progress).toFixed(2).replace(/[.,]00$/, "") + '<i>&nbsp;/&nbsp;</i>' + <?= $incident_report->violation_hours?> + '<br/>hrs');
    });
    //Bar Chart
    var labels = [<?php get_labels($attendance)?>];
    var ctx = document.getElementById('attendanceChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Hours Rendered",
                backgroundColor: 'rgba(0, 114, 54, 0.5)',
                borderColor: 'rgba(0, 114, 54, 1)',
                data: [<?php get_data($attendance)?>]
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