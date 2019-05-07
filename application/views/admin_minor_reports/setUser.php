<style>
	.dropdown-menu li{
		cursor: pointer;
	}
	.dropdown-menu{
		position:initial;
	}
	.table > tbody > tr > td {
		vertical-align: middle;
	}
</style>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>UserDashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li><a href="<?= base_url() ?>AdminMinorReports">Minor Reports</a></li>
        <li class="active">Set User</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class = "row">
		<br/>
    <form action="<?= base_url()?>AdminMinorReports/setUser_submit/<?= $minor_report->mr_id?>" method="POST">
      <div class = "col-md-12">
				<input type="hidden" name="user_id" id="user_id"/>
        <div class ="row">
          <div class = "col-sm-8 col-sm-offset-2 <?= !empty(form_error('user_number')) ? 'has-error' : ''; ?>" >
            <span class="control-label">User Number</span><br/>
            <input onkeypress = 'return keypresshandler(event)' maxlength="9" type="text" class="form-control" name = "user_number" id = "user_number" placeholder="Type Here" readonly value = "<?= set_value('user_number'); ?>" >          
            <small><?= form_error('user_number'); ?></small>
          </div>
        </div>
        <div class ="row">
          <div class = "col-sm-8 col-sm-offset-2">
            <br/>
            <div class = "<?= !empty(form_error('user_lastname')) ? 'has-error' : ''; ?>">
              <span class="control-label">Lastname</span><br/>
              <input type="text" class="form-control autocomplete2" name = "user_lastname" id = "user_lastname" placeholder="Lastname" data-toggle="dropdown" value="<?= set_value('user_lastname'); ?>">
              <ul class="dropdown-menu" role="menu" id = "user_lastname_menu" style="width:100%;"></ul>          
              <small><?= form_error('user_lastname'); ?></small>
              <br/>
            </div>
            <div class = "<?= !empty(form_error('user_firstname')) ? 'has-error' : ''; ?>">
              <span class="control-label">Firstname</span><br/>
              <input type="text" class="form-control" name = "user_firstname" id = "user_firstname" placeholder="Firstname" readonly="" value = "<?= set_value('user_firstname'); ?>">
              <small><?= form_error('user_firstname'); ?></small>
              <br/>
            </div>
            <span class="control-label">Middlename</span><br/>
            <input type="text" class="form-control" name = "user_middlename" id = "user_middlename" placeholder="Middlename" readonly="">
          </div>
        </div>
        <div class = "row">
          <div class = "col-xs-4 col-xs-offset-2 <?= !empty(form_error('user_course')) ? 'has-error' : ''; ?>">
            <br/>
            <span class="control-label">Course</span><br/>
            <input type="text" class="form-control" name = "user_course" id = "user_course" placeholder="Course" readonly="" value = "<?= set_value('user_course'); ?>">
            <small><?= form_error('user_course'); ?></small>
          </div>
          <div class = "col-xs-4 <?= !empty(form_error('user_access')) ? 'has-error' : ''; ?>">
            <br/>
            <span class="control-label">User Access</span><br/>
            <input type="text" class="form-control" name = "user_access" id = "user_access" placeholder="User Access" readonly="" value = "<?= set_value('user_access'); ?>">
            <small><?= form_error('user_access'); ?></small>
          </div>
        </div>
        <div class="row">
          <br/><br/>
          <center>
            <a href="<?= base_url()?>AdminMinorReports" type="button" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
          </center>
          <br/><br/>
        </div>
      </div>
    </form>
</div>

<script type="text/javascript">
	window.onload = function () {

		$(document).on("focusin keyup", "#user_lastname.autocomplete2", function () {
			$.ajax({
				"method": "POST",
				"url": '<?= base_url(); ?>' + "AdminIncidentReport/search_user_lastname",
				"dataType": "JSON",
				"data": {
					'id': $(".autocomplete2").val()
				},
				success: function (res) {
					$("#user_lastname_menu").empty();
					if (res.length == 0) {
						$("#user_lastname_menu").append("<li class = 'no-matches'><a>No match found</a></li>");
					} else {
						for (var i = 0; i < res.length; i++) {
							$("#user_lastname_menu").append("<li title = '" + res[i].user_firstname + " " + res[i].user_lastname + "' data-firstname = '" + res[i].user_firstname + "' data-number = '" + res[i].user_number + "' data-lastname = '" + res[i].user_lastname +"' data-middlename = '" + res[i].user_middlename + "' data-course = '" + res[i].user_course + "' data-access = '" + res[i].user_access + "' data-userid = '" + res[i].user_id + "'><a>" + res[i].user_lastname + ', ' + res[i].user_firstname + ' ' + res[i].user_middlename + "</a></li>");
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
				$("input.autocomplete2 + ul.dropdown-menu").append(
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

		$(document).on("focus click", "input.autocomplete2 + ul.dropdown-menu li", function (e) {
			// Prevent any action on the window location
			e.preventDefault();

			// Cache useful selectors
			$li = $(this);
			$input = $li.parent("ul").prev("input");
			$userid = $("#user_id");
			$number = $("#user_number");
			$firstname = $("#user_firstname");
			$lastname = $("#user_lastname");
			$middlename = $("#user_middlename");
			$course = $("#user_course");
			$access = $("#user_access");

			// Update input text with selected entry
			if (!$li.is(".no-matches")) {
				$input.val($li.text());
				$userid.val($li.data('userid'));
				$number.val($li.data('number'));
				$firstname.val($li.data('firstname'));
				$lastname.val($li.data('lastname'));
				$middlename.val($li.data('middlename'));
				$course.val($li.data('course'));
				$access.val($li.data('access'));
			}
		});
	}
</script>
