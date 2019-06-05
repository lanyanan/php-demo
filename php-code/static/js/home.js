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
});
