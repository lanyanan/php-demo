layui.use([ 'table', 'element', 'form' ], function() {
	var table = layui.table;
	var element = layui.element;
	var form = layui.form;
	var url = window.siteUrl + '/msg/msg_term/list_data'

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
			field : 'term_id',
			width : '15%',
			title : '关键词ID'
		}, {
			align : 'center',
			field : 'name',
			width : '15%',
			title : '关键词名称'
		}, {
			align : 'center',
			field : 'visist_count',
			width : 200,
			title : '访问次数'
		}, {
			align : 'center',
			field : 'information_count',
			title : '资讯数量',
			width : 200
		} // minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
		, {
			align : 'center',
			field : 'video_count',
			width : 200,
			title : '视频数量'
		}, {
			align : 'center',
			field : 'album_count',
			width : 200,
			title : '图集数量'
		} , {
			align : 'center',
			field : 'gmt_create',
			width : 200,
			title : '创建时间'
		} ] ],
		done : function(res, curr, count) {

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
					+ '/msg/msg_term/delete_batch');
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
})
