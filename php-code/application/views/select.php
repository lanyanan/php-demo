<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>自在家(zizaiplus)-自在新奇之美在家里-金地集团、新家生活、装修设计！</title>
	<meta name="keywords" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
	<meta name="description" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
    <link rel="stylesheet" href="/static/css/select.css"></link>
</head>
<body>
	<input type="hidden" name="floor_area" value="<?php echo $floor_area; ?>"/>
	<input type="hidden" name="house_type_id" value="<?php echo $house_type_id; ?>"/>
	<input type="hidden" name="style" value="<?php echo $style; ?>"/>
	<input type="hidden" name="type" value="<?php echo $type; ?>"/>
	<input type="hidden" name="title" value="<?php echo $title; ?>"/>
	<input type="hidden" name="cost" value="<?php echo $cost; ?>"/>
    <section class="result-page">
        <section class="result-page-logo">
            <img class="home" src="/static/images/home.png"/>
            <span><?php echo $showTitle; ?></span>
            <label class="home">首页</label>
        </section>
        <!-- <section class="result-page-logo result-page-logo-second">
            <span>与各地业主装修那点事</span>
        </section> -->
        <!-- <section class="result-page-search">
            <div class="search-center">
                <img src="/static/images/search.png"/>
                <input placeholder="北欧装修效果"/>
            </div>
        </section> -->
        <section class="result-page-tab">
            <div class="tab-active">
                <label></label>
                <span onClick="showHiddenSelect(0)">
                </span>
                <section  onClick="hiddenSelect()"  class="hidden-select">
                    <span class="<?php if ($type == ''): ?>active<?php endif; ?>"  data-type='type' data-id="">所有</span>
                    <span class="<?php if ($type == '0'): ?>active<?php endif; ?>" data-type='type' data-id="0">视频</span>
                    <span class="<?php if ($type == '1'): ?>active<?php endif; ?>" data-type='type' data-id="1">图集</span>
                </section>
            </div>
            <div>
                <span onClick="showHiddenSelect(1)">
                </span>
                <section onClick="hiddenSelect()" class="hidden-select">
                	<span  class="<?php if ($house_type_id ==  ''): ?>active<?php endif; ?>" data-id='' data-type='house_type_id'>户型不限</span>
                    <?php foreach ($house_type_list as $data_item): ?>
    			    <span  class="<?php if ($house_type_id ==  $data_item['id']): ?>active<?php endif; ?>" data-id='<?php echo $data_item['id']; ?>' data-type='house_type_id'><?php echo $data_item['house_type_name']; ?></span>
                <?php endforeach; ?>
                </section>
            </div>
            <div>
                <span onClick="showHiddenSelect(2)">
                </span>
                <section onClick="hiddenSelect()" class="hidden-select">
                     <section class="search-reasult-item-content">
                     	<span  class="<?php if ($style ==  ''): ?>active<?php endif; ?>" data-id='' data-type='style'>风格不限</span>
                    	<?php foreach ($style_list as $data_item): ?>
            			    <span  class="<?php if ($style ==  $data_item['id']): ?>active<?php endif; ?>" data-id='<?php echo $data_item['id']; ?>' data-type='style'><?php echo $data_item['style_name']; ?></span>
                        <?php endforeach; ?>
           			 </section>
                </section>
            </div>
            <div>
                <span onClick="showHiddenSelect(3)">
                </span>
                <section onClick="hiddenSelect()" class="hidden-select">
                     <section class="search-reasult-item-content">
                     	<span class="<?php if ($floor_area ==  '' ): ?>active<?php endif; ?>" data-id='' data-type='floor_area'>面积不限</span>
                        <span class="<?php if ($floor_area == '0' ): ?>active<?php endif; ?>" data-id='0' data-type='floor_area'>60m²以下</span>
                        <span class="<?php if ($floor_area == '1' ): ?>active<?php endif; ?>" data-id='1' data-type='floor_area'>60-80m²</span>
                        <span class="<?php if ($floor_area == '2' ): ?>active<?php endif; ?>" data-id='2' data-type='floor_area'>80-100m²</span>
                        <span class="<?php if ($floor_area == '3' ): ?>active<?php endif; ?>" data-id='3' data-type='floor_area'>100-120m²</span>
                        <span class="<?php if ($floor_area == '4' ): ?>active<?php endif; ?>" data-id='4' data-type='floor_area'>120-180m²</span>
                        <span class="<?php if ($floor_area == '5' ): ?>active<?php endif; ?>" data-id='5' data-type='floor_area'>180m²以上</span>
                    </section>
                </section>
            </div>
        </section>
        <section id="content" class="result-search-content">
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
</section>
<?php endforeach; ?>
<div style="display:none;" id="template"></div>
<?php echo $page; //输出分页信息 ?>
        </section>
        <section class="result-search-history">
            <section class="result-search-history-top">
                <img src="/static/images/search.png"/>
            </section>
            <section class="result-search-history-content">
                <?php foreach ($term['data'] as $term_item): ?>
                	<span class="term" data-name="<?php echo $term_item['name']; ?>" data-id="<?php echo $term_item['id']; ?>"><?php echo $term_item['name']; ?></span>
                <?php endforeach; ?>
            </section>
        </section>
        <section class="result-bottom">
            <div class="tab-active">
                <label></label>
                <span class="home">
                    首页
                </span>
            </div>
            <div>
                <span>
                    装修案例
                </span>
            </div>
            <div>
                <span class="loveSearch">
                    大家都爱搜
                </span>
            </div>
            <div>
                <span>
                    联系我们
                </span>
            </div>
        </section>
    </section>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script src="https://cdn.bootcss.com/masonry/2.1.07/jquery.masonry.min.js"></script>
<script src="/static/js/common.js"></script>
<script>

$(document).ready(function(){
    var $container = $('#content');    
    $container.imagesLoaded(function(){
        $container.masonry({
            itemSelector: '.content-card',
            columnWidth: 1 //每两列之间的间隙为5像素
        });
    });

	//页面初始化高亮选择的条件	
    $(".result-page-tab div").each(function(){
    	var text = $(this).find('span:first').data('default');
        if($(this).find('.active').length != 0) {
        	text = $(this).find('.active').text();
        	if(text.indexOf("不限") == -1 && text.indexOf("所有") == -1) {
            	$(this).addClass('tab-active');
            }
        }
    	$(this).find('span:first').text(text);
    });
}).on('click','.content-card', function(){
	var id = $(this).data("id");
	var resType = $(this).data("res-type");
	if (resType == '0') {
		window.location.href = '/mobile/res_video/' + id;
	} else {
		window.location.href = '/mobile/res_album/' + id;
	}
}).on('click','.result-page-tab div section span', function(){
	if ($(this).hasClass('active')) {
		return;
	}
	var type = $(this).data('type');
	var id = $(this).data('id');
	var text = $(this).text();
	$('[name="'+type+'"]').val(id);

	var floor_area = $('[name="floor_area"]').val();
	var house_type_id = $('[name="house_type_id"]').val();
	var style = $('[name="style"]').val();
	var type = $('[name="type"]').val();
	var title = $('[name="title"]').val();
	var cost = $('[name="cost"]').val();
	var url = '/mobile/select';
	if (type != '') {
		url += '/' + type;
	}
	window.location.href = url + '?term_name='+text+'&floor_area=' + floor_area+'&house_type_id=' + house_type_id+'&style=' + style+'&type=' + type+'&title=' + title+'&cost=' + cost;
}).on('click','.get-more-list', function() {
	$this = $(this);
	$href = $this.data('href');
	$("#template").load($href, function(){
		$("#content").append($("#template").html());
		$("#template").html("");
		$this.remove();
		$('#content').imagesLoaded(function() {
			$('#content').masonry('reload');
		});
	});
});

function showHiddenSelect(num){
    $(".hidden-select").css({
        display:'none'
    })
    $(".hidden-select").eq(num).css({
        display:'block'
    })
}


function hiddenSelect(num){
    $(".hidden-select").css({
        display:'none'
    })
}


$(window).scroll(function(){
    var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();
    if(scrollTop + windowHeight == scrollHeight){
    	$(".get-more-list").click();
    }
})
</script>
</html>