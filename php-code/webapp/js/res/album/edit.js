//Demo
layui.use([ 'form', 'upload' ], function() {
	var form = layui.form;
	var upload = layui.upload;
	// 表单初始化
	var id = sessionStorage.getItem("id");
	sessionStorage.setItem("id", '');

	//加载内容分类
	renderContentCategorySelect($("select[name='content_category_id']"));
	
	// 加载风格分类
	renderStyleSelect($("select[name='style']"));
	
	// 加载户型
	renderHourseSelect( $("select[name='house_type_id']"));
	// 加载空间
	renderSpaceSelect( $("select[name='house_space_id']"));
	var selectHtml = "";
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
	
		$.ajax({
		type : "GET",
		url : window.siteUrl + '/res/res_album/detail/' + id,
		dataType : "json",
		success : function(data, msg) {
			if (data.code == '1') {
				var result = data.data;
				form.val("album-form", {
					"id" : id ,// "name": "value"
					"title" : result.title,
					"description" : result.description,
					"terms" : result.terms,
					"publish_type" : result.publish_type,
					"content_category_id" : result.content_category_id,
					"author" : result.author,
					"house_type_id" : result.house_type_id,
					"floor_area" : result.floor_area,
					"district_id" : result.district_id,
					"building" : result.building,
					"cost" : result.cost,
					"style" : result.style,
					"source" : result.source,
				})
				if (result.publish_status != '1') {
					$("#save").show();
				}
				$("#save_publish").show();
				// 初始化户型
				
				if (!!result.district_id) {
					//初始化表单城市
					renderDistrictSelect($("select[name='district_2']"), result.districtPid);
					setTimeout(function(){
						form.val("album-form", {
							"district_1" : result.districtPid,
							"district_2" : result.district_id,
						})
					},500);
				}
				//初始化图集
				initImages(result.images);
			} else {
				layer.msg("加载数据失败--" + data.msg);
				setTimeout(function() {
					window.history.go(-1);
				}, 1000);
			}
		}

	});
	
	// 监听提交
	form.on('submit(saveDemo)', function(data) {
		var url = window.siteUrl + '/res/res_album/edit/' + id;
		submit(data, url);
		return false;
	});

	form.on('submit(publishDemo)', function(data) {
		$("#publish_status").val("1");
		var url = window.siteUrl + '/res/res_album/edit/'+id;
		submit(data, url);
		return false;
	});

	upload.render({
		elem : '#test2',
		url : window.siteUrl + '/upload_oss/upload/img',
		multiple: true,
		before : function(obj) { // obj参数包含的信息，跟 choose回调完全一致，可参见上文。
			layer.load(); // 上传loading
		},
		done : function(res) {
			layer.closeAll('loading'); // 关闭loading
			var isCover = 0;
			// 第一次提交把table清空
			if (res.code == 1) {
				if ($("#fristUpload").val() == '0') {
					$("#tbody").html("");
					$("#fristUpload").val("1");
				}
				data = res.data;
				$("#tbody").append('                                                                                                                            '+
					'	<tr>                                                                                                                                    '+
					'	<td align="center">                                                                                                                     '+
					'		<div class="imgDiv"><img class="layui-upload-img" src="'+data.file_url+'">  </div>                                                                                                    '+
					'	</td>                                                                                                                                   '+
					'	<input type="hidden" name="images.is_cover" value="'+isCover+'"/>                                                                                           '+
					'	<input type="hidden" name="images.attach_path" value="'+data.file_path+'"/>                                                                                        '+
					'	<input type="hidden" name="images.attach_suffix" value="'+data.file_type+'"/>                                                                                      '+
					'	<input type="hidden" name="images.attach_name" value="'+data.file_name+'"/>                                                                                        '+
					'	<td align="center">                                                                                                                     '+
					'		<input type="text" name="images.space_name" required                                                                                '+
					'			lay-verify="required" placeholder="请输入" autocomplete="off"  value="'+data.original_name+'"                                                                 '+
					'			class="layui-input"/>                                                                                                  '+
					'	</td>                                                                                                                                   '+
					'	<td align="center">                                                                                                                     '+
					'		<textarea name="images.description"                                                                                                 '+
					'			placeholder="请输入内容" class="layui-textarea" required lay-verify="required">                                                                       '+
					'		</textarea>                                                                                                                         '+
					'	</td>                                                                                                                                   '+
					'	<td align="center" class="operator">                                                                                                    '+
					'		<div class="layui-btn-group">                                                                                                       '+
					'			<button lay-filter="set_cover"  type="button"                                                                                 '+
					'				class="set_cover layui-btn "  ><i class="layui-icon">&#xe605;</i>设为封面图</button>            '+
					'			<button lay-filter="move_up"   type="button"                                                                                      '+
					'				class="move_up layui-btn "  ><i class="layui-icon">&#xe619;</i>上移</button>                  '+
					'			<button  lay-filter="move_down"  type="button"                                                                                   '+
					'				class="move_down layui-btn "  ><i class="layui-icon">&#xe61a;</i>下移</button>                  '+
					'			<button lay-filter="delete"     type="button"                                                                                      '+
					'				class="delete layui-btn "><i class="layui-icon">&#xe640;</i>删除</button>                  '+
					'		</div>                                                                                                                              '+
					'	</td>                                                                                                                                   '+
					'</tr>');
				
					renderTable();
				
			} else {
				layer.msg(res.msg);
			}
		},
		error : function(index, upload) {
			layer.closeAll('loading'); // 关闭loading
		}
	});
	
	function initImages(images) {
		if ($("#fristUpload").val() == '0') {
			$("#tbody").html("");
			$("#fristUpload").val("1");
		}
		for(var i in images) {
			$("#tbody").append('                                                                                                                            '+
					'	<tr>                                                                                                                                    '+
					'	<td align="center">                                                                                                                     '+
					'		<div class="imgDiv"><img class="layui-upload-img" src="'+images[i].attach_url+'">  </div>                                                                                                    '+
					'	</td>                                                                                                                                   '+
					'	<input type="hidden" name="images.is_cover" value="'+images[i].is_cover+'"/>                                                                                           '+
					'	<input type="hidden" name="images.id" value="'+images[i].id+'"/>                                                                                           '+
					'	<input type="hidden" name="images.is_delete" />                                                                                           '+
					'	<input type="hidden" name="images.attach_path" value="'+images[i].attach_path+'"/>                                                                                        '+
					'	<input type="hidden" name="images.attach_suffix" value="'+images[i].attach_suffix+'"/>                                                                                      '+
					'	<input type="hidden" name="images.attach_name" value="'+images[i].attach_name+'"/>                                                                                        '+
					'	<td align="center">                                                                                                                     '+
					'		<input type="text" name="images.space_name" required                                                                                '+
					'			lay-verify="required" placeholder="请输入" autocomplete="off"  value="'+images[i].space_name+'"                                                                 '+
					'			class="layui-input"/>                                                                                                  '+
					'	</td>                                                                                                                                   '+
					'	<td align="center">                                                                                                                     '+
					'		<textarea name="images.description"                                                                                                 '+
					'			placeholder="请输入内容" class="layui-textarea" required lay-verify="required" >'+images[i].description+''+
					'</textarea>                                                                                                                         '+
					'	</td>                                                                                                                                   '+
					'	<td align="center" class="operator">                                                                                                    '+
					'		<div class="layui-btn-group">                                                                                                       '+
					'			<button lay-filter="set_cover"  type="button"                                                                                 '+
					'				class="set_cover layui-btn "  ><i class="layui-icon">&#xe605;</i>设为封面图</button>            '+
					'			<button lay-filter="move_up"   type="button"                                                                                      '+
					'				class="move_up layui-btn "  ><i class="layui-icon">&#xe619;</i>上移</button>                  '+
					'			<button  lay-filter="move_down"  type="button"                                                                                   '+
					'				class="move_down layui-btn "  ><i class="layui-icon">&#xe61a;</i>下移</button>                  '+
					'			<button lay-filter="delete"     type="button"                                                                                      '+
					'				class="delete layui-btn "><i class="layui-icon">&#xe640;</i>删除</button>                  '+
					'		</div>                                                                                                                              '+
					'	</td>                                                                                                                                   '+
					'</tr>');
		}
		renderTable();
		initCover();
	}

	function submit(data, url) {
		if ($("#tbody tr").length < 1 || $("#tbody tr").find('img').attr('src') == '') {
			layer.msg("请至少上传一张图片");
			return false;
		}
		var arr = $("#form").serializeArray();
		data = formatForm(arr);
		 $.ajax({
	          type: "POST",
	          url: url,
	          dataType: "json",
	          data: JSON.stringify(data),
	          success: function (data, msg) {
	        	  if (data.code == '1') {
	        		  layer.msg("编辑成功");
	        		  setTimeout(function() {
	        			  window.location.href = window.siteUrl + '/webapp/pages/res/album/index.html';
	        		  },1000)
	        	  } else {
	        		  layer.msg("编辑失败");
	        	  }
	          }

	      });
	}
	
	function formatForm(arr) {
		var images =new Array();
		var count = -1;
		var data = {};//创建一个空的对象 以便装数组数据
		 $.each(arr,function(index,it){//index为数组的下标 it为数组对应的数据对象 
			 //图片对象
			 if (it.name.indexOf("images.is_cover") != -1) {
				 count++;
				 images[count] = {};
			 }
			 if ( it.name.indexOf("images") != -1 ) {
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
	
	function renderHourseSelect($select) {
		$.ajax({
			type : "GET",
			url : window.siteUrl + '/dic/dic_house_type/get_list',
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
	function renderSpaceSelect($select) {
		$.ajax({
			type : "GET",
			url : window.siteUrl + '/dic/dic_house_space/get_list',
			dataType : "json",
			success : function(data, msg) {
				if (data.code == '1') {
					var result = data.data;
					$select.html("");
					$select.append("<option value=''>请选择</option>");
					for (var i in result) {
						$select.append("<option value='"+result[i].id+"'>"+result[i].house_space_name+"</option>");
					}
					selectHtml = $("#imgTdSelect").html();
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
	function renderStyleSelect($select) {
		$.ajax({
			type : "GET",
			url : window.siteUrl + '/dic/dic_style/get_list',
			dataType : "json",
			success : function(data, msg) {
				if (data.code == '1') {
					var result = data.data;
					$select.html("");
					$select.append("<option value=''></option>");
					for (var i in result) {
						$select.append("<option value='"+result[i].id+"'>"+result[i].style_name+"</option>");
					}
					form.render('select');
				} else {
					layer.msg("加载内容分类数据失败，请刷新页面--" + data.msg);
				}
			}

		});
	}
});

$(document).ready(function(){
}).on('click','.delete',function() {
	$(this).closest("tr").hide();
	$(this).closest("tr").find("input[name='images.is_delete']").val('1');
	renderTable();
}).on('click','.move_up',function() {
	$tr = $(this).closest("tr");
	$tr.insertBefore($tr.prev());
	renderTable();
}).on('click','.move_down',function() {
	$tr = $(this).closest("tr");
	$tr.insertAfter($tr.next());
	renderTable();
}).on('click', '.set_cover', function(){
	$tr = $(this).closest("tr");
	//遍历把其他封面图清空
	$('#tbody tr').each(function(){
		if ($(this).find('.set_cover').length == 0) {
			$(this).find('.layui-btn-group').prepend('button lay-filter="set_cover"  type="button"                                                                                 '+
					'				class="set_cover layui-btn "  ><i class="layui-icon">&#xe605;</i>设为封面图</button>           ');
		}
		$(this).find('input[name="images.is_cover"]').val("0");
		$(this).find(".cover").remove();
	})
	//删除自己的封面图
	$(this).find('.set_cover').remove();
	$tr.find('input[name="images.is_cover"]').val("1");
	$tr.find('.imgDiv').append("<img class='layui-upload-img cover' src='/webapp/img/cover.png' />");
	
}).on('click', '.layui-upload-img', function(){
	$("#bigImg").show(); 
	$("#bigImg img").attr('src', $(this).attr('src'));
}).on('click', '#bigImg', function(){
	$("#bigImg").hide();
});

function initCover() {
	$("#tbody tr").each(function(){
		if ($(this).find('input[name="images.is_cover"]').val() == '1') {
			$(this).find('.imgDiv').append("<img class='layui-upload-img cover' src='/webapp/img/cover.png' />");
		}
	})
}


//重置表格
function renderTable() {
	//第一个不要上移
	$('#tbody tr:first').find('.move_up').remove();
	if ($('#tbody tr:first').find('.move_down').length == 0) {
		$('#tbody tr:first').find('.delete').before('<button  lay-filter="move_down" type="button"  '+
		'				class="move_down layui-btn "  ><i class="layui-icon">&#xe61a;</i>下移</button>                  ');
	}
	//最后一个不要下移
	$('#tbody tr:last').find('.move_down').remove(); 
	if ($('#tbody tr:last').find('.move_up').length == 0) {
		$('#tbody tr:last').find('.delete').before('<button  lay-filter="move_up" type="button"  '+
		'				class="move_up layui-btn "  ><i class="layui-icon">&#xe619;</i>上移</button>                   ');
	}
	//其余元素都要
	$('#tbody tr:not(:last):not(:first)').each(function(){
		if ($(this).find('.move_down').length == 0) {
			$(this).find('.delete').before('<button  lay-filter="move_down" type="button"  '+
			'				class="move_down layui-btn "  ><i class="layui-icon">&#xe61a;</i>下移</button>                  ');
		}
		if ($(this).find('.move_up').length == 0) {
			$(this).find('.move_down').before('<button  lay-filter="move_up" type="button"  '+
			'				class="move_up layui-btn "  ><i class="layui-icon">&#xe619;</i>上移</button>                   ');
		}
	})
}

