<?php foreach ($data as $data_item): ?>

<section class="content-card" data-id="<?php echo $data_item['id']; ?>" data-res-type="<?php echo $data_item['res_type']; ?>">
	<div class="content-card-top">
    	<?php if ($data_item['res_type'] == '0'): ?>
    	<div class="content-card-img">
    		<img src="<?php echo $data_item['attach_url']; ?>" />
    		<label></label>
    	</div>
    	<?php else: ?>
    		<img src="<?php echo $data_item['attach_url']; ?>" />
    	<?php endif; ?>
		<p><?php echo $data_item['description']; ?></p>
	</div>
	<section class="content-card-bottom">
		<div class="content-card-bottom-save-active">
			<label></label> <span>0</span>
		</div>
		<div class="content-card-bottom-love-active">
			<label></label> <span>0</span>
		</div>
	</section>
</section>
<?php endforeach; ?>
<?php echo $page; //输出分页信息 ?>