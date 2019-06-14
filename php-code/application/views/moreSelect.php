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
    <link rel="stylesheet" href="/static/css/moreselect.css"></link>
</head>
<body>
    <section class="result-page-logo">
        <img class="home" src="/static/images/home.png"/>
        <span>更多装修案例与装修知识</span>
        <label  class="home">首页</label>
    </section>
    <section class="search-reasult">
        <section class="search-reasult-item">
            <section class="search-reasult-item-title">
                <span>户型</span>
            </section>
            <section class="search-reasult-item-content">
            	<?php foreach ($house_type as $data_item): ?>
    			    <span data-id='<?php echo $data_item['id']; ?>' data-type='house_type_id'><?php echo $data_item['house_type_name']; ?></span>
                <?php endforeach; ?>
            </section>
        </section>
         <section class="search-reasult-item">
            <section class="search-reasult-item-title">
                <span data-id='<?php echo $data_item['id']; ?>' data-type='house_type_id'>空间</span>
            </section>
            <section class="search-reasult-item-content">
            	<?php foreach ($house_space as $data_item): ?>
    			    <span data-id='<?php echo $data_item['id']; ?>' data-type='house_space_id'><?php echo $data_item['house_space_name']; ?></span>
                <?php endforeach; ?>
            </section>
        </section>
         <section class="search-reasult-item">
            <section class="search-reasult-item-title">
                <span>风格</span>
            </section>
            <section class="search-reasult-item-content">
            	<?php foreach ($style as $data_item): ?>
    			    <span data-id='<?php echo $data_item['id']; ?>' data-type='style'><?php echo $data_item['style_name']; ?></span>
                <?php endforeach; ?>
            </section>
        </section>
        <section class="search-reasult-item">
            <section class="search-reasult-item-title">
                <span>面积</span>
            </section>
            <section class="search-reasult-item-content">
                <span data-id='0' data-type='floor_area'>60m²以下</span>
                <span data-id='1' data-type='floor_area'>60-80m²</span>
                <span data-id='2' data-type='floor_area'>80m-100m²</span>
                <span data-id='3' data-type='floor_area'>100-120m²</span>
                <span data-id='4' data-type='floor_area'>120-180m²</span>
                <span data-id='5' data-type='floor_area'>180m²以上</span>
            </section>
        </section>
        <section class="search-reasult-item">
            <section class="search-reasult-item-title">
                <span>价格</span>
            </section>
            <section class="search-reasult-item-content">
                <span data-id='0' data-type='cost'>3万以下</span>
                <span data-id='1' data-type='cost'>3-5万</span>
                <span data-id='2' data-type='cost'>5-8万</span>
                <span data-id='3' data-type='cost'>8-15万</span>
                <span data-id='4' data-type='cost'>15-20万</span>
                <span data-id='5' data-type='cost'>20万以上</span>
            </section>
        </section>
         <section class="search-reasult-item">
            <section class="search-reasult-item-title">
                <span>大家都爱搜</span>
            </section>
            <section class="search-reasult-item-content">
               <?php foreach ($search as $data_item): ?>
    			   <span data-id='<?php echo $data_item['search_name']; ?>' data-type='title'><?php echo $data_item['search_name']; ?></span>
               <?php endforeach; ?>
            </section>
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
				<span  class="loveSearch"> 大家都爱搜 </span>
			</div>
			<div>
				<span> 联系我们 </span>
			</div>
		</section>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script src="/static/js/common.js"></script>
<script type="text/javascript">
$(function() {
}).on('click', '.search-reasult-item span', function(){
	var type = $(this).data('type');
	var id = $(this).data('id');
	var term_name = $(this).text();

	if (type == 'house_space_id') {
		window.location.href = '/mobile/image_select?term_name='+term_name+'&'+ type +'=' + id;
	} else {
		window.location.href = '/mobile/select?term_name='+term_name+'&'+ type +'=' + id;
	}
})
</script>
</html>