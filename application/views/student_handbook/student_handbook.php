<style>
    #handbook{
        height:78vh;
        width:100%;
    }
</style>

<div class="row">
    <ol class="breadcrumb">
        <?php if($this->session->userdata("useraccess") == "admin"):?>
            <li><a href="<?= base_url() ?>AdminDashboard">
        <?php else:?>
            <li><a href="<?= base_url() ?>UserDashboard">
        <?php endif;?>
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Student Handbook</li>
    </ol>
</div><!--/.row breadcrumb-->

<div class="row">
    <div class="col-xs-12">
        <h1><?= $cms->student_handbook_title?></h1>
        <h5><?= $cms->student_handbook_text?></h5>
    </div>
</div>

<div class = "row">
    <div class = "col-md-12">
        <object id = "handbook" data="<?=  base_url()?>assets/student_handbook.pdf" type="application/pdf">
            <embed src="<?=  base_url()?>assets/student_handbook.pdf" type="application/pdf" />
        </object>
    </div>
</div>

