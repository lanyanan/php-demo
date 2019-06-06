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
<link rel="stylesheet" href="/static/css/result.css"></link>
</head>
<body>
	<input id="title" value="<?php echo $title; ?>" type="hidden">
	<input id="type" value="<?php echo $type; ?>" type="hidden">
	<section class="result-page">
		<section class="result-page-logo">
			<img class="home" src="/static/images/home.png" /> <span><?php echo $title; ?></span>
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
		<section class="result-search-content">
			<section class="home-search-content">
			<?php foreach ($data as $data_item): ?>

               <section class="content-card" data-id="<?php echo $data_item['id']; ?>" data-res-type="<?php echo $data_item['res_type']; ?>">
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
				<label></label> <span class="home"> 首页 </span>
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
	<input type="hidden" id="page" value="1" />
	<input type="hidden" id="limit" limit="2" />
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js"></script>
<script src="/static/js/common.js"></script>
<script src="/static/js/result.js"></script>
</html>