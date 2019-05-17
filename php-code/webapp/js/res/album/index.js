layui.use('table', function(){
  var table = layui.table;
  var url = window.siteUrl + '/res/res_album';
  console.log(url);
  table.render({
    elem: '#table'
    ,url: url
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
      ,{align:'center', field:'title', width:'15%', title: '图集标题'}
      ,{align:'center', field:'publish_type', width:160, title: '类型'}
      ,{align:'center', field:'source', title: '来源', width:120} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
      ,{align:'center', field:'author', width:200, title: '作者'}
      ,{align:'center', field:'like_count', width:60, title: '点赞'}
      ,{align:'center', field:'collect_count', width:60, title: '收藏'}
      ,{align:'center', field:'content_category_name', width:120, title: '内容分类'}
      ,{align:'center', field:'gmt_create', width:210, title: '创建时间'}
      ,{align:'center', field:'publish_time', width:210, title: '发布时间'}
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


        pageCurr=curr;
    }
    
  });
});