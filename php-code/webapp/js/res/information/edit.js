//Demo
layui.use([ 'form', 'upload' ], function() {
	var form = layui.form;
	var upload = layui.upload;
	var layedit = layui.layedit;
	// 表单初始化
	var id = sessionStorage.getItem("id");
	sessionStorage.setItem("id", '');

	// 监听提交
	form.on('submit(formDemo)', function(data) {
		var url = window.siteUrl + '/res/res_information/edit/' + id;
		submit(data, url);
		return false;
	});

	form.on('submit(publishDemo)', function(data) {
		$("#publish_status").val("1");
		var url = window.siteUrl + '/res/res_information/edit/' + id;
		submit(data, url);
		return false;
	});

	// 加载内容分类
	renderContentCategorySelect($("select[name='content_category_id']"));

	$.ajax({
		type : "GET",
		url : window.siteUrl + '/res/res_information/detail/' + id,
		dataType : "json",
		success : function(data, msg) {
			if (data.code == '1') {
				var result = data.data;
				form.val("image-form", {
					"id" : id,// "name": "value"
					"title" : result.title,
					"description" : result.description,
					"terms" : result.terms,
					"publish_type" : result.publish_type,
					"content_category_id" : result.content_category_id,
					"author" : result.author,
					"source" : result.source,
					"cover_id" : result.cover_id
				})
				if (result.publish_status != '1') {
					$("#save").show();
				}
				$("#save_publish").show();
				// 初始化图集

				var image = result.image;
				if (!!image) {
					// 把背景色设置为透明
					$(".left button").css("background", 'transparent');
					$(".left img ").css("background", 'transparent');
					$(".left button ").text('');

					$('#demo1').attr('src', image.attach_url);
					$('[ name="images.id"]').val(image.id);
					$('[ name="images.attach_path"]').val(image.attach_path);
					$('[ name="images.attach_suffix"]')
							.val(image.attach_suffix);
					$('[ name="images.attach_name"]').val(image.attach_name);
				}
				
				// 富文本框
				layEditIndex = layedit.build('description', {
					tool : [ 'strong' // 加粗
					, 'italic' // 斜体
					, 'underline' // 下划线
					, 'del' // 删除线
					, '|' // 分割线
					, 'left' // 左对齐
					, 'center' // 居中对齐
					, 'right' // 右对齐
					, 'link' // 超链接
					, 'unlink' // 清除链接
					, 'face' // 表情
					]
				}); // 建立编辑器
				
				
				setTimeout(function() {
					form.val("image-form", {
						"content_category_id" : result.content_category_id,
					})
				}, 300);
			} else {
				layer.msg("加载数据失败--" + data.msg);
				setTimeout(function() {
					window.history.go(-1);
				}, 1000);
			}
		}

	});

	// 普通图片上传
	var uploadInst = upload.render({
		elem : '#test1',
		url : window.siteUrl + '/upload_oss/upload/img',
		before : function(obj) {
			layer.load(); // 上传loading
		},
		done : function(res) {
			// 如果上传失败
			if (res.code == 1) {
				var data = res.data;
				// 把背景色设置为透明
				$(".left button").css("background", 'transparent');
				$(".left img ").css("background", 'transparent');
				$(".left button ").text('');

				$('#demo1').attr('src', data.file_url);
				$('[ name="images.attach_path"]').val(data.file_path);
				$('[ name="images.attach_suffix"]').val(data.file_type);
				$('[ name="images.attach_name"]').val(data.file_name);
			} else {
				layer.msg(res.msg)
			}
			layer.closeAll('loading'); // 关闭loading
		},
		error : function() {
			layer.closeAll('loading'); // 关闭loading
		}
	});

	function submit(data, url) {
		layedit.sync(layEditIndex)
		if (!$(".left img").attr('src')) {
			layer.msg("请上传封面图");
			return false;
		}
		var arr = $("#form").serializeArray();
		data = formatForm(arr);
		$.ajax({
			type : "POST",
			url : url,
			dataType : "json",
			data : JSON.stringify(data),
			success : function(data, msg) {
				if (data.code == '1') {
					layer.msg("操作成功");
					setTimeout(function() {
						window.location.href = window.siteUrl
								+ '/webapp/pages/res/information/index.html';
					}, 1000)
				} else {
					layer.msg("操作失败");
				}
			}

		});
	}

	function formatForm(arr) {
		var images = new Array();
		var count = -1;
		var data = {};// 创建一个空的对象 以便装数组数据
		$.each(arr, function(index, it) {// index为数组的下标 it为数组对应的数据对象
			// 图片对象
			if (it.name.indexOf("images.is_cover") != -1) {
				count++;
				images[count] = {};
			}
			if (it.name.indexOf("images") != -1) {
				var name = it.name.substr(7);
				var value = it.value;
				images[count][name] = value;
			} else {
				data[it.name] = it.value;
			}
		})
		data['images'] = images;
		return data;
	}

	function renderContentCategorySelect($select) {
		$.ajax({
			type : "GET",
			url : window.siteUrl + '/dic/dic_content_category/get_list',
			dataType : "json",
			success : function(data, msg) {
				if (data.code == '1') {
					var result = data.data;
					$select.html("");
					$select.append("<option value=''></option>");
					for ( var i in result) {
						$select
								.append("<option value='" + result[i].id + "'>"
										+ result[i].content_category_name
										+ "</option>");
					}
					form.render('select');
				} else {
					layer.msg("加载内容分类数据失败，请刷新页面--" + data.msg);
				}
			}

		});
	}
});
$(document).ready(function() {
}).on('mouseover', '#test1', function() {
	if (!!$(".left img").attr('src')) {
		$("#bigImg").show();
		$("#bigImg img").attr('src', $(".left img").attr('src'));
	}
}).on('mouseout', '#test1', function() {
	$("#bigImg").hide();
});