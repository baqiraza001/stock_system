<?php
foreach ($items as $item) {?>
	<div class="col-md-2 col-sm-4 col-xs-6 col-lg-2 grid-item">
		<a href="<?php echo site_url("items/detail/$item->item_id") ?>" class="thumbnail">
			<img class="img-responsive" src="<?php echo base_url();
			if(empty($item->image_name))
				echo"assets/images/stock.png";
			else
				echo PATH_ITEM_IMAGES.$item->image_name?>">
			<span class="badge badge-default"><?php echo $item->current_stock; ?></span>
		</a>
		<div><strong><?php echo $item->item_name ?></strong></div>
		<div><span><?php echo $item->item_code ?></span></div>
	</div>	
<?php }?>
<div class="col-md-12 text-center">
	<?php echo $pagination; ?>
</div>