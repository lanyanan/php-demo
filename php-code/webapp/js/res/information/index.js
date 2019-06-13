layui.use([ 'table', 'element', 'form' ], function() {
	var table = layui.table;
	var element = layui.element;
	var form = layui.form;
	var url = window.siteUrl + '/res/res_information/list_data/wait_publish'

	// 加载内容分类
	renderContentCategorySelect($("select[name='content_category_id']"));

	// tab 切换
	element.on('tab(demo)', function(data) {
		if ($(this).attr('id') == 'waitPublishTab') {
			url = window.siteUrl + '/res/res_information/list_data/wait_publish';
		} else if ($(this).attr('id') == 'publishTab') {
			url = window.siteUrl + '/res/res_information/list_data/publish';
		} else if ($(this).attr('id') == 'soldOutTab') {
			url = window.siteUrl + '/res/res_information/list_data/sold_out';
		}
		table.reload("table", {
			url : url
		})
	});

	// 模糊搜索
	form.on('submit(search)', function(data) {
		table.reload("table", {
			url : url,
			where : data.field
		})
		return false;
	})

	table.render({
		elem : '#table',
		url : url,
		toolbar : '#toolbarDemo',
		response : {
			statusName : 'code' // 规定数据状态的字段名称，默认：code
			,
			statusCode : 1 // 规定成功的状态码，默认：0
			,
			msgName : 'msg' // 规定状态信息的字段名称，默认：msg
			,
			countName : 'count' // 规定数据总数的字段名称，默认：count
			,
			dataName : 'data' // 规定数据列表的字段名称，默认：data
		},
		page : { // 支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
			layout : [ 'limit', 'count', 'prev', 'page', 'next', 'skip' ] // 自定义分页布局
			,
			groups : 1 // 只显示 1 个连续页码
			,
			first : false // 不显示首页
			,
			last : false
		// 不显示尾页
		},
		cols : [ [ {
			align : 'center',
			type : 'checkbox',
			width : '4%',
			title : '选择'
		}, {
			align : 'center',
			type : 'numbers',
			width : '5%',
			title : '序号'
		}, {
			align : 'center',
			field : 'title',
			width : '15%',
			event : 'showEdit',
			style : 'color: #000099;cursor:pointer;',
			title : '视频标题'
		}, {
			align : 'center',
			field : 'publish_type',
			width : 160,
			title : '发布类型'
		}, {
			align : 'center',
			field : 'source',
			title : '来源',
			width : 120
		} // minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
		, {
			align : 'center',
			field : 'author',
			width : 200,
			title : '作者'
		}, {
			align : 'center',
			field : 'like_count',
			width : 60,
			title : '点赞'
		}, {
			align : 'center',
			field : 'collect_count',
			width : 60,
			title : '收藏'
		}, {
			align : 'center',
			field : 'content_category_name',
			width : 120,
			title : '内容分类'
		}, {
			align : 'center',
			field : 'gmt_create',
			width : 210,
			title : '创建时间'
		}, {
			align : 'center',
			field : 'sold_out_time',
			width : 210,
			title : '下架时间'
		}, {
			align : 'center',
			field : 'publish_time',
			width : 210,
			title : '发布时间'
		}, {
			align : 'center',
			field : 'publish_status',
			width : 210,
			title : '发布状态'
		} ] ],
		done : function(res, curr, count) {
			$(".layui-table-box").find("[data-field='id']").css("display",
					"none");

			$("[data-field='publish_type']").children().each(function() {
				var text = $(this).text()
				if (text == '0') {
					$(this).text("原创")
				} else if (text == '1') {
					$(this).text("转载")
				}
			});
			if ($(".layui-tab .layui-this").attr('id') == 'waitPublishTab') {
				$("table").find("[data-field='publish_time']").css("display",
						"none");
				$("table").find("[data-field='sold_out_time']").css("display",
						"none");
				$('button[lay-event="add"]').show();
				$('button[lay-event="publish"]').show();
				$('button[lay-event="sold_out"]').hide();
				$('button[lay-event="delete"]').show();
			} else if ($(".layui-tab .layui-this").attr('id') == 'publishTab') {
				$("table").find("[data-field='publish_status']").css("display",
						"none");
				$("table").find("[data-field='sold_out_time']").css("display",
						"none");
				$('button[lay-event="add"]').hide();
				$('button[lay-event="publish"]').hide();
				$('button[lay-event="sold_out"]').show();
				$('button[lay-event="delete"]').hide();
			} else if ($(".layui-tab .layui-this").attr('id') == 'soldOutTab') {
				$("table").find("[data-field='publish_status']").css("display",
						"none");
				$("table").find("[data-field='publish_time']").css("display",
						"none");
				$('button[lay-event="add"]').hide();
				$('button[lay-event="publish"]').show();
				$('button[lay-event="sold_out"]').hide();
				$('button[lay-event="delete"]').show();
			}
			$("[data-field='publish_status']").children().each(function() {
				if ($(this).text() == '0') {
					$(this).text("待发布")
				}
			});

			pageCurr = curr;
		}

	});

	table.on('toolbar(table)', function(obj) {
		// 按钮监听
		var checkStatus = table.checkStatus(obj.config.id);
		switch (obj.event) {
		case 'add':
			add();
			break;
		case 'delete':
			batch(checkStatus.data, window.siteUrl
					+ '/res/res_information/delete_batch');
			break;
		case 'publish':
			batch(checkStatus.data, window.siteUrl
					+ '/res/res_information/publish_batch');
			break;
		case 'sold_out':
			batch(checkStatus.data, window.siteUrl
					+ '/res/res_information/sold_out_batch');
			break;
		}
		;
	});

	table.on('tool(table)', function(obj) {
		switch (obj.event) {
		case 'showEdit':
			showEdit(obj.data.id);
			break;
		}
		;
	});

	// 跳转添加页面
	function showEdit(id) {
		sessionStorage.setItem("id", id);
		window.location.href = window.siteUrl
				+ '/webapp/pages/res/information/edit.html';
	}

	// 跳转添加页面
	function add() {
		window.location.href = window.siteUrl
				+ '/webapp/pages/res/information/add.html';
	}
	// 批量删除
	function batch(data, bashurl) {
		if (data.length == 0) {
			layer.msg("未选择数据");
			return;
		}
		var ids = new Array();
		for ( var i in data) {
			ids.push(data[i].id);
		}
		var data = {
			"ids" : ids
		};
		$.ajax({
			type : "POST",
			url : bashurl,
			dataType : "json",
			data : data,
			success : function(data, msg) {
				if (data.code == '1') {
					layer.msg("操作成功");
					table.reload('table', {
						url : url,
						where : {}
					// 设定异步数据接口的额外参数
					});
				} else {
					layer.msg("操作失败");
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

})
