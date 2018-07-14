<style>
    .dropdown-menu li{
        cursor: pointer;
    }

</style>

<script type="text/javascript">
    window.onload = function () {

        $(document).on("focus keyup", "#student_number.autocomplete", function () {
            $.ajax({
                "method": "POST",
                "url": '<?= base_url() ?>' + "adminincidentreport/search_student_number",
                "dataType": "JSON",
                "data": {
                    'id': $(".autocomplete").val()
                },
                success: function (res) {
                    $("#student_number_menu").empty();
                    if (res.length == 0) {
                        $("#student_number_menu").append("<li class = 'no-matches'><a>No match found</a></li>");
                    } else {
                        for (var i = 0; i < res.length; i++) {
                            $("#student_number_menu").append("<li data-firstname = '" + res[i].user_firstname + "' data-lastname = '" + res[i].user_lastname + "' data-middlename = '" + res[i].user_middlename + "'><a>" + res[i].user_number + "</a></li>");
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
            $firstname = $("#student_firstname");
            $lastname = $("#student_lastname");
            $middlename = $("#student_middlename");

            // Update input text with selected entry
            if (!$li.is(".no-matches")) {
                $input.val($li.text());
                $firstname.val($li.data('firstname'));
                $lastname.val($li.data('lastname'));
                $middlename.val($li.data('middlename'));
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
        })
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
    <div class = "col-md-12 text-center">
        <h1>Incident Report</h1>
    </div>
</div>

<form action = "<?= base_url() ?>adminincidentreport/incident_report_exec" method="POST">
    <div class ="row">
        <div class = "col-xs-8 col-sm-offset-2">
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
                    <input type="text" class="form-control" name = "place" placeholder="Type Here">
                    <small><?= form_error("place") ?></small>
                </div>
            </div>
            <br/>
            <div class ="row">
                <div class = "col-sm-8 col-sm-offset-2 <?= !empty(form_error("student_number")) ? "has-error" : ""; ?>" >
                    <span class="control-label">Student Number</span><br/>
                    <input onkeypress = 'return keypresshandler(event)' maxlength="9" type="text" class="form-control autocomplete" name = "student_number" id = "student_number" placeholder="Type Here" data-toggle="dropdown" value = "<?= set_value("student_number") ?>">
                    <ul class="dropdown-menu " role="menu" id = "student_number_menu" style="width:100%;"></ul>          
                    <small><?= form_error("student_number") ?></small>
                </div>

            </div>
            <div class ="row">
                <div class = "col-sm-8 col-sm-offset-2">
                    <br/>
                    <div class = "<?= !empty(form_error("student_lastname")) ? "has-error" : ""; ?>">
                        <span class="control-label">Lastname</span><br/>
                        <input type="text" class="form-control" name = "student_lastname" id = "student_lastname" placeholder="Lastname" readonly="" value = "<?= set_value("student_lastname") ?>">
                        <small><?= form_error("student_lastname") ?></small>
                        <br/>
                    </div>
                    <div class = "<?= !empty(form_error("student_firstname")) ? "has-error" : ""; ?>">
                        <span class="control-label">Firstname</span><br/>
                        <input type="text" class="form-control" name = "student_firstname" id = "student_firstname" placeholder="Firstname" readonly="" value = "<?= set_value("student_firstname") ?>">
                        <small><?= form_error("student_firstname") ?></small>
                        <br/>
                    </div>
                    <span class="control-label">Middlename</span><br/>
                    <input type="text" class="form-control" name = "student_middlename" id = "student_middlename" placeholder="Middlename" readonly="">
                </div>
            </div>
            <div class = "row">
                <div class = "col-xs-3 col-xs-offset-2 <?= !empty(form_error("student_age")) ? "has-error" : ""; ?>">
                    <br/>
                    <span class="control-label">Age</span><br/>
                    <input type="text" maxlength="3" onkeypress = 'return keypresshandler(event)' class="form-control" name = "student_age" id = "student_age" placeholder="Age" value = "<?= set_value("student_age") ?>">
                    <small><?= form_error("student_age") ?></small>
                </div>
                <div class = "col-xs-5 <?= !empty(form_error("student_course_section_year")) ? "has-error" : ""; ?>">
                    <br/>
                    <span class="control-label">Course/Section/Year</span><br/>
                    <input type="text" class="form-control" name = "student_course_section_year" id = "student_course_section_year" placeholder="Type Here" value = "<?= set_value("student_course_section_year") ?>">
                    <small><?= form_error("student_course_section_year") ?></small>
                </div>
            </div>
            <div class = "row">
                <div class = "col-xs-8 col-xs-offset-2 <?= !empty(form_error("message")) ? "has-error" : ""; ?>">
                    <br/>
                    <span class="control-label">Message</span><br/>
                    <textarea class="form-control" rows ="5" name = "message" style = "resize: none;" placeholder="Write a message. . ." value = "<?= set_value("message") ?>"></textarea>
                    <small><?= form_error("message") ?></small>
                    <br/>
                    <center>
                        <button type ="submit" class ="btn btn-primary">Submit</button>
                    </center>
                </div>
            </div>
        </div>
    </div>   
    <br/>
</form>

<script>
    function keypresshandler(event) {
        var charCode = event.keyCode;
        //Non-numeric character range
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    }
</script>


