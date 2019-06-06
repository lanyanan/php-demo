$(function(){
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
		$(".home-search-content").append($("#template").html());
		$("#template").html("");
		$this.remove();
	});
}).on('click','.content-card', function(){
	var id = $(this).data("id");
	var resType = $(this).data("res-type");
	if (resType == '0') {
		window.location.href = '/mobile/res_video/' + id;
	} else {
		window.location.href = '/mobile/res_album/' + id;
	}
});
