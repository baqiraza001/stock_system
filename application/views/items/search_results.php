<ul>
	<?php foreach ($items as $item) { ?>
	<li>
		<a href="<?php echo site_url("items/detail/$item->item_id") ?>">
			<strong><?php echo $item->item_name ?></strong> |
			<span><?php echo $item->item_code ?></span>
		</a>
	</li> 
	<?php } ?>
</ul>