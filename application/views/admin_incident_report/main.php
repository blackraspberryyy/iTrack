<style>
    .dropdown-menu li{
        cursor: pointer;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>
<?php
function determineStatus($status){
    if($status == 0){
        echo '<span class = "badge badge-secondary">Finished</span>';
    }else{
        echo '<span class = "badge badge-danger" style = "background:#ff3232;">Active</span>';
    }
}?>
<script>
    $(function () { /* DOM ready */
        if ($(this).find(":selected").attr("data-type") == "other") {
            $("#classification_other").show();
            $("#nature").prop("disabled", false);
        } else {
            $("#classification_other").hide();
            $("#nature").prop("disabled", true);
        }


        $('#classification').change(function () {
            if ($(this).find(":selected").attr("data-type") == "other") {
                //Creation of new violation
                $("#nature").prop("disabled", false);
                $("#classification_other").show();
            } else {
                //Existing Violation
                $("#classification_other").hide();
                $("#nature").prop("disabled", true);
                $("#nature").val($(this).find(":selected").attr("data-type"));
            }
        });

        $('.datetimepicker').datetimepicker({
            maxDate: moment()
        }).on('dp.show', function () {
            $('#datetimepicker').data("DateTimePicker").maxDate(moment());
        });

    });
</script>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>admindashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Incident Report</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class = "row">
    <div class="col-xs-12 text-right">
        <br/>
        <button type ="button" class="btn btn-primary" data-toggle = "modal" data-target = "#add_incident_report"><i class="fa fa-plus" ></i> Add Incident Report</button>
    </div>
</div>

<div class = "row">
    <div class = "col-md-12">
        <h1><?= $cms->incident_report_title?></h1>
        <h5><?= $cms->incident_report_text?></h5>
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
                    <?php if($incident_reports):?>
                        <?php foreach ($incident_reports as $report): ?>
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
                                        <button type = "button" class="btn btn-primary" data-toggle="modal" data-target="#details_<?= sha1($report->incident_report_id)?>">Details</a>
                                        <button type = "button" class="btn btn-warning" data-toggle="modal" data-target="#edit_<?= sha1($report->incident_report_id)?>">Edit</a>
                                    </div>
                                </td>
                            </tr>

                            <!-- DETAILS MODAL -->
                            <div class="modal fade text-left" id="details_<?= sha1($report->incident_report_id)?>" tabindex="-1" role="dialog" aria-labelledby="detailsTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="detailsTitle">Details</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <center>
                                                        <img src="<?= base_url().$report->user_picture?>" class="img-responsive img-circle" width="150">
                                                        <h4><?= $report->user_firstname.' '.($report->user_middlename!='' ? $report->user_middlename:'').' '.$report->user_lastname?></h4>
                                                        <h5><?= ucfirst($report->user_access)?></h5>
                                                        <h6><?= determineStatus($report->incident_report_status)?></h6>
                                                        <a href="<?= base_url().'admindussap/view/'.$report->incident_report_id?>" class="btn btn-primary <?= $report->incident_report_status == 0 ? 'disabled': ''?>"><i class="fa fa-search"></i> See DUSSAP Attendance</a>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--END DETAILS MODAL-->

                            <!-- EDIT MODAL -->
                            <div class="modal fade text-left" id="edit_<?= sha1($report->incident_report_id)?>" tabindex="-1" role="dialog" aria-labelledby="editTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="editTitle">Edit</h3>
                                        </div>
                                        <div class="modal-body">
                                            EDIT Here
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD INCIDENT REPORT MODAL -->
<div class="modal fade" id="add_incident_report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action = "<?= base_url() ?>adminincidentreport/incident_report_exec" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Incident Report</h4>
                </div>
                <div class="modal-body">
                    <div class = "row">
                        <div class = "col-sm-8">
                            <div id = "classification_other" class="form-group <?= !empty(form_error("classification_other")) ? "has-error" : ""; ?>">
                                <small class="control-label">Name of Violation</small>
                                <input type = "text" name = "classification_other" class="form-control " placeholder = "Name of Violation" value = "<?= set_value("classification_other") ?>">
                                <small><?= form_error("classification_other") ?></small>
                                <br/>
                            </div>
                            <span>Classification of Offense/Violation</span>
                            <select id = "classification" name = "classification" class = "form-control">
                                <option disabled="disabled" style = "background:#ddd;">-- Major --</option>
                                <?php
                                foreach ($major_violations as $violation) {
                                    ?>
                                    <option value = "<?= $violation->violation_id ?>" data-type = "<?= $violation->violation_type ?>" title = "<?= ucfirst($violation->violation_name) ?>" <?= set_select('classification', $violation->violation_id); ?>><?= ucfirst($violation->violation_name) ?></option>    
                                    <?php
                                }
                                ?>
                                <option disabled="disabled" style = "background:#ddd;">-- New Violation --</option>

                                <option value="0" data-type = "other" title = "Other Violation" <?= set_select('classification', '0'); ?>>Other Violation</option>
                            </select>

                        </div>
                        <div class = "col-sm-4">
                            <span class="control-label">Nature of Violation</span>
                            <select id = "nature" name = "nature" class = "form-control">
                                <option value="major" <?= set_select('nature', 'major'); ?>>Major</option>
                                <option value="minor" <?= set_select('nature', 'minor'); ?>>Minor</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class = "row">
                        <div class = "col-sm-6 <?= !empty(form_error("date_time")) ? "has-error" : ""; ?>">
                            <span class="control-label" id="date_time">Date &AMP; Time</span>
                            <input type="text" class="form-control datetimepicker" name = "date_time" placeholder="Type Here" aria-describedby="date_time" value = "<?= set_value("date_time") ?>">
                            <small><?= form_error("date_time") ?></small>
                        </div>
                        <div class = "col-sm-6 <?= !empty(form_error("place")) ? "has-error" : ""; ?>">
                            <span class="control-label">Place of the Offense Committed</span>
                            <input type="text" class="form-control" name = "place" placeholder="Type Here" value = "<?= set_value("place") ?>">
                            <small><?= form_error("place") ?></small>
                        </div>
                    </div>
                    <br/>
                    <div class ="row">
                        <div class = "col-sm-8 col-sm-offset-2 <?= !empty(form_error("user_number")) ? "has-error" : ""; ?>" >
                            <span class="control-label">User Number</span><br/>
                            <input onkeypress = 'return keypresshandler(event)' maxlength="9" type="text" class="form-control autocomplete" name = "user_number" id = "user_number" placeholder="Type Here" data-toggle="dropdown" value = "<?= set_value("user_number") ?>" >
                            <ul class="dropdown-menu " role="menu" id = "user_number_menu" style="width:100%;"></ul>          
                            <small><?= form_error("user_number") ?></small>
                        </div>

                    </div>
                    <div class ="row">
                        <div class = "col-sm-8 col-sm-offset-2">
                            <br/>
                            <div class = "<?= !empty(form_error("user_lastname")) ? "has-error" : ""; ?>">
                                <span class="control-label">Lastname</span><br/>
                                <input type="text" class="form-control" name = "user_lastname" id = "user_lastname" placeholder="Lastname" readonly="" value = "<?= set_value("user_lastname") ?>">
                                <small><?= form_error("user_lastname") ?></small>
                                <br/>
                            </div>
                            <div class = "<?= !empty(form_error("user_firstname")) ? "has-error" : ""; ?>">
                                <span class="control-label">Firstname</span><br/>
                                <input type="text" class="form-control" name = "user_firstname" id = "user_firstname" placeholder="Firstname" readonly="" value = "<?= set_value("user_firstname") ?>">
                                <small><?= form_error("user_firstname") ?></small>
                                <br/>
                            </div>
                            <span class="control-label">Middlename</span><br/>
                            <input type="text" class="form-control" name = "user_middlename" id = "user_middlename" placeholder="Middlename" readonly="">
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-xs-4 col-xs-offset-2 <?= !empty(form_error("user_course")) ? "has-error" : ""; ?>">
                            <br/>
                            <span class="control-label">Course</span><br/>
                            <input type="text" class="form-control" name = "user_course" id = "user_course" placeholder="Course" readonly="" value = "<?= set_value("user_course") ?>">
                            <small><?= form_error("user_course") ?></small>
                        </div>
                        <div class = "col-xs-4 <?= !empty(form_error("user_access")) ? "has-error" : ""; ?>">
                            <br/>
                            <span class="control-label">User Access</span><br/>
                            <input type="text" class="form-control" name = "user_access" id = "user_access" placeholder="User Access" readonly="" value = "<?= set_value("user_access") ?>">
                            <small><?= form_error("user_access") ?></small>
                        </div>
                    </div>

                    <div class="row">
                        <div class = "col-xs-3 col-xs-offset-2 <?= !empty(form_error("user_age")) ? "has-error" : ""; ?>">
                            <br/>
                            <span class="control-label">Age</span><br/>
                            <input type="text" maxlength="3" onkeypress = 'return keypresshandler(event)' class="form-control" name = "user_age" id = "user_age" placeholder="Age" value = "<?= set_value("user_age") ?>">
                            <small><?= form_error("user_age") ?></small>
                        </div>
                        <div class = "col-xs-5 <?= !empty(form_error("user_section_year")) ? "has-error" : ""; ?>">
                            <br/>
                            <span class="control-label">Section/Year</span><br/>
                            <input type="text" class="form-control" name = "user_section_year" id = "user_section_year" placeholder="Type Here" value = "<?= set_value("user_section_year") ?>">
                            <small><?= form_error("user_section_year") ?></small>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-xs-8 col-xs-offset-2 <?= !empty(form_error("message")) ? "has-error" : ""; ?>">
                            <br/>
                            <span class="control-label">Message</span><br/>
                            <textarea class="form-control" rows ="5" name = "message" style = "resize: none;" placeholder="Write a message. . ."><?= set_value("message") ?></textarea>
                            <small><?= form_error("message") ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function keypresshandler(event) {
        var charCode = event.keyCode;
        //Non-numeric character range
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    }
</script>

<script type="text/javascript">
    window.onload = function () {

        $(document).on("focusin keyup", "#user_number.autocomplete", function () {
            $.ajax({
                "method": "POST",
                "url": '<?= base_url() ?>' + "adminincidentreport/search_user_number",
                "dataType": "JSON",
                "data": {
                    'id': $(".autocomplete").val()
                },
                success: function (res) {
                    $("#user_number_menu").empty();
                    if (res.length == 0) {
                        $("#user_number_menu").append("<li class = 'no-matches'><a>No match found</a></li>");
                    } else {
                        for (var i = 0; i < res.length; i++) {
                            $("#user_number_menu").append("<li title = '" + res[i].user_firstname + " " + res[i].user_lastname + "' data-firstname = '" + res[i].user_firstname + "' data-lastname = '" + res[i].user_lastname + "' data-middlename = '" + res[i].user_middlename + "' data-course = '" + res[i].user_course + "' data-access = '" + res[i].user_access + "'><a>" + res[i].user_number + "</a></li>");
                        }
                    }
                },
                error: function (res) {
                    console.log(res);
                }
            });
            // Cache useful selectors
            var $input = $(this);
            var $dropdown = $input.next("ul.dropdown-menu");

            // Create the no matches entry if it does not exists yet
            if (!$dropdown.data("containsNoMatchesEntry")) {
                $("input.autocomplete + ul.dropdown-menu").append(
                    '<li class="no-matches hidden"><a>No matches</a></li>'
                );
                $dropdown.data("containsNoMatchesEntry", true);
            }

            // Show only matching values
            $dropdown.find("li:not(.no-matches)").each(function (key, li) {
                var $li = $(li);
                $li[new RegExp($input.val(), "i").exec($li.text()) ? "removeClass" : "addClass"]("hidden");
            });

            // Show a specific entry if we have no matches
            $dropdown.find("li.no-matches")[$dropdown.find("li:not(.no-matches):not(.hidden)").length > 0 ? "addClass" : "removeClass"]("hidden");

        });

        $(document).on("focus click", "input.autocomplete + ul.dropdown-menu li", function (e) {
            // Prevent any action on the window location
            e.preventDefault();

            // Cache useful selectors
            $li = $(this);
            $input = $li.parent("ul").prev("input");
            $firstname = $("#user_firstname");
            $lastname = $("#user_lastname");
            $middlename = $("#user_middlename");
            $course = $("#user_course");
            $access = $("#user_access");

            // Update input text with selected entry
            if (!$li.is(".no-matches")) {
                $input.val($li.text());
                $firstname.val($li.data('firstname'));
                $lastname.val($li.data('lastname'));
                $middlename.val($li.data('middlename'));
                $course.val($li.data('course'));
                $access.val($li.data('access'));
            }
        });

    }

</script>
