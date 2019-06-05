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
	window.location.href = '/mobile/result/' + type + '?term_id=' + id;
});