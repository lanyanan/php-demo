window.siteUrl = '';
window.baseUrl = 'http://10.0.31.40';
// 解码
function decodeUnicode(str) {
	str = str.replace(/\\/g, "%");
	return unescape(str);
}
(function($) {
	// 首先备份下jquery的ajax方法
	var _ajax = $.ajax;

	// 重写jquery的ajax方法
	$.ajax = function(opt) {
		// 备份opt中error和success方法
		var fn = {
			error : function(XMLHttpRequest, textStatus, errorThrown) {
			},
			success : function(data, textStatus) {
			}
		}
		if (opt.error) {
			fn.error = opt.error;
		}
		if (opt.success) {
			fn.success = opt.success;
		}

		// 扩展增强处理
		var _opt = $.extend(opt, {
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				// 错误方法增强处理
				fn.error(XMLHttpRequest, textStatus, errorThrown);
			},
			success : function(data, textStatus) {
				// 成功回调方法增强处理,如果返回码是101，说明没有登录
				if (data.code == '101') {
					layer.msg("用户未登录");
					setTimeout(function() {
						top.window.location.href = window.siteUrl + '/login'
					}, 500);
					return;
				}
				fn.success(data, textStatus);
			},
			beforeSend : function(XHR) {
				var token = localStorage.getItem("token");
				XHR.setRequestHeader("token", token);
			},
			complete : function(XHR, TS) {
				// 请求完成后回调函数 (请求成功或失败之后均调用)。
				$("#ajaxInfo").remove();
				;
			}
		});
		return _ajax(_opt);
	};

})(jQuery);

layui.define([ 'jquery' ], function(exports) {
	var $ = layui.jquery;
	// 首先备份下jquery的ajax方法
	var _ajax = $.ajax;
	// 重写jquery的ajax方法
	$.ajax = function(opt) {
		// 备份opt中error和success方法
		var fn = {
			error : function(XMLHttpRequest, textStatus, errorThrown) {
			},
			success : function(data, textStatus) {
			}
		}
		if (opt.error) {
			fn.error = opt.error;
		}
		if (opt.success) {
			fn.success = opt.success;
		}

		// 扩展增强处理
		var _opt = $.extend(opt, {
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				// 错误方法增强处理
				fn.error(XMLHttpRequest, textStatus, errorThrown);
			},
			success : function(data, textStatus) {
				// 成功回调方法增强处理,如果返回码是101，说明没有登录
				if (data.code == '101') {
					layer.msg("用户未登录");
					setTimeout(function() {
						top.window.location.href = window.siteUrl + '/login'
					}, 500);
					return;
				}
				fn.success(data, textStatus);
			},
			beforeSend : function(XHR) {
				var token = localStorage.getItem("token");
				XHR.setRequestHeader("token", token);
			},
			complete : function(XHR, TS) {
				// 请求完成后回调函数 (请求成功或失败之后均调用)。
				$("#ajaxInfo").remove();
				;
			}
		});
		return _ajax(_opt);
	};

});

