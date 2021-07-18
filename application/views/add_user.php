<?php if(validation_errors()) {?>
<div class="alert alert-danger bg-danger">
   <?php echo validation_errors('<i class="fa fa-close"></i> ') ?>
</div>
<?php }?>
<?php echo $this->session->flashdata('alert'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-5 col-xs-12 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class=" text-center"><i class="fa fa-user-plus"></i> Add User</h4>
                    
                    <form method="post" enctype="multipart/form-data" action="<?php echo current_url();?>">
                        <div class="form-group">
                            <label for="std-name">Name:</label>
                            <input type="text" class="form-control" id="std-name" placeholder="Enter Name" name="name" maxlength="50" minlength="3" required="" 
                            value="<?php echo set_value('name') ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-mail">Email:</label>
                            <input type="email" class="form-control" id="std-mail" placeholder="Enter Email" name="email" maxlength="100" minlength="8"
                             value="<?php echo set_value('email')?>" required="" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Password:</label>
                            <input type="password" name="password" class="form-control"
                             placeholder="Enter Password" value="<?php echo set_value('password')?>" required="" minlength="8" maxlength="50" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Profile Picture:</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*" />
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Add User</button>
                    </form>
                </div>
             </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-3 col-lg-4"></div>
    <div class="col-md-4 col-sm-4 col-lg-5"></div>
</div>