<style>
    .dropdown-menu li{
        cursor: pointer;
    }

</style>

<script type="text/javascript">
    window.onload = function () {

        $(document).on("focus keyup", "#user_number.autocomplete", function () {
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

        $(document).on("click", "input.autocomplete + ul.dropdown-menu li", function (e) {
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
                $("#nature").prop("disabled", false);
                $("#classification_other").show();
            } else {
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
    <div class = "col-md-12 text-center">
        <h1>Incident Report</h1>
        <div class ="table-responsive">
            <table class="table table-striped datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Date &amp; Time</th>
                        <th>Violation</th>
                        <th>Reported By</th>
                        <th>Reported</th>
                        <th>Place</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incident_reports as $report): ?>
                        <tr>
                            <td><span class = "hidden"><?= $report->incident_report_datetime ?></span><?= date('F d, Y \a\t h:m A', $report->incident_report_datetime) ?></td>
                            <td><?= ucfirst($report->violation_name) ?></td>
                            <td>
                                <?php
                                if ($report->admin_id == "") {
                                    echo $report->student_reported_by_firstname . " " . ($report->student_reported_by_middlename == "" ? "" : substr($report->student_reported_by_middlename, 0, 1)) . ". " . $report->student_reported_by_lastname;
                                } else {
                                    echo $report->admin_firstname . " " . ($report->admin_middlename == "" ? "" : substr($report->admin_middlename, 0, 1)) . ". " . $report->admin_lastname;
                                }
                                ?>
                            </td>
                            <td><?= $report->user_firstname . " " . ($report->user_middlename == "" ? "" : substr($report->user_middlename, 0, 1)) . $report->user_lastname; ?></td>
                            <td><?= ucfirst($report->incident_report_place) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href = "<?= base_url()?>adminincidentreport/details/<?= $report->incident_report_id?>" class="btn btn-primary">Details</a>
                                    <a href = "<?= base_url()?>adminincidentreport/edit/<?= $report->incident_report_id?>" class="btn btn-warning">Edit</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
                                <?php
                                foreach ($violations as $violation) {
                                    ?>
                                    <option value = "<?= $violation->violation_id ?>" data-type = "<?= $violation->violation_type ?>" title = "<?= ucfirst($violation->violation_name) ?>" <?= set_select('classification', $violation->violation_id); ?>><?= ucfirst($violation->violation_name) ?></option>    
                                    <?php
                                }
                                ?>
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


