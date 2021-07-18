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
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>

</head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid" id="header-container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo.png" alt="SimpleStockdb.com" title="SimpleStockdb.com" /></a>
                        
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <div class=" col-xs-12 col-sm-8 col-md-5 col-lg-5 search-input-container">
                         <form method="post" action="">
                            <div class="input-group search-input">
                                <span id="basic-addon1" class="input-group-addon">
                                    <i class="glyphicon glyphicon-search"></i>
                                </span>
                                <input class="form-control text-left" type="text" id="container-search-input" placeholder="search items here...">
                            </div>
                        </form>
                        <div id="search-result">
                            
                        </div>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class=" nav-items" role="presentation"><a href="<?php echo site_url('items/all'); ?>">Items </a></li>
                        <li role="presentation" class="nav-items"><a href="<?php echo site_url('categories/all'); ?>">Categories </a></li>
                        <li role="presentation" class="nav-items"><a href="<?php echo site_url('locations/all'); ?>">Locations </a></li>
                        <li role="presentation" class="nav-items"><a href="<?php echo site_url('suppliers/all'); ?>">Suppliers </a></li>
                        <?php if(is_user()) {?>
                        <li class="dropdown"><a class="dropdown-toggle" id="profile-link" data-toggle="dropdown" aria-expanded="false" href="#">
                            <img src="<?php echo base_url().PATH_USER_PICS.$this->session->userdata("profile_picture");?>" class="profile-img"/></a>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a href="<?php echo site_url('users/profile'); ?>"><i class="fa fa-user-circle"></i> My Profile</a></li>
                                <li role="presentation"><a href="<?php echo site_url('users/all') ?>"><i class="fa fa-users"></i> Users</a></li>
                                <li role="presentation"><a href="<?php echo site_url('users/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
<script type="text/javascript">
    $(document).ready(function () {
        $("#container-search-input").on('focus', function () {
           $("#search-result").show();

        });

        $("#container-search-input").on('blur', function () {
              setTimeout(function() {
              $("#search-result").hide();
              }, 100);
        });

        $("#container-search-input").on('keyup', function (argument) {
            var q = $("#container-search-input").val();
            if(q == ''){
              $('#search-result').html('');
              return;
            }
            var request_url = "<?php echo site_url('items/search');?>";
            $.ajax({
              url: request_url,
              type: "post",
              data: {
                // key of data can be in string or not
                search_q: q
              },
              success: function (data) {
                $('#search-result').html(data);
              } 
          });
      }); 
    });
</script>