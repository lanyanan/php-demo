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
    <link rel="stylesheet" href="/static/css/image_select.css"></link>
</head>
<body>
	<input type="hidden" name="house_space_id" value="<?php echo $house_space_id; ?>"/>
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
        	<section class="result-page-tab-content">
                <div class="<?php if ($house_space_id ==  ''): ?>tab-active<?php endif; ?>" >
                	<span  data-id='' data-type='house_space_id'>全部</span>
                </div>
            	<?php foreach ($house_space_list as $data_item): ?>
            	<div  class="<?php if ($house_space_id ==  $data_item['id']): ?> tab-active <?php endif; ?>">
    			    <span  data-id='<?php echo $data_item['id']; ?>' data-type='house_space_id'><?php echo $data_item['house_space_name']; ?></span>
            	</div>
            	<?php endforeach; ?>
            </section>
        </section>
        <section id="content" class="result-search-content">
 <?php foreach ($data as $data_item): ?>       	
<section class="content-card"  data-album-id="<?php echo $data_item['album_id']; ?>"  data-id="<?php echo $data_item['id']; ?>">
	<div class="content-card-top">
    	<img src="<?php echo $data_item['attach_url']; ?>" />
		<p><?php echo $data_item['description']; ?></p>
	</div>
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

}).on('click','.content-card', function(){
	var id = $(this).data("album-id");
	var resType = $(this).data("res-type");
	window.location.href = '/mobile/res_album/' + id;
}).on('click','.result-page-tab div span', function(){
	var type = $(this).data('type');
	var id = $(this).data('id');
	var term_name = $(this).text();
	window.location.href = '/mobile/image_select?term_name='+term_name+'&'+ type +'=' + id;
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