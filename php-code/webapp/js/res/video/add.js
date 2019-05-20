//Demo
layui.use([ 'form', 'upload' ], function() {
	var form = layui.form;
	var upload = layui.upload;
	var player = videojs('example_video_1',{
	    muted: true,
		controls : true,      
		height:300, 
		width:300,
		loop : false,
	});
	// 监听提交
	form.on('submit(formDemo)', function(data) {
		var url = window.siteUrl + '/res/res_video/add';
		submit(data, url);
		return false;
	});
	
	form.on('submit(publishDemo)', function(data) {
		var url = window.siteUrl + '/res/res_video/add/publish';
		submit(data, url);
		return false;
	});
	
	//加载内容分类
	renderContentCategorySelect($("select[name='content_category_id']"));
	
	//加载户型
	var houseTypeParentId = '0';
	renderHourseSelect( $("select[name='house_type_1']"), houseTypeParentId);
	// 户型级联操作
	form.on('select(house_type_1)', function (data) {
		houseTypeParentId = data.value;
		$("input[name='house_type_id']").val(houseTypeParentId);
		if (houseTypeParentId != '1') {
			$("select[name='house_type_2']").attr('disabled',false);
			renderHourseSelect( $("select[name='house_type_2']"), houseTypeParentId);
		} else {
			$("select[name='house_type_2']").html("");
			$("select[name='house_type_2']").attr("disabled",true);
			form.render('select');
		}
    });
	form.on('select(house_type_2)', function (data) {
		$("input[name='house_type_id']").val(data.value);
	})
	
	//加载城市
	var districtParentId = '0';
	renderDistrictSelect( $("select[name='district_1']"), districtParentId, "请选择省份");
	// 城市级联操作
	form.on('select(district_1)', function (data) {
		districtParentId = data.value;
		$("select[name='district_2']").attr('disabled',false);
		renderDistrictSelect( $("select[name='district_2']"), districtParentId, "请选择城市");
    });
	form.on('select(district_2)', function (data) {
		$("input[name='district_id']").val(data.value);
	})

	

	upload.render({
		elem : '#test5',
		url : window.siteUrl + '/upload_oss/upload/video',
		accept : 'video', // 视频
		before : function(obj) { // obj参数包含的信息，跟 choose回调完全一致，可参见上文。
			layer.load(); // 上传loading
			//预读本地文件示例，不支持ie8
            window['objs'] = obj;
		},
		done : function(res) {
			layer.closeAll('loading'); // 关闭loading
			layer.msg(res.msg)
			if (res.code == 1) {
				var data = res.data;
				if ($("#uploadVideoFlag").val() == '0') {
					$('.layui-form').append(
							'<input type="hidden" name="attach_name" value="'
									+ data.file_name
									+ '">');
					$('.layui-form').append(
							'<input type="hidden" name="attach_suffix" value="'
									+ data.file_type
									+ '">');
					$('.layui-form').append(
							'<input type="hidden" name="attach_path" value="'
									+ data.file_path
									+ '">');
					$("#uploadVideoFlag").val("1")
				} else {
					$("input[name='attach_name']").val(data.file_name);
					$("input[name='attach_suffix']").val(data.file_type);
					$("input[name='attach_path']").val(data.file_path);
				}
				player.src({src: data.file_url, type: data.file_type});
			}
		},
		error : function(index, upload) {
			layer.closeAll('loading'); // 关闭loading
		}
	});
	
	function submit(data, url) {
		data = JSON.stringify(data.field);
		 if ($("#uploadVideoFlag").val() == '0') {
			 layer.msg("请上传视频");
			 return false;
		 }
		 $.ajax({
	          type: "POST",
	          url: url,
	          dataType: "json",
	          data: data,
	          success: function (data, msg) {
	        	  if (data.code == '1') {
	        		  layer.msg("新增成功");
	        		  setTimeout(function() {
	        			  window.location.href = window.siteUrl + '/webapp/pages/res/video/index.html';
	        		  },1000)
	        	  } else {
	        		  layer.msg("新增失败");
	        	  }
	          }

	      });
	}
	
	function renderHourseSelect($select, houseTypeParentId) {
		$.ajax({
			type : "GET",
			url : window.siteUrl + '/dic/dic_house_type/get_list_by_parent/' + houseTypeParentId,
			dataType : "json",
			success : function(data, msg) {
				if (data.code == '1') {
					var result = data.data;
					$select.html("");
					$select.append("<option value=''>请选择</option>");
					for (var i in result) {
						$select.append("<option value='"+result[i].id+"'>"+result[i].house_type_name+"</option>");
					}
					form.render('select');
				} else {
					layer.msg("加载户型数据失败，请刷新页面--" + data.msg);
				}
			}

		});
	}
	
	function renderDistrictSelect($select, districtParentId, description) {
		$.ajax({
			type : "GET",
			url : window.siteUrl + '/dic/dic_district/get_list_by_parent/' + districtParentId,
			dataType : "json",
			success : function(data, msg) {
				if (data.code == '1') {
					var result = data.data;
					$select.html("");
					$select.append("<option value=''>"+description+"</option>");
					for (var i in result) {
						$select.append("<option value='"+result[i].id+"'>"+result[i].name+"</option>");
					}
					form.render('select');
				} else {
					layer.msg("加载城市数据失败，请刷新页面--" + data.msg);
				}
			}

		});
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
					for (var i in result) {
						$select.append("<option value='"+result[i].id+"'>"+result[i].content_category_name+"</option>");
					}
					form.render('select');
				} else {
					layer.msg("加载内容分类数据失败，请刷新页面--" + data.msg);
				}
			}

		});
	}
});
