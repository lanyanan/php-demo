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
<link href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css"
	rel="stylesheet">
<link rel="stylesheet" href="/static/css/details.css"></link>
</head>
<body>
	<section class="details-page">
		<section class="details-page-pic">
			<section class="details-page-pic-bg">
				<span onclick="window.history.back(-1);"></span>
				<div class="swiper-container">
					<div class="swiper-wrapper">
                    	<?php foreach ($images as $image_item): ?>
                        <div class="swiper-slide">
							<img src="<?php echo $image_item['attach_url']; ?>" />
						</div>
                        <?php endforeach; ?>
                    </div>
					<div class="swiper-button-prev swiper-button-white"></div>
					<div class="swiper-button-next swiper-button-white"></div>
				</div>
			</section>
			<section class="details-page-pic-info">
				<section class="details-page-pic-info-btns">
					<div class="details-info-active">
						<label></label> <span>分享</span>
					</div>
					<div>
						<label></label> <span><?php if (!$like_count): ?>0<?php else: ?>$<?php $like_count ?><?php endif; ?></span>
					</div>
					<div>
						<label></label> <span><?php if (!$collect_count): ?>0<?php else: ?><?php $collect_count ?><?php endif; ?></span>
					</div>
					<div class="details-info-active">
						<label></label> <span>报价</span>
					</div>
				</section>
				<section class="details-page-pic-info-details">
					<div class="details-page-pic-info-details-title">
                        <?php if (!!$author): ?>
                    <span>@</span>
						<p><?php $author ?></p>
                    <?php endif; ?>
                       <p class="detailsV-page-pic-info-detailsV-p"><?php $description ?></p>
					</div>
					<div class="details-page-pic-info-details-upload">
						<span onClick="showContent()"></span>
					</div>
				</section>
			</section>
		</section>

		<section id="hidden-content" style="display: none">
			<section class="details-page-iphone">
				<section class="details-page-iphone-top">
					<input placeholder="请输入你的手机号码" />
					<div class="details-page-iphone-top-btn">
						<span> 马上预约 </span>
					</div>
				</section>
				<section class="details-page-iphone-bottom">
					<p>视频转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载</p>
				</section>
			</section>
			<section class="details-page-tab">
				<div>
					<span>装修技巧</span> <span>|</span> <span>英式田园</span>
				</div>
			</section>
			<section id="content" class="result-search-content"
				style="background: #edecec">
				<?php foreach ($data['data'] as $data_item): ?>

<section class="content-card" data-id="<?php echo $data_item['id']; ?>"
					data-res-type="<?php echo $data_item['res_type']; ?>">
					<div class="content-card-top">
						<?php if ($data_item['res_type'] == '0'): ?>
    					<div class="content-card-img">
							<img src="<?php echo $data_item['attach_url']; ?>" /> <label></label>
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
			</section>
			<div style="display: none;" id="template"></div>
			<section class="result-search-history" style="background: #edecec">
				<section class="result-search-history-top">
					<img src="/static/images/search.png" />
				</section>

				<section class="result-search-history-content"
					style="background: #edecec">
                <?php foreach ($term['data'] as $term_item): ?>
                	<span class="term"
						data-name="<?php echo $term_item['name']; ?>"
						data-id="<?php echo $term_item['id']; ?>"><?php echo $term_item['name']; ?></span>
                <?php endforeach; ?>
                <div style="clear: both"></div>
				</section>
			</section>
			<section class="result-bottom" style="background: #edecec">
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
		</section>
	</section>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script
	src="https://cdn.bootcss.com/masonry/2.1.07/jquery.masonry.min.js"></script>
<script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
function showContent(){
    var hiddenContent = $('#hidden-content');
    hiddenContent.css({
        'display':'block'
    })
    var $container = $('#content');    
    $container.imagesLoaded(function(){
        $container.masonry({
            itemSelector: '.content-card',
            columnWidth: 1 //每两列之间的间隙为5像素
        });
    });
}

</script>
<script>
      var mySwiper = new Swiper ('.swiper-container', {
    direction: 'horizontal', // 垂直切换选项
    loop: true, // 循环模式选项
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    
  })  
    function addMore(){
        var $container = $('#content');   
        var stringDom = `<section class="content-card">
                <div class="content-card-top">
                    <img src="/static/images/1.png"/>
                    <p>装修了大半年新建终于有点模样装修了大半年新建终于有点模装修了大半年新建终于有点模装修了大半年新建终于有点模了</p>
                </div>
                <section class="content-card-bottom">
                    <div class="content-card-bottom-save">
                        <label></label>
                        <span>8989</span>
                    </div>
                    <div class="content-card-bottom-love">
                        <label></label>
                        <span>79989</span>
                    </div>
                </section>
            </section>`
        for(var i = 0;i<5;i++){
            $container.append(stringDom)
            $container.masonry('reload');
        }
    }
        
$(function() {
}) .on('click','.content-card', function(){
	var id = $(this).data("id");
	var resType = $(this).data("res-type");
	if (resType == '0') {
		window.location.href = '/mobile/res_video/' + id;
	} else {
		window.location.href = '/mobile/res_album/' + id;
	}
});
        </script>
</html>