<style>
    .alert-dismissible {
        text-align: left !important;
        padding-right: 30px;
        z-index: 9999;
        position: fixed;
        top: 20px;
        left: 50%;
        /* bring your own prefixes */
        transform: translate(-50%, 0px);
    }
    .err_login{
        color:white;
        background:#a94442;
        border:#a94442;
    }
</style>
<?php if (!empty($this->session->flashdata("err_login"))): ?>
    <div class="err_login alert alert-danger alert-dismissible show" role="alert">
        <button style = "color:white;" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-exclamation"></i></strong> <?= $this->session->flashdata("err_login"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("err_sms"))): ?>
    <div class="err_login alert alert-danger alert-dismissible show" role="alert">
        <button style = "color:white;" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-exclamation"></i></strong> <?= $this->session->flashdata("err_sms"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("success_sms"))): ?>
    <div class="alert alert-success alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-check"></i></strong> <?= $this->session->flashdata("success_sms"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("uploading_error"))): ?>
    <div class="alert alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-check"></i></strong> <?= $this->session->flashdata("uploading_error"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("uploading_success"))): ?>
    <div class="alert alert-success alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-check"></i></strong> <?= $this->session->flashdata("uploading_success"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("err_profile"))): ?>
    <div class="alert alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-check"></i></strong> <?= $this->session->flashdata("err_profile"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("success_profile"))): ?>
    <div class="alert alert-success alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-check"></i></strong> <?= $this->session->flashdata("success_profile"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("cms_error"))): ?>
    <div class="alert alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $this->session->flashdata("cms_error"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("success_incident_report"))): ?>
    <div class="alert alert-success alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class = "fa fa-check"></i></strong> <?= $this->session->flashdata("success_incident_report"); ?>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata("error_incident_report"))): ?>
    <div class="alert alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $this->session->flashdata("error_incident_report"); ?>
    </div>
<?php endif; ?>