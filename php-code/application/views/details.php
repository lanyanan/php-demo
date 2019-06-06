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
    <link rel="stylesheet" href="/static/css/details.css"></link>
</head>
<body>
    <section class="details-page">
        <section class="details-page-pic">
            <section class="details-page-pic-bg">
                <span></span>
                <img src="/static/images/pic.png"/>
            </section>
            <section class="details-page-pic-info">
                <section class="details-page-pic-info-btns">
                    <div class="details-info-active">
                        <label></label>
                        <span>分享</span>
                    </div>
                    <div >
                        <label></label>
                        <span>1890</span>
                    </div>
                    <div >
                        <label></label>
                        <span>1890</span>
                    </div>
                    <div class="details-info-active">
                        <label></label>
                        <span>报价</span>
                    </div>
                </section>
                <section class="details-page-pic-info-details">
                    <div class="details-page-pic-info-details-title">
                        <span>@</span>
                        <p>金地新家</p>
                    </div>
                    <p class="details-page-pic-info-details-p"><span>1/6</span>欧式沙发，欧式沙发，欧式沙发欧式沙发</p>
                    <div class="details-page-pic-info-details-upload">
                        <span onClick="showContent()"></span>
                    </div>
                </section>
            </section>
        </section>
       
        <section id="hidden-content" style="display: none">
            <section class="details-page-iphone">
                <section class="details-page-iphone-top">
                    <input placeholder="请输入你的手机号码"/>
                    <div class="details-page-iphone-top-btn">
                        <span>
                            马上预约
                        </span>
                    </div>
                </section>
                <section class="details-page-iphone-bottom">
                    <p>视频转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载转载至官方网站没有允许请勿转载</p>
                </section>
            </section>
            <section class="details-page-tab">
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
function showContent(){
        var hiddenContent = $('#hidden-content');
        hiddenContent.css({
            'display':'block'
        })
}
</script>
</html>