$(function(){
}).on('click', '.tab', function(){
	$('.tab').each(function(){
		$(this).removeClass("tab-active");
	})
	$(this).addClass("tab-active");
	var type = $(this).data("value");
	window.location.href = '/mobile/home/' + type;
}).on('keypress', '#search', function(e) {
    var keycode = e.keyCode;
    var searchName = $(this).val();
    if(keycode=='13') {
    	window.location.href = '/mobile/result?title='+ searchName;
    }
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

