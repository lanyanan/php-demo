<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>自在家(zizaiplus)-自在新奇之美在家里！</title>
	<meta name="keywords" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
	<meta name="description" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
    <link rel="stylesheet" href="/static/css/loveSearch.css"></link>
</head>
<body>
    <section class="result-page-logo">
        <img class="home" src="/static/images/home.png"/>
        <span>大家都爱搜</span>
        <label  class="home"><a title="首页" href="<?php echo site_url('/mobile/home'); ?>">首页</a></label>
    </section>
    <section class="love-search">
    	<?php foreach ($data as $data_item): ?>
		    <span><?php echo $data_item['search_name'];?></span>
        <?php endforeach; ?>
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
			<!-- <div>
				<span> 联系我们 </span>
			</div> -->
		</section>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script src="/static/js/common.js"></script>
<script type="text/javascript">
$(function() {
}).on('click', '.love-search span', function(){
	var text = $(this).text();
	window.location.href = '/mobile/result?title=' + text;
})
</script>
</html>