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
    <link rel="stylesheet" href="/static/css/videoDetails.css"></link>
</head>
<body>
    <section class="detailsV-page">
        <section class="detailsV-page-pic">
            <section class="detailsV-page-pic-bg">
                <span></span>
                <video poster="<?php echo $attach_url; ?>"   id="audio" playsinline="true" webkit-playsinline="true" x5-video-orientation="portraint" preload="auto" loop>
                    <source src="<?php echo $play_url; ?>" type="video/mp4">
                    您的浏览器不支持 video 标签。
                </video>
                <!-- <img id="videoBg" src="/static/images/videoBg.jpg"/> -->
                <label id="playLable" onclick="toPlay()"></label>
            </section>
            <section class="detailsV-page-pic-info-btns">
                <div class="detailsV-info-active">
                    <label></label>
                    <span>分享</span>
                </div>
                <div >
                    <label></label>
                    <span><?php if (!$like_count): ?>0<?php else: ?>$<?php $like_count ?><?php endif; ?></span>
                </div>
                <div >
                    <label></label>
                    <span><?php if (!$collect_count): ?>0<?php else: ?><?php $collect_count ?><?php endif; ?></span>
                </div>
                <div class="detailsV-info-active">
                    <label></label>
                    <span>报价</span>
                </div>
            </section>
            <section class="detailsV-page-pic-info-detailsV">
                <div class="detailsV-page-pic-info-detailsV-title">
                	<?php if (!!$author): ?>
                    <span>@</span>
                    <p><?php $author ?></p>
                    <?php endif; ?>
                </div>
                <p class="detailsV-page-pic-info-detailsV-p"><?php $description ?></p>
                <div class="detailsV-page-pic-info-detailsV-upload">
                    <span onClick="showContent()"></span>
                </div>
            </section>
        </section>
       
        <section id="hidden-content" style="display: none">
            <section class="detailsV-page-iphone">
                <section class="detailsV-page-iphone-top">
                    <input placeholder="请输入你的手机号码"/>
                    <div class="detailsV-page-iphone-top-btn">
                        <span>
                            装修预算先知道
                        </span>
                    </div>
                </section>
                <section class="detailsV-page-iphone-bottom">
                    <p>视频转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载</p>
                </section>
            </section>
            <section class="detailsV-page-tab">
                <div>
                    <span>装修技巧</span>
                    <span>|</span>
                    <span>英式田园</span>
                </div>
            </section>
            <section class="result-search-content" style="background:#edecec">
                <section class="content-card">
                    <div class="content-card-top">
                        <img src="/static/images/1.png"/>
                        <p>装修了大半年新建终于有点模样了</p>
                    </div>
                    <section class="content-card-bottom">
                        <div class="content-card-bottom-save-active">
                            <label></label>
                            <span>8989</span>
                        </div>
                        <div class="content-card-bottom-love-active">
                            <label></label>
                            <span>79989</span>
                        </div>
                    </section>
                </section>
                <section class="content-card">
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
                </section>
                <section class="content-card">
                    <div class="content-card-top">
                        <img src="/static/images/1.png"/>
                        <p>装修了大半年新建终于有点模样了</p>
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
                </section>
            </section>
            <section class="result-search-history" style="background:#edecec">
                <section class="result-search-history-top">
                    <img src="/static/images/search.png"/>
                </section>
                <section class="result-search-history-content" style="background:#edecec">
                    <span>客户装修效果</span>
                    <span>客户装修效果</span>
                    <span>客户装修效果</span>
                    <span>客户装修效果</span>
                    <div style="clear:both"></div>
                </section>
            </section>
            <section class="result-bottom" style="background:#edecec">
                <div class="tab-active">
                    <label></label>
                    <span>
                        首页
                    </span>
                </div>
                <div>
                    <span>
                        装修案例
                    </span>
                </div>
                <div>
                    <span>
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
    </section>
</body>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.slim.min.js"></script>
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
}
</script>
</html>