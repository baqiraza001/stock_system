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
                    <h4 class=" text-center"><i class="fa fa-edit"></i> Edit Item</h4>
                    <form method="post" enctype="multipart/form-data" action="<?php echo current_url();?>">
                        <div class="form-group">
                            <label for="std-name">Name:</label>
                            <input type="text" class="form-control" id="std-name" placeholder="Enter item name" name="item_name" maxlength="300" minlength="3" required="" 
                            value="<?php echo $item->item_name ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Code:</label>
                            <input type="text" class="form-control" id="std-name" placeholder="Enter item code" name="item_code" maxlength="300" minlength="3" required="" 
                            value="<?php echo $item->item_code ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Current Stock:</label>
                            <input type="number" class="form-control" id="std-name" placeholder="Enter current stock" name="current_stock" maxlength="11" minlength="1" required="" min="0"  
                            value="<?php echo $item->current_stock ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Low Stock Threshold:</label>
                            <input type="number" class="form-control" id="std-name" placeholder="Enter low stock threshold" name="threshold" maxlength="11" minlength="1" required="" min="0"
                            value="<?php echo $item->low_stock_threshold ?>" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">Location Name:</label>
                            <select name="location_id" class="form-control">
                                <option value="">Select Location</option>
                                <?php foreach ($locations as $location) { ?>
                                <option value="<?php echo $location->location_id; ?>">
                                    <?php echo $location->location_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="std-name">Category Name:</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->category_id; ?>">
                                    <?php echo $category->category_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="std-name">Supplier Name:</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">Select Supplier</option>
                                <?php foreach ($suppliers as $supplier) { ?>
                                <option value="<?php echo $supplier->supplier_id; ?>">
                                    <?php echo $supplier->supplier_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="std-name">Image Name:</label>
                            <input type="file" name="item_image" class="form-control" accept="image/*" />
                        </div>
                        <div class="form-group">
                            <label for="std-name">File Name:</label>
                            <input type="file" name="item_file" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="desc">Notes:</label>
                            <textarea class="form-control descripton-text" name="item_notes" placeholder="Enter Notes"><?php echo $item->item_notes; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="desc">Description:</label>
                            <textarea class="form-control descripton-text" name="item_description" placeholder="Enter description"><?php echo $item->item_description; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Update</button>
                    </form>
                </div>
             </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-2 col-lg-4"></div>
</div>
<script type="text/javascript">
        $('select[name = "location_id"]').val(<?php echo $item->location_id; ?>);
        $('select[name = "category_id"]').val(<?php echo $item->category_id; ?>);
        $('select[name = "supplier_id"]').val(<?php echo $item->supplier_id; ?>);
</script>