<style>
    #handbook{
        height:78vh;
        width:100%;
    }
</style>

    <div class="row">
        <ol class="breadcrumb">
            <?php if($this->session->userdata("useraccess") == "admin"):?>
                <li><a href="<?= base_url() ?>admindashboard">
            <?php else:?>
                <li><a href="<?= base_url() ?>userdashboard">
            <?php endif;?>
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Student Handbook</li>
        </ol>
    </div><!--/.row breadcrumb-->

    <div class = "row">
        <div class = "col-md-12">
            <object id = "handbook" data="<?=  base_url()?>assets/student_handbook.pdf" type="application/pdf">
                <embed src="<?=  base_url()?>assets/student_handbook.pdf" type="application/pdf" />
            </object>
        </div>
    </div>

