$(function() {
	var $container = $('#content');
	$('.loading').css({
		display:'block'
	})
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
}).on('keypress', '#search', function(e) {
	var keycode = e.keyCode;
	var searchName = $(this).val();
	if (keycode == '13') {
		window.location.href = '/mobile/result?title=' + searchName;
	}
}).on('touchstart', '.loading', function(e) {
	console.log(e)
	e.preventDefault();
	e.stopPropagation();
}).on('click', '.get-more-list', function() {
	$this = $(this);
	$href = $this.data('href');
	$("#template").load($href, function() {
		var html = $("#template").html()
		$("#content").append(html);
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
	console.log(scrollTop,scrollHeight,windowHeight)
	var navTop = $('.home-page-logo').height()+$('.home-page-search').height()+$('.home-page-tab').height();
    if(scrollTop + windowHeight == scrollHeight){
		$(".get-more-list").click();
		$('.loading').css({
			display:'block'
		})
	}
	console.log(scrollTop,navTop)
	if(scrollTop>navTop){
		$('.home-page-tab-fixed').css({
			display:'flex'
		})
	}else{
		$('.home-page-tab-fixed').css({
			display:'none'
		})
	}
})


$('.home-page').scroll(function(){
	var scrollTop = $(this).scrollTop();var scrollHeight = $('.home-search-content masonry').height();var windowHeight = $(this).height();
	console.log(scrollTop,scrollHeight,windowHeight)
	
})

