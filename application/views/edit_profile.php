<?php if(validation_errors()) {?>
<div class="alert alert-danger bg-danger"><i class="fa fa-check"></i>
   <?php echo validation_errors() ?>
</div>
<?php }?>
<?php echo $this->session->flashdata('alert'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-5 col-xs-12 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="panel-title text-center"><i class="fa fa-edit"></i> Edit Profile</h4>
                    <form method="post" enctype="multipart/form-data" action="<?php echo current_url();?>">
                        <div class="form-group">
                            <label for="std-name">Name:</label>
                            <input type="text" class="form-control" id="std-name" placeholder="Enter Name" name="name" maxlength="50" minlength="3" required="" 
                            value="<?php echo $user->name; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-mail">Email:</label>
                            <input type="email" class="form-control" id="std-mail" placeholder="Enter Email" name="email" maxlength="100" minlength="8"  required="" 
                             value="<?php echo $user->email; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Old Password:</label>
                            <input type="password" name="old_password" class="form-control"
                             placeholder="Enter Old Password" value="" minlength="8" maxlength="50" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">New Password:</label>
                            <input type="password" name="new_password" class="form-control"
                             placeholder="Enter New Password" value="" minlength="8" maxlength="50" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Profile Picture:</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*" />
                        </div>
                        
                        <button type="submit" class="btn btn-primary "><i class="fa fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-3 col-lg-4"></div>
    <div class="col-md-4 col-sm-4 col-lg-5"></div>
</div>