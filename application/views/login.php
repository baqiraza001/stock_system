<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$page_title | ".SITE_NAME;?></title>
    <link rel="icon" href="<?php echo base_url();?>assets/images/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome.min.css">
</head>
    <body>
        <!-- user registration form starts here -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-5 col-xs-12 col-lg-offset-4 col-lg-3">
                    <div class="panel-body login-panel">
                        <h4 class=" text-center"><img src="<?php echo base_url();?>assets/images/login.png"></h4>
                        <?php if(validation_errors()) {?>
                            <div class="alert alert-danger bg-danger">
                               <?php echo validation_errors() ?>
                            </div>
                        <?php }?>
                        <?php echo $this->session->flashdata('alert');?>
                        <form method="post" enctype="multipart/form-data" action="<?php echo current_url();?>">
                            <div class="form-group">
                                <input type="email" class="form-control" id="std-mail" placeholder="Enter Email" name="email" maxlength="100" minlength="8" required="" autofocus="" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control"
                                 placeholder="Enter Password"  required="" minlength="8" maxlength="50" />
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Login</button>
                            &nbsp;&nbsp;<span><a href="<?php echo site_url('users/forgot_password') ?>" id="forgot-password">Forgot Password?</a></span>
                        </form>
                     </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-5"></div>
        </div>
        <!-- user registration form ends here -->

        <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
        <script src="<?php echo base_url();?>assets/js/custom.js"></script>
    </body>
</html>