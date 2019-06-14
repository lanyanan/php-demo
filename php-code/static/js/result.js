$(function(){
	var $container = $('#content');
	$container.imagesLoaded(function() {
		$container.masonry({
			itemSelector : '.content-card',
			columnWidth : 1
		// 每两列之间的间隙为5像素
		});
	});
}).on('click', '.tab', function(){
	$('.tab').each(function(){
		$(this).removeClass("tab-active");
	})
	$(this).addClass("tab-active");
	var type = $(this).data("value");
	var title = $("#title").val();
	window.location.href = '/mobile/result/' + type + '?title=' + title;
}).on('click', '.term', function(){
	var type = $("#type").val();
	var id = $(this).data("id");
	var name = $(this).data("name");
	var page = $("#page").val();
	var limit = $("#limit").val();
	window.location.href = '/mobile/result/' + type + '?term_id=' + id + '&term_name='+ name + '&page=' + page + '&limit=' + limit;
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

$(window).scroll(function(){
    var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();
    if(scrollTop + windowHeight == scrollHeight){
    	$(".get-more-list").click();
    }
})
