<style>
    .dropdown-menu li{
        cursor: pointer;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>

<script>
    $(document).ready(function(){
        // if ($(this).find(":selected").attr("data-type") == "other") {
        //     $("#classification_other").show();
        //     $("#nature").prop("disabled", false);
        // } else {
        //     $("#classification_other").hide();
        //     $("#nature").prop("disabled", true);
        // }


        // $('#classification').change(function () {
        //     if ($(this).find(":selected").attr("data-type") == "other") {
        //         //Creation of new violation
        //         $("#nature").prop("disabled", false);
        //         $("#classification_other").show();
        //     } else {
        //         //Existing Violation
        //         $("#classification_other").hide();
        //         $("#nature").prop("disabled", true);
        //         $("#nature").val($(this).find(":selected").attr("data-type"));
        //     }
        // });

        $('.datetimepicker').datetimepicker({
            maxDate: moment()
        }).on('dp.show', function () {
            $('#datetimepicker').data("DateTimePicker").maxDate(moment());
        });

    });
</script>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>UserDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Incident Report</li>
    </ol>
</div><!--/.row breadcrumb-->
<div class="row">
    <div class="col-sm-12">
        <h1>Select Student/Teacher</h1>
        <?php if (empty($allUsers)) : ?>
        <br>
        <i class="fa fa-exclamation-triangle fa-3x text-danger" style="display:flex; justify-content:center;"></i>
        <h2 class="text-center">There is no Student/Teacher yet.</h2>

        <?php else : ?>
            <div class="row" style="padding:10px;">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control" name = "firstname" id = "firstname" placeholder="Search by Firstname" >
                </div>
            </div>
            <div class="row" style="display:flex; justify-content:space-evenly;">
                <div class="col-sm-3">
                    <center>
                        <label>Select Role of a Person</label>
                    </center>
                    <select class="form-control" id="filter_access">
                        <option selected value = "nofilter">All</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <center>
                        <label>Select Course of a Person</label>
                    </center>
                    <select class="form-control" id="filter_course">
                        <option selected value = "nofilter">All</option>
                        <?php foreach ($courses as $course) : ?>
                            <option value = "<?= $course->user_course; ?>"><?= $course->user_course; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>  
            <br>
            <?php foreach ($allUsers as $user) : ?>
                <div class="col-sm-3 user-panel">
                    <div class="thumbnail">
                        <img src="<?= base_url().$user->user_picture; ?>"/>
                        <div class="caption">
                            <p><?= $user->user_number; ?></p>
                            <p><span class="user_firstname" value="<?= $user->user_firstname; ?>"><?= $user->user_firstname; ?> </span><span><?= $user->user_lastname; ?></span></p>
                            <p><span class="user_course" value="<?= $user->user_course; ?>"><?= $user->user_course; ?></span></p>
                            <p><span class="user_access" value="<?= $user->user_access; ?>"><?= ucfirst($user->user_access); ?></span></p>
                            <hr>
                            <p><a href="#" data-toggle="modal" data-target="#select_<?= $user->user_id; ?>" title="Select the <?= $user->user_access == 'student' ? 'Student' : 'Teacher'; ?>" class="pull-right"><i class="fa fa-paper-plane fa-lg"></i></a></p>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- SELECT MODAL -->
                <div class="modal fade text-left" id="select_<?= $user->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="detailsTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action = "<?= base_url(); ?>UserIncidentReport/add_incident_report_exec/<?= $user->user_number; ?>" method="POST" autocomplete="off">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">FINALIZE A REPORT</h3>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-xs-12">
                                                <div class = "row">
                                                    <div class = "col-sm-12">
                                                        <span>Classification of Offense/Violation</span>
                                                        <select id = "classification" name = "classification" class = "form-control">
                                                            <option disabled="disabled" style = "background:#ddd;">-- Major --</option>
                                                            <?php
                                                            foreach ($major_violations as $violation) {
                                                                ?>
                                                                <option value = "<?= $violation->violation_id; ?>" data-type = "<?= $violation->violation_type; ?>" title = "<?= ucfirst($violation->violation_name); ?>" <?= set_select('classification', $violation->violation_id); ?>><?= ucfirst($violation->violation_name); ?></option>    
                                                                <?php
                                                            }
                                                            ?>
                                                            <!-- <option disabled="disabled" style = "background:#ddd;">-- New Violation --</option> -->

                                                            <!-- <option value="0" data-type = "other" title = "Other Violation" <?= set_select('classification', '0'); ?>>Other Violation</option> -->
                                                        </select>

                                                    </div>
                                                    <!-- <div class = "col-sm-4">
                                                        <span class="control-label">Nature of Violation</span>
                                                        <select id = "nature" name = "nature" class = "form-control">
                                                            <option value="major" <?= set_select('nature', 'major'); ?>>Major</option>
                                                            <option value="minor" <?= set_select('nature', 'minor'); ?>>Minor</option>
                                                        </select>
                                                    </div> -->
                                                </div>
                                                <br>
                                                <div class = "row">
                                                    <div class = "col-sm-6 <?= !empty(form_error('date_time')) ? 'has-error' : ''; ?>">
                                                        <span class="control-label" id="date_time">Date &AMP; Time</span>
                                                        <input type="text" class="form-control datetimepicker" name = "date_time" placeholder="Type Here" aria-describedby="date_time" value = "<?= set_value('date_time'); ?>">
                                                        <small><?= form_error('date_time'); ?></small>
                                                    </div>
                                                    <div class = "col-sm-6 <?= !empty(form_error('place')) ? 'has-error' : ''; ?>">
                                                        <span class="control-label">Place of the Offense Committed</span>
                                                        <input type="text" class="form-control" name = "place" placeholder="Type Here" value = "<?= set_value('place'); ?>">
                                                        <small><?= form_error('place'); ?></small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class = "col-xs-3 col-xs-offset-2 <?= !empty(form_error('user_age')) ? 'has-error' : ''; ?>">
                                                        <br/>
                                                        <span class="control-label">Age</span><br/>
                                                        <input type="text" maxlength="3" onkeypress = 'return keypresshandler(event)' class="form-control" name = "user_age" id = "user_age" placeholder="Age" value = "<?= set_value('user_age'); ?>">
                                                        <small><?= form_error('user_age'); ?></small>
                                                    </div>
                                                    <div class = "col-xs-5 <?= !empty(form_error('user_section_year')) ? 'has-error' : ''; ?>">
                                                        <br/>
                                                        <span class="control-label">Section/Year</span><br/>
                                                        <input type="text" class="form-control" name = "user_section_year" id = "user_section_year" placeholder="Type Here" value = "<?= set_value('user_section_year'); ?>">
                                                        <small><?= form_error('user_section_year'); ?></small>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class = "col-xs-8 col-xs-offset-2 <?= !empty(form_error('message')) ? 'has-error' : ''; ?>">
                                                        <br/>
                                                        <span class="control-label">Message</span><br/>
                                                        <textarea class="form-control" rows ="5" name = "message" style = "resize: none;" placeholder="Write a message. . ."><?= set_value('message'); ?></textarea>
                                                        <small><?= form_error('message'); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                         <!-- END SELECT MODAL -->
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#firstname").bind("keyup", function(e) {
        var search_word = $(this).val();
        $.ajax({
            "method": "POST",
            "url": '<?= base_url(); ?>' + "UserIncidentReport/search_user/<?= $title; ?>",
            "dataType": "JSON",
            "data": {
                'search_word': search_word
            },
            success: function (res) {
                /*
                    * ========= res.success CODES =========*
                    * 1 - NO STRINGS.......SHOW ALL users
                    * 2 - NO MATCH FOUND...SHOW NONE
                    * 3 - MATCH FOUND......SHOW RESULTS
                    * ====================================*
                    */
                switch(res.success){
                    case 1:{

                        $(".user-panel").show();
                        break;
                    }
                    case 2:{
                        $(".user-panel").hide();
                        alert("NO RESULT FOUND");
                        break;
                    }
                    case 3:{
                        var user_firstnames = [];
                        $.each(res.users, function( index, value ) {
                            user_firstnames.push(value.user_firstname);
                        });
                        $(".user-panel").hide();
                        $(".user-panel").filter(function(){
                            return user_firstnames.includes($(".user_firstname", this).attr("value"));
                        }).show();
                        break;
                    }
                    default:{
                        $(".user-panel").show();
                        break;
                    }
                }
            },
            error: function(res){
                console.error("Reload Your Browser");
            }
        });
    });

    $("#filter_access").on("change", function () {
            var filter = $(this).val();
            $.ajax({
                "method": "POST",
                "url": '<?= base_url(); ?>' + "UserIncidentReport/filter_access",
                "dataType": "JSON",
                "data": {
                    'filter': filter
                },
                success: function (res) {

                    switch (res.success) {
                        case 1:
                        {
                            $(".user-panel").show();
                            break;
                        }
                        case 2:
                        {
                            $(".user-panel").hide();
                            alert("NO RESULT FOUND");
                            break;
                        }
                        case 3:
                        {
                            var alluser_acess = [];
                            $.each(res.users, function (index, value) {
                                alluser_acess.push(value.user_access);
                            });
                            $(".user-panel").hide();
                            $(".user-panel").filter(
                                    function () {
                                        return alluser_acess.includes($(".user_access", this).attr("value"));
                                    }).show();
                            break;
                        }
                        default:
                        {
                            $(".user-panel").show();
                            break;
                        }
                    }
                },
                error: function (res) {
                    console.error("Reload Your Browser");
                }
            });
        });

         $("#filter_course").on("change", function () {
            var filter = $(this).val();
            $.ajax({
                "method": "POST",
                "url": '<?= base_url(); ?>' + "UserIncidentReport/filter_course",
                "dataType": "JSON",
                "data": {
                    'filter': filter
                },
                success: function (res) {

                    switch (res.success) {
                        case 1:
                        {
                            $(".user-panel").show();
                            break;
                        }
                        case 2:
                        {
                            $(".user-panel").hide();
                            break;
                        }
                        case 3:
                        {
                            var alluser_course = [];
                            $.each(res.users, function (index, value) {
                                alluser_course.push(value.user_course);
                            });
                            $(".user-panel").hide();
                            $(".user-panel").filter(
                                    function () {
                                        return alluser_course.includes($(".user_course", this).attr("value"));
                                    }).show();
                            break;
                        }
                        default:
                        {
                            $(".user-panel").show();
                            break;
                        }
                    }
                },
                error: function (res) {
                    console.error("Reload Your Browser");
                }
            });
        });
});
</script>