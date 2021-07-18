<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class=" text-center bg-info"> Categories</h3>
                    <?php echo $this->session->flashdata('alert');?>
                    <div class="text-right" ><a href="<?php echo site_url('categories/add') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Category</a></div><br>
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <tr class="active">
                                <th class="col-md-10">Name</th> 
                                <th class="col-md-2">Action</th> 
                            </tr>
                            <?php foreach ($list as $count => $category) { ?>
                                <tr>
                                    <td><?php echo $category->category_name; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('categories/delete/'.$category->category_id); ?>"
                                         class=" btn btn-danger  delete-record btn-xs"><i class="fa fa-trash"></i> Delete</a>
                                        <a href="<?php echo site_url('categories/edit/'.$category->category_id); ?>"
                                        class=" btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>    
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 text-center">
                <?php echo $pagination; ?>
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