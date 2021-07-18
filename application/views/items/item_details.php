<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo $this->session->flashdata('alert');?>
                    <div class="row">
                    	<div class="col-xs-12 col-sm-offset-3 col-sm-5 col-md-offset-3 col-md-4 col-lg-offset-3 col-lg-3 item-img">
                    		<div>
                    		<img class="img-responsive img-thumbnail" src="<?php echo base_url();
							if(empty($item->image_name)) 
								echo "assets/images/stock.png";
							else
								echo PATH_ITEM_IMAGES.$item->image_name; ?>">
                    	</div>
                    	</div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 item-details">
	                       	<h3><?php echo $item->item_name ?></h3>     

	                       	<h4><?php echo $item->item_code ?></h4>
	                       	
	                       	<h3>Current Stock</h3>     
	                       	<h4><b><?php echo number_format($item->current_stock)?></b></h4>
	                       	
	                       	<strong>Location: </strong><span> <?php echo $item->location_name ?></span><br>
	                       	
	                       	<strong>Category: </strong><span> <?php echo $item->category_name ?></span><br>
	                       	
	                       	<strong class="item-supplier">Supplier: </strong><span> <?php echo $item->supplier_name ?></span><br>

							<?php if(!empty($item->file_name)) { ?> 
	                       	<a href="<?php echo base_url() . PATH_ITEM_FILES.$item->file_name; ?>" class="btn btn-warning btn-xs" download=""><i class="fa fa-file"></i> File</a>     
	                       	<?php } ?>
	                       	
	                       	<a href="<?php echo site_url("items/edit/$item->item_id")?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>     
	                       	
	                       	<a href="<?php echo site_url("items/delete/$item->item_id")?>" class=" delete-record btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a><br/>

                            <a href="#" data-toggle="modal" data-target="#add-stock-model" class="add-remove-stock">
                                <img src="<?php echo base_url();?>assets/images/stock-in.png" width="80" height="80" />
                            </a>
                            <a href="#" data-toggle="modal" data-target="#remove-stock-model"  class="add-remove-stock">
                                <img src="<?php echo base_url();?>assets/images/stock-out.png" width="80" height="80" />
                            </a>     
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 item-notes text-center">
                            <hr class="h-history"/>
                            <h3 >Item Notes</h3>
                        	<p><?php echo $item->item_notes ?></p>
                            
                            <hr class="h-history"/> 
                            <h3>Item Description</h3>
                        	<p><?php echo $item->item_description ?></p>
 
                            <hr class="h-history"/>
                            <h3>Item History</h3>
                        </div>
                        <div class="row">
                            <?php foreach ($items_history as $history) { ?>
                            <div class="col-xs-offset-3 col-xs-9 col-sm-offset-3 col-sm-9  col-md-offset-3 col-md-9  col-lg-offset-3 col-lg-9 text-left item-history">
                                <img class="img-circle " width="30" height="30" src="<?php echo base_url();
                                if(empty($history->profile_picture)) 
                                    echo "assets/images/avatar.png";
                                else
                                    echo PATH_USER_PICS.$history->profile_picture;
                                ?>" title="<?php echo $history->name ?>">
                                &emsp;
                                <span><?php echo date('d M, Y', strtotime($history->history_datetime)); ?></span>&emsp;
                                <span><?php echo date('h:i A', strtotime($history->history_datetime)); ?></span>&emsp;
                                <span><?php echo $history->name ?> 
                                    <?php if($history->type == STOCK_ADD) echo 'removed';
                                    else echo "added"; ?>
                                    <?php echo $history->amount ?> units</span>&emsp;&emsp;
                                <span><?php echo $history->reference ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div id="delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Delete Item</h3>
            </div>
            <div class="modal-body">
                <p><i class="fa fa-exclamation-circle fa-lg" style="color: red"></i> Do you really want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-lg"></i> Close</button>
                <a class="btn btn-danger"><i class="fa fa-trash fa-lg"></i> Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Add stock Modal -->
<div id="add-stock-model" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-center"><i class="fa fa-plus"></i> Add Stock</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <form method="post" enctype="multipart/form-data" action="<?php echo site_url("items/add_stock/$item->item_id") ?>">
                            <div class="form-group">
                                <label for="std-name">Amount:</label>
                                <input type="number" class="form-control" id="std-name" placeholder="Enter stock amount" name="amount" maxlength="11" minlength="1" required="" 
                                value="<?php echo set_value('amount') ?>" />
                            </div>
                            <div class="form-group">
                                <label for="std-name">Reference:</label>
                                <input type="text" class="form-control" id="std-name" placeholder="Provide any reference" name="reference" 
                                value="<?php echo set_value('reference') ?>" />
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Stock</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Remove stock Modal -->
<div id="remove-stock-model" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-center"><i class="fa fa-plus"></i> Remove Stock</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <form method="post" enctype="multipart/form-data" action="<?php echo site_url("items/remove_stock/$item->item_id") ?>">
                            <div class="form-group">
                                <label for="std-name">Amount:</label>
                                <input type="number" class="form-control" id="std-name" placeholder="Enter stock amount" name="amount" maxlength="11" minlength="1" required="" 
                                value="<?php echo set_value('amount') ?>" />
                            </div>
                            <div class="form-group">
                                <label for="std-name">Reference:</label>
                                <input type="text" class="form-control" id="std-name" placeholder="Provide any reference" name="reference" 
                                value="<?php echo set_value('reference') ?>" />
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Remove Stock</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>