<?php foreach ($data as $data_item): ?>

<section class="content-card" data-id="<?php echo $data_item['id']; ?>" data-res-type="<?php echo $data_item['res_type']; ?>">
<?php if ($data_item['res_type'] == '0'): ?>
<a href="<?php echo site_url('/mobile/res_video/'.$data_item['id']); ?>">
<?php else: ?>
<a href="<?php echo site_url('/mobile/res_album/'.$data_item['id']); ?>">
<?php endif; ?>
	<div class="content-card-top">
    	<?php if ($data_item['res_type'] == '0'): ?>
    	<div class="content-card-img">
    		<img  title="<?php echo $data_item['title']; ?>"  src="<?php echo $data_item['attach_url']; ?>" />
    		<label></label>
    	</div>
    	<?php else: ?>
    		<img  title="<?php echo $data_item['title']; ?>"  src="<?php echo $data_item['attach_url']; ?>" />
    	<?php endif; ?>
		<p><?php echo $data_item['title']; ?></p>
	</div>
	<section class="content-card-bottom">
		<div class="content-card-bottom-save-active">
			<label></label> <span>0</span>
		</div>
		<div class="content-card-bottom-love-active">
			<label></label> <span>0</span>
		</div>
	</section>
	</a>
</section>
<?php endforeach; ?>
<?php echo $page; //输出分页信息 ?>