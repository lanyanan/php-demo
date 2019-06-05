<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
<link rel="stylesheet" href="/static/css/home.css"></link>
</head>
<body>
	<section class="home-page">
		<section class="home-page-logo">
			<img src="/static/images/logo.png" /> <span>自有新奇之美在家里</span>
		</section>
		<section class="home-page-search">
			<div class="search-center">
				<img src="/static/images/search.png" /> <input
					placeholder="北欧装修效果" id="search" type="search" />
			</div>
		</section>
		<section class="home-page-tab">
			<div class="<?php if ($type == '0'): ?>tab-active<?php endif; ?> tab" data-value="0">
				<label></label> <span> 推荐 </span>
			</div>
			<div class="<?php if ($type == '1'): ?>tab-active<?php endif; ?> tab" data-value="1">
				<label></label> <span> 热门 </span>
			</div>
			<div class="<?php if ($type == '2'): ?>tab-active<?php endif; ?> tab" data-value="2">
				<label></label> <span> 更多 </span>
			</div>
		</section>
		<section class="home-search-content">
			<?php foreach ($data as $data_item): ?>

               <section class="content-card">
    				<div class="content-card-top">
    					<img src="<?php echo $data_item['attach_url']; ?>" />
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
		</section>
		<section class="get-more-list">
			<span>加载更多</span>
		</section>
		<section class="home-bottom">
			<div class="tab-active">
				<label></label> <span> 首页 </span>
			</div>
			<div>
				<span> 装修案例 </span>
			</div>
			<div>
				<span> 大家都爱搜 </span>
			</div>
			<div>
				<span> 联系我们 </span>
			</div>
		</section>
	</section>
	<input type="hidden" id="page" value="0" />
	<input type="hidden" id="limit" limit="10" />
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js"></script>
<script src="/static/js/home.js"></script>
</html>