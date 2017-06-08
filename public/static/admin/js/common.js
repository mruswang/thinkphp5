/**
 * Created by wangsir on 2017/5/21.
 */
/*增加*/
function admin_add(title,url,w,h){
    layer_show(title,url,w,h);
}
/* 删除*/
function admin_del(url){
    layer.confirm('确认要删除吗？',function(index){
        window.location.href=url;
    });
}
/*-编辑*/
function admin_edit(title,url,id,w,h){
    layer_show(title,url,w,h);
}

$('.listorder input').blur(function () {
   //获取主键id
   var id=$(this).attr('attr-id');
   //alert(id);
   //获取排序值
   var listorder=$(this).val();
   var postDate={
        'id':id,
        'listorder':listorder
   };
   var url=SCOPE.listorder_url;
   //抛送http
   $.post(url,postDate,function (result) {
       if(result.code==1){
           //alert(result.msg);
            location.href=result.data;

       }else {
            //console.log(result);
            alert(result.msg);
            //alert(1);
       }
   },"json");
});


// 城市相关二级内容

$(".cityId").change(function () {
    city_id= $(this).val();
    url=SCOPE.city_url;
    postData={'id':city_id};
    //抛出请求
    $.post(url,postData,function (result) {
        //相关业务
        if(result.status==1){
            //将信息填充到html中
            data=result.data;
            city_html="";
            $(data).each(function (i) {
                city_html+="<option value='"+this.id+"'>"+this.name+"</option>"
            })
            $(".se_city_id").html(city_html);

        }else if(result.status==0){
            $(".se_city_id").html('');


        }
    },'json')
});



// 分类二级内容

$(".categoryId").change(function () {
    categoryId_id= $(this).val();
    url=SCOPE.category_url;
    postData={'id':categoryId_id};
    //抛出请求
    $.post(url,postData,function (result) {
        //相关业务
        if(result.status==1){
            //将信息填充到html中
            data=result.data;
            category_html="";
            $(data).each(function (i) {
                category_html+='<input name="se_category_id[]" type="checkbox" id="checkbox-moban" value="'+this.id+'">'+this.name;
                category_html+='<label for="checkbox-moban">&nbsp;</label>';
            })
            $(".se_category_id").html(category_html);

        }else if(result.status==0){
            $(".se_category_id").html('');


        }
    },'json')
});


//用户名的判断
$('#username').blur(function () {
    //获取排序值
    var username=$(this).val();
    var postDate={
        'username':username
    };
    var url=SCOPE.username_url;
    //抛送http
    $.post(url,postDate,function (result) {
        if(result.code==1){
            // alert(result.msg);
            $('#username_text').text(result.msg);
            $('#username_text').css('color','red');
        }else {
            $('#username_text').text(result.msg);
            $('#username_text').css('color','green')
        }
    },"json");
});


//时间插件的处理
function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }
}