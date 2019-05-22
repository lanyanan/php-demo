layui.use('table', function(){
  var table = layui.table;
  var url = window.siteUrl + '/res/res_video';
  table.render({
    elem: '#table'
    ,url: url
    ,toolbar: '#toolbarDemo'
    ,response: {
        statusName: 'code' //规定数据状态的字段名称，默认：code
        ,statusCode: 1 //规定成功的状态码，默认：0
        ,msgName: 'msg' //规定状态信息的字段名称，默认：msg
        ,countName: 'count' //规定数据总数的字段名称，默认：count
        ,dataName: 'data' //规定数据列表的字段名称，默认：data
    } 
    ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
      layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
      ,groups: 1 //只显示 1 个连续页码
      ,first: false //不显示首页
      ,last: false //不显示尾页
    }
    ,cols: [[
       {align:'center', type:'checkbox', width:'4%', title: '选择'}
      ,{align:'center', type:'numbers', width:'5%', title: '序号'}
      ,{align:'center', field:'title', width:'15%', event: 'showEdit', style: 'color: #000099;cursor:pointer;', title: '视频标题'}
      ,{align:'center', field:'publish_type', width:160, title: '发布类型'}
      ,{align:'center', field:'source', title: '来源', width:120} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
      ,{align:'center', field:'author', width:200, title: '作者'}
      ,{align:'center', field:'like_count', width:60, title: '点赞'}
      ,{align:'center', field:'collect_count', width:60, title: '收藏'}
      ,{align:'center', field:'content_category_name', width:120, title: '内容分类'}
      ,{align:'center', field:'gmt_create', width:210, title: '创建时间'}
      ,{align:'center', field:'publish_time', width:210, title: '发布时间'}
      ,{align:'center', field:'publish_status', hide:'true', title: '发布状态'}
    ]]
    ,done: function(res, curr, count){
        $(".layui-table-box").find("[data-field='id']").css("display","none");

        $("[data-field='publish_type']").children().each(function(){
        	var text = $(this).text()
            if(text=='0'){
                $(this).text("原创")
            }else if(text=='1'){
                $(this).text("转载")
            }
        });
        $("[data-field='isPayable']").children().each(function(){
            if($(this).text()=='1'){
                $(this).text("是")
            }else if($(this).text()=='2'){
                $(this).text("否")
            }
        });
        $("[data-field='publish_status']").children().each(function(){
            if($(this).text()=='0'){
            	$(this).closest('tr').find('[data-field="publish_time"] .layui-table-cell').text("未发布");
            }else if($(this).text()=='2'){
            	$(this).closest('tr').find('[data-field="publish_time"] .layui-table-cell').text("已下架");
            }
        });


        pageCurr=curr;
    }
    
  });
  
  table.on('toolbar(table)', function(obj){
<<<<<<< HEAD
	  //按钮监听
	  var checkStatus = table.checkStatus(obj.config.id);
	  switch(obj.event){
	    case 'add':
	      add();
	    break;
	    case 'delete':
	      delete_batch(checkStatus.data);
	    break;
	  };
	});
  
  table.on('tool(table)', function(obj){
	  switch(obj.event){
	    case 'showEdit':
	    	showEdit(obj.data.id);
	    break;
	  };
  });
  
  //跳转添加页面
  function showEdit(id) {
	  sessionStorage.setItem("id",id);
	  window.location.href = window.siteUrl + '/webapp/pages/res/video/edit.html';
  }
  
	  //跳转添加页面
  function add() {
	  window.location.href = window.siteUrl + '/webapp/pages/res/video/add.html';
  }
  //批量删除
  function delete_batch(data) {
	  if (data.length == 0) {
		  layer.msg("未选择数据");
		  return;
	  }
	  var ids = new Array();
	  for (var i in data) {
		  ids.push(data[i].id);
	  }
	  var data = { "ids":ids };
	  console.log(data);
	  $.ajax({
          type: "POST",
          url: window.siteUrl + '/res/res_video/delete_batch',
          dataType: "json",
          data: data,
          success: function (data, msg) {
        	  if (data.code == '1') {
        		  layer.msg("删除成功");
        		  table.reload('table', {
        			  url: url
        			  ,where: {} //设定异步数据接口的额外参数
        			});
        	  } else {
        		  layer.msg("删除失败");
        	  }
          }

      });
  }
});




/*layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
});
var img_path =""
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;
       
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: window.siteUrl + '/upload_oss/testImg/img'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                window['objs'] = obj;
            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    return layer.error(res.msg);
                }else{
                    objs.preview(function(index, file, result){
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                    layer.msg(res.msg);
                }
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
    });

$(document).ready(function(){  
	 $.ajax({
         type: "GET",
         url: window.siteUrl + '/upload_oss/Signatureurl',
         dataType: "json",
         success: function (data, msg) {
        	 decodeUnicode(data.data);
         	layer.msg(data.data)
         	$("#url").val(decodeUnicode(data.data));
         }
     });
});  */
=======
	  var checkStatus = table.checkStatus(obj.config.id);
	  switch(obj.event){
	    case 'add':
	      add();
	    break;
	    case 'delete':
	      delete_batch(checkStatus.data);
	    break;
	  };
	});
  
  function add() {
	  window.location.href = window.siteUrl + '/webapp/pages/res/video/add.html';
  }
  
  function delete_batch(data) {
	  if (data.length == 0) {
		  layer.msg("未选择数据");
		  return;
	  }
	  var ids = new Array();
	  for (var i in data) {
		  ids.push(data[i].id);
	  }
	  var data = { "ids":ids };
	  console.log(data);
	  $.ajax({
          type: "POST",
          url: window.siteUrl + '/res/res_video/delete_batch',
          dataType: "json",
          data: data,
          success: function (data, msg) {
        	  if (data.code == '1') {
        		  layer.msg("删除成功");
        		  table.reload('table', {
        			  url: url
        			  ,where: {} //设定异步数据接口的额外参数
        			});
        	  } else {
        		  layer.msg("删除失败");
        	  }
          }

      });
  }
});
>>>>>>> branch 'heliu' of http://git.inewhome.com/dawn/dawn-cms.git
