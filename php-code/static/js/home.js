$(function() {
	var $container = $('#content');
	$container.imagesLoaded(function() {
		$container.masonry({
			itemSelector : '.content-card',
			columnWidth : 1
		// 每两列之间的间隙为5像素
		});
	});
}).on('click', '.tab', function() {
	$('.tab').each(function() {
		$(this).removeClass("tab-active");
	})
	$(this).addClass("tab-active");
	var type = $(this).data("value");
	window.location.href = '/mobile/home/' + type;
}).on('keypress', '#search', function(e) {
	var keycode = e.keyCode;
	var searchName = $(this).val();
	if (keycode == '13') {
		window.location.href = '/mobile/result?title=' + searchName;
	}
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
		});
	});
}).on('click', '.content-card', function() {
	var id = $(this).data("id");
	var resType = $(this).data("res-type");
	if (resType == '0') {
		window.location.href = '/mobile/res_video/' + id;
	} else {
		window.location.href = '/mobile/res_album/' + id;
	}
});

$(window).scroll(function(){
    var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();
    if(scrollTop + windowHeight == scrollHeight){
    	$(".get-more-list").click();
    }
})

