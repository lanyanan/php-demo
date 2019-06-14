 <?php foreach ($data as $data_item): ?>       	
<section class="content-card" data-album-id="<?php echo $data_item['album_id']; ?>" data-id="<?php echo $data_item['id']; ?>">
	<div class="content-card-top">
    	<img src="<?php echo $data_item['attach_url']; ?>" />
		<p><?php echo $data_item['space_name']; ?></p>
	</div>
</section>
<?php endforeach; ?>
<?php echo $page; //输出分页信息 ?>