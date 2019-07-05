$(function(){
	var $container = $('#content');
	$container.imagesLoaded(function() {
		$container.masonry({
			itemSelector : '.content-card',
			columnWidth : 1
		// 每两列之间的间隙为5像素
		});
		$('.loading').css({
			display:'none'
		})
	});
}).on('click','.get-more-list', function() {
	$this = $(this);
	$href = $this.data('href');
	$("#template").load($href, function(){
		$("#content").append($("#template").html());
		$("#template").html("");
		$this.remove();
		$('#content').imagesLoaded(function() {
			$('#content').masonry('reload');
			$('.loading').css({
				display:'none'
			})
		});
	});
});

$(window).scroll(function(){
    var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();
    if(scrollTop + windowHeight == scrollHeight){
    	$(".get-more-list").click();
    }
})



$('.result-page').scroll(function(){
	var arr="<?php echo $data_item;?>"
	
	var scrollTop = $(this).scrollTop();
	var scrollHeight = $('.result-search-content').outerHeight(true);
	var windowHeight = $(this).height();
	var bottomBox = $('.result-bottom').outerHeight(true);
	var scrollHeightLogo = $('.result-page-logo').outerHeight(true);
	var scrollHeightTab = $('.result-page-tab').outerHeight(true);
	var scrollHeightHistory = $('.result-search-history').outerHeight(true);
	var status = $('.content-card')?$('.content-card').length:"";
	console.log(status)
    // var scrollHeightSearch = $('.result-bottom').outerHeight(true);

    // var navTop = $('.result-page-logo').height()+$('.result-page-search').height()+$('.result-page-tab').outerHeight(true);
    console.log(parseInt(scrollTop+windowHeight),parseInt(scrollHeight+scrollHeightLogo+scrollHeightTab+bottomBox+scrollHeightHistory))
	if((parseInt(scrollTop+windowHeight)>parseInt(scrollHeight+scrollHeightLogo+scrollHeightTab+bottomBox+scrollHeightHistory))&&status&&status>=10) {
		$(".get-more-list").click();
		$('.loading').css({
			display:'flex'
		})
	}

	// if(scrollTop>navTop){
	// 	$('.home-page-tab-fixed').css({
	// 		display:'flex'
	// 	})
	// }else{
	// 	$('.home-page-tab-fixed').css({
	// 		display:'none'
	// 	})
	// }
	
})