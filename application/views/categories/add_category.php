<?php if(validation_errors()) {?>
<div class="alert alert-danger bg-danger">
   <?php echo validation_errors('<i class="fa fa-close"></i> ') ?>
</div>
<?php }?>
<?php echo $this->session->flashdata('alert'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-sm-10 col-xs-12 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class=" text-center"><i class="fa fa-plus"></i> Add Category</h4>
                    
                    <form method="post" enctype="multipart/form-data" action="<?php echo current_url();?>">
                        <div class="form-group">
                            <label for="std-name">Name:</label>
                            <input type="text" class="form-control" id="std-name" placeholder="Enter category name" name="category_name" maxlength="200" minlength="3" required="" 
                            value="<?php echo set_value('category_name') ?>" />
                        </div>
                        <div class="form-group">
                            <label for="desc">Description:</label>
                            <textarea class="form-control descripton-text" name="category_description" placeholder="Enter description" minlength="3"><?php echo set_value('category_description'); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Category</button>
                    </form>
                </div>
             </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-2 col-lg-4"></div>
</div>