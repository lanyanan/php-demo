<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title><?php echo $description; ?>-<?php echo $terms; ?>-自在家(zizaiplus)-自在新奇之美在家里！</title>
<meta name="keywords" content="<?php echo $description; ?>-<?php echo $terms; ?>-自在家(zizaiplus)-自在新奇之美在家里！">
<meta name="description" content="<?php echo $description; ?>-<?php echo $terms; ?>-自在家(zizaiplus)-自在新奇之美在家里！装修案例,装修报价,装修效果图,室内装修,装修视频">
<link rel="stylesheet" href="/static/css/videoDetails.css"></link>
</head>
<body>
	<section class="detailsV-page">
		<section class="detailsV-page-pic">
			<section class="detailsV-page-pic-bg">
				<span onclick="window.history.back(-1);"></span>
				<video poster="<?php echo $attach_url; ?>" id="audio"
					playsinline="true" webkit-playsinline="true"
					x5-video-orientation="portraint" preload="auto" loop>
					<source src="<?php echo $play_url; ?>" type="video/mp4">
					您的浏览器不支持 video 标签。
				</video>
				<!-- <img id="videoBg" src="/static/images/videoBg.jpg"/> -->
				<label id="playLable" onclick="toPlay()"></label>
			</section>
			<section class="detailsV-page-pic-info-btns">
				<div class="detailsV-info-active">
					<label></label> <span>分享</span>
				</div>
				<div>
					<label></label> <span><?php if (!$like_count): ?>0<?php else: ?>$<?php $like_count ?><?php endif; ?></span>
				</div>
				<div>
					<label></label> <span><?php if (!$collect_count): ?>0<?php else: ?><?php $collect_count ?><?php endif; ?></span>
				</div>
				<div class="detailsV-info-active">
					<label></label> <span>报价</span>
				</div>
			</section>
			<section class="detailsV-page-pic-info-detailsV">
				<div class="detailsV-page-pic-info-detailsV-title">
                	<!--<?php if (!!$author): ?>
                    <span>@</span>
					<p><?php  echo  $author; ?></p>
                    <?php endif; ?>-->
                </div>
				<p class="detailsV-page-pic-info-detailsV-p"><?php  echo $description; ?></p>
				<div class="detailsV-page-pic-info-detailsV-upload">
					<span onClick="showContent()"></span>
				</div>
			</section>
		</section>

		<section id="hidden-content" style="display: none">
			<section class="detailsV-page-iphone">
				<section class="detailsV-page-iphone-top">
					<input placeholder="请输入你的手机号码" />
					<div class="detailsV-page-iphone-top-btn">
						<span> 装修预算先知道 </span>
					</div>
				</section>
				<section class="detailsV-page-iphone-bottom">
					<p>视频转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载</p>
				</section>
			</section>
			<section class="detailsV-page-tab">
				<div>
					<span>装修技巧</span> <span>|</span> <span>英式田园</span>
				</div>
			</section>
			<section id="content" class="result-search-content"
				style="background: #edecec">
            <?php foreach ($data['data'] as $data_item): ?>

<section class="content-card" data-id="<?php echo $data_item['id']; ?>"
					data-res-type="<?php echo $data_item['res_type']; ?>">
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
						data-id="<?php echo $term_item['id']; ?>"><a title="<?php echo $term_item['name']; ?>" href="<?php echo site_url('/mobile/result?term_id='.$term_item['id'] .'&term_name='.$term_item['name']); ?>"><?php echo $term_item['name']; ?></a></span>
                <?php endforeach; ?>
                <div style="clear: both"></div>
				</section>
			</section>
			<section class="result-bottom" style="background: #edecec">
				<div class="tab-active">
					<label></label> <span  class="home"> <a title="首页" href="<?php echo site_url('/mobile/home'); ?>">首页</a> </span>
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
	</section>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script
	src="https://cdn.bootcss.com/masonry/2.1.07/jquery.masonry.min.js"></script>
	<script src="/static/js/common.js"></script>
<script>

function toPlay() {
    var audio = document.getElementById("audio");
    audio.setAttribute("style","display:block");
    var lable = $("#playLable");
    lable.css({
        'display':'none'
    })
    var audioPlay = audio.play();

}
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
</html>