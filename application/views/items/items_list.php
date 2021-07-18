<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo $this->session->flashdata('alert');?>
                    <div class="text-right" ><a href="<?php echo site_url('items/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Item</a></div><br>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <select name="location_id" class="form-control" id="location">
                                <option value="">Select Location</option>
                                <?php foreach ($locations as $location) { ?>
                                <option value="<?php echo $location->location_id; ?>">
                                    <?php echo $location->location_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <select name="category_id" class="form-control" id="category">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->category_id; ?>">
                                    <?php echo $category->category_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <select name="supplier_id" class="form-control" id="supplier">
                                <option value="">Select Supplier</option>
                                <?php foreach ($suppliers as $supplier) { ?>
                                <option value="<?php echo $supplier->supplier_id; ?>">
                                    <?php echo $supplier->supplier_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <select name="category_id" class="form-control" id="stock_type">
                                    <option value="all">All Items</option>
                                    <option value="low_stock">Low Stock Items</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-right" ><a href="#" class="btn btn-default" id="filter_items"><i class="fa fa-filter"></i> FIlter</a></div><br>
                    <div class="col-md-12 text-center " id="items-preloader">
                        <i class="fa fa-circle-o-notch fa-lg fa-spin"></i>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" id="items">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="delete-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Delete Category</h3>
            </div>
            <div class="modal-body">
                <p><i class="fa fa-exclamation-circle fa-lg" style="color: red"></i> Do you really want to delete this category?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-lg"></i> Close</button>
                <a class="btn btn-danger"><i class="fa fa-trash fa-lg"></i> Delete</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        function load_items(url) {
            if(url)
              var request_url = url;
            else
             var request_url = '<?php echo site_url("items/all_ajax"); ?>'
          $("#items-preloader").show();
          $.ajax({
            url : request_url,
            type : "get",
            success : function(data){
              $("#items-preloader").hide();
              $("#items").html(data);

              $(".pagination li a").click(function(){
                var btn_url = $(this).attr("href");
                load_items(btn_url);
                return false;
              });
            }
          });
        }
        load_items();

        $('#filter_items').click(function(){
            load_items();
            return false;
        });
    });
</script>