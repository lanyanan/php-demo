<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<title>自在家(zizaiplus)-自在新奇之美在家里！</title>
<meta name="keywords" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
<meta name="description" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
<link rel="stylesheet" href="/static/css/result.css"></link>
</head>
<body>
	<input id="title" value="<?php echo $title; ?>" type="hidden">
	<input id="type" value="<?php echo $type; ?>" type="hidden">
	<section class="result-page">
		<section class="result-page-logo">
			<img class="home" src="/static/images/home.png" /> <span><?php echo $showTitle; ?></span>
		</section>
		<!-- <section class="result-page-search">
            <div class="search-center">
                <img src="/static/images/search.png"/>
                <input placeholder="北欧装修效果"/>
            </div>
        </section> -->
		<section class="result-page-tab">
			<div class="<?php if ($type == ''): ?>tab-active<?php endif; ?> tab" data-value="">
				<label></label> <span> 所有 </span>
			</div>
			<div class="<?php if ($type == '0'): ?>tab-active<?php endif; ?> tab" data-value="0">
				<label></label> <span> 视频 </span>
			</div>
			<div class="<?php if ($type == '1'): ?>tab-active<?php endif; ?> tab" data-value="1">
				<label></label> <span> 图片 </span>
			</div>
		</section>
		<section  id="content"  class="result-search-content">
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
		</section>
            <div style="display:none;" id="template"></div>
            <?php echo $page; //输出分页信息 ?>
		<section class="result-search-history">
			<section class="result-search-history-top">
				<img src="/static/images/search.png" />
			</section>

			<section class="result-search-history-content">
                <?php foreach ($term['data'] as $term_item): ?>
                	<span class="term" data-name="<?php echo $term_item['name']; ?>" data-id="<?php echo $term_item['id']; ?>"><?php echo $term_item['name']; ?></span>
                <?php endforeach; ?>
            </section>
		</section>
		<section class="result-bottom">
			<div class="tab-active">
				<label></label> <span class="home"> <a title="首页" href="<?php echo site_url('/mobile/home'); ?>">首页</a> </span>
			</div>
			<div>
				<span> 装修案例 </span>
			</div>
			<div>
				<span  class="loveSearch"> <a title="大家都爱搜" href="<?php echo site_url('/mobile/loveSearch'); ?>">大家都爱搜</a> </span>
			</div>
			<div>
				<span> 联系我们 </span>
			</div>
		</section>
	</section>
	<input type="hidden" id="page" value="1" />
	<input type="hidden" id="limit" limit="10" />
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script src="https://cdn.bootcss.com/masonry/2.1.07/jquery.masonry.min.js"></script>
<script src="/static/js/common.js"></script>
<script src="/static/js/result.js"></script>
</html>