<?php
function get_data($id){
    $ci = & get_instance();
    $month_stats = $ci->AdminIncidentReport_model->getIncidentReport(array('u.user_id' => $id));
    $month_count = array();
    $count = array(
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0,
        '6' => 0,
        '7' => 0,
        '8' => 0,
        '9' => 0,
        '10' => 0,
        '11' => 0,
        '12' => 0,
    );
    if(!empty($month_stats)){  
        foreach ($month_stats as $mo) {
            $month = date("n", $mo->incident_report_added_at);
            if ($month == 1) {
                $count['1'] += 1;
            } else if ($month == 2) {
                $count['2'] += 1;
            } else if ($month == 3) {
                $count['3'] += 1;
            } else if ($month == 4) {
                $count['4'] += 1;
            } else if ($month == 5) {
                $count['5'] += 1;
            } else if ($month == 6) {
                $count['6'] += 1;
            } else if ($month == 7) {
                $count['7'] += 1;
            } else if ($month == 8) {
                $count['8'] += 1;
            } else if ($month == 9) {
                $count['9'] += 1;
            } else if ($month == 10) {
                $count['10'] += 1;
            } else if ($month == 11) {
                $count['11'] += 1;
            } else if ($month == 12) {
                $count['12'] += 1;
            }
        }
    }

    $loop = 0;
    foreach($count as $c){
        if($loop == (count($count) - 1)){
            //LAST ITERATION
            echo $c;
        }else{
            echo $c.', ';
        }
        $loop += 1;
    }
}
?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>admindashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Student Profile</li>
    </ol>
</div><!--/.row breadcrumb-->
<div class="row">
    <div class="col-xs-12">
        <h1><?= $cms->student_profile_title?></h1>
        <h5><?= $cms->student_profile_text?></h5>
        <br/>
    </div>
    <div class="col-sm-10 col-sm-offset-1"  style="margin-bottom:32px;">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-search"></i>
            </span>
            <input onkeypress = 'return keypresshandler(event)' maxlength="9" type="text" class="form-control" name = "user_number" id = "user_number" placeholder="Search by Student Number" >
        </div>
    </div>
    <div id="result_bank">
    <?php foreach($students as $student):?>
        <div class="student-panel">
            <span class ="d-none student_id" value = "<?= $student->user_id ?>"></span>
            <a href="" data-toggle="modal" data-target="#modal_<?= $student->user_id?>">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-primary elevate">
                        <div class="panel-body panel-padding">
                            <?= $student->user_number?>
                            <div>
                                <?=$student->user_firstname . " " . ($student->user_middlename == "" ? "" : substr($student->user_middlename, 0, 1).". "). $student->user_lastname?>
                            </div>
                        </div>
                        <div class="panel-body">
                            <img class="panel-img" src="<?= base_url().$student->user_picture?>"/>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="modal_<?= $student->user_id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><i class = "far fa-user-circle"></i> Profile</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <center>
                                        <img src="<?= base_url().$student->user_picture?>" class="img-responsive img-circle elevate" width="150">
                                    </center>
                                </div>
                            </div>
                            <table class="custom-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Student Number</strong></td>
                                        <td><?=$student->user_number?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Student Name</strong></td>
                                        <td><?=$student->user_firstname . " " . ($student->user_middlename == "" ? "" : $student->user_middlename)." ". $student->user_lastname?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Program</strong></td>
                                        <td><?=$student->user_course?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="max-height:300px; margin-top:24px;">
                                <canvas id="violationChart_<?= $student->user_id?>"></canvas>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var month_label = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var ctx = document.getElementById('violationChart_<?= $student->user_id?>').getContext('2d');
                var steps = 3;
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: month_label,
                        datasets: [{
                            label: "Incident Report/s Count",
                            backgroundColor: 'rgba(0, 114, 54, 0.5)',
                            borderColor: 'rgba(0, 114, 54, 1)',
                            data: [<?= get_data($student->user_id)?>],
                        }]
                    },
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
                });    
            </script>
        </div>
    <?php endforeach;?>
    </div>
</div>

<style>
    .panel .panel-body{
        padding:0;
    }
    .panel .panel-body.panel-padding{
        padding:16px;
    }
    .panel .panel-body .panel-img{
        width:100%;
        max-height:auto;
    }
    .elevate{
        box-shadow:2px 2px 10px #ddd;
    }
    .elevate:hover{
        -ms-transform: scale(1.05); /* IE 9 */
        -webkit-transform: scale(1.05); /* Safari */
        transform:scale(1.05);
    }
    table.custom-table{
        margin:24px auto auto auto;
    }
    table.custom-table td{
        padding:8px;
        width:50%;
    }
    table.custom-table td:first-child{
        border-right:2px solid #ddd;
        text-align:right;
    }
</style>


<script>
function keypresshandler(event) {
    var charCode = event.keyCode;
    //Non-numeric character range
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
}
</script>
<script>
$(document).ready(function(){
    $("#user_number").bind("keyup", function(e) {
        var search_word = $(this).val();
        $.ajax({
            "method": "POST",
            "url": '<?= base_url() ?>' + "adminviolations/search_student",
            "dataType": "JSON",
            "data": {
                'search_word': search_word
            },
            success: function (res) {
                /*
                    * ========= res.success CODES =========*
                    * 1 - NO STRINGS.......SHOW ALL STUDENTS
                    * 2 - NO MATCH FOUND...SHOW NONE
                    * 3 - MATCH FOUND......SHOW RESULTS
                    * ====================================*
                    */
                console.log(res);
                switch(res.success){
                    case 1:{
                        $(".student-panel").show();
                        break;
                    }
                    case 2:{
                        $(".student-panel").hide();
                        break;
                    }
                    case 3:{
                        var student_ids = [];
                        $.each(res.students, function( index, value ) {
                            student_ids.push(value.user_id);
                        });
                        $(".student-panel").hide();
                        $(".student-panel").filter(function(){
                            return student_ids.includes($(".student_id", this).attr("value"));
                        }).show();
                        break;
                    }
                    default:{
                        $(".student-panel").show();
                        break;
                    }
                }
            },
            error: function(res){
                console.error("Reload Your Browser");
            }
        });
    });
});
</script>