<style scoped>
    .gj-editor [role=body]{
        font-family:'Calibri';
        font-weight:regular;
    }
    input[type="text"]{
        background: transparent;
        border: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        border-radius: 0;
        color:white;
        margin-bottom:5px !important;
        float: left;
        padding:2px;
    }
    .add_on{
        float: left;
        margin:10px;
    }

    .has-error{
        border-bottom:red;
        color:red;
    }

    input[type="text"]:focus{
        -webkit-box-shadow: none;
        background: #f1f1f1;
        transition:0.5s;
        border-radius:3px;
        color:black;
        box-shadow: none;
    }
    .form_error{

    }

</style>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>admindashboard">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Content Management System</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class="col-md-12">
        <h1><?= $cms->cms_title?></h1>
        <h5><?= $cms->cms_text?></h5>
    </div>
</div>



<form action = "<?= base_url()?>AdminCMS/edit_cms_exec/<?= $cms->cms_id?>" method = "POST">
    <div class="row">
        <!-- WYSIWYG for INCIDENT REPORT -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->incident_report_title?>" name = "incident_report_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_incident_report" name = "incident_report_text"><?= $cms->incident_report_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for Google Drive -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->google_drive_title?>" name = "google_drive_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_google_drive" name = "google_drive_text"><?= $cms->google_drive_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for DUSAP -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->dusap_title?>" name = "dusap_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_dusap" name = "dusap_text"><?= $cms->dusap_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for Email -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->email_title?>" name = "email_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_email" name = "email_text"><?= $cms->email_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for CMS -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->cms_title?>" name = "cms_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_cms" name = "cms_text"><?= $cms->cms_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for AUDIT TRAIL -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->audit_trail_title?>" name = "audit_trail_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_audit_trail" name = "audit_trail_text"><?= $cms->audit_trail_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for USER LOGS -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->user_logs_title?>" name = "user_logs_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_user_logs" name = "user_logs_text"><?= $cms->user_logs_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for Student Handbook -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->student_handbook_title?>" name = "student_handbook_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_student_handbook" name = "student_handbook_text"><?= $cms->student_handbook_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for Monthly Report -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->monthly_report_title?>" name = "monthly_report_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_monthly_report" name = "monthly_report_text"><?= $cms->monthly_report_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for Student Profile -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->student_profile_title?>" name = "student_profile_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_student_profile" name = "student_profile_text"><?= $cms->student_profile_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for FAQ -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->faq_title?>" name = "faq_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_faq" name = "faq_text"><?= $cms->faq_text?></textarea>
                </div>
            </div>
        </div>
        <!-- WYSIWYG for Offense Report -->
        <div class = "col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading dark-overlay" title="Edit title">
                    <i class = "fa fa-pencil-alt add_on"></i>
                    <input type = "text" value = "<?= $cms->offense_report_title?>" name = "offense_report_title" required/>
                </div>
                <div class="panel-body">
                    <textarea id = "editor_offense_report" name = "offense_report_text"><?= $cms->offense_report_text?></textarea>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row" style = "margin-bottom:30px;">
        <div class="col-xs-12 text-right">
            <button type = "reset" class = "btn btn-secondary"><i class = "fa fa-redo"></i> Reset</button>&emsp;
            <button type = "submit" class = "btn btn-primary"><i class = "fa fa-save"></i> Save Changes</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#editor_incident_report").editor();
        $("#editor_google_drive").editor();
        $("#editor_dusap").editor();
        $("#editor_email").editor();
        $("#editor_cms").editor();
        $("#editor_audit_trail").editor();
        $("#editor_user_logs").editor();
        $("#editor_student_handbook").editor();
        $("#editor_monthly_report").editor();
        $("#editor_student_profile").editor();
        $("#editor_faq").editor();
        $("#editor_offense_report").editor();
    });
</script>

