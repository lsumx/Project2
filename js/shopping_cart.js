 function addShopping(btn){
        var tds=$(btn).parent().siblings();//获取当前元素的父节点的全部兄弟节点，就是当前这行的所有td
        var name=$(tds).eq(0).text();//获取商品名称的td的文本值
        var price=$(tds).eq(1).text();//获取商品价格的td的文本值
        var html = $("<tr>"    //开始拼接HTML元素，将取到的东西展示到对用的input中
            +"<td>"+name+"</td>"
            +"<td>"+price+"</td>"
            +"<td>"
            +"<input type='button' value='-'/>"
            +"<input type='text' size='3' readonly='readonly'/>"
            +"<input type='button' value='+'/>"
            +"</td>"
            +"<td>"+price+"</td>"
            +"<td align='center'>"
            +"<input type='button' value='*'/>"
            +"</td></tr>");
        $("#goods").append(html);
 }
 function deleteShopping(btn){//给上一步你拼接的删除按钮上绑定一个这样的方法
     $(btn).parent().parent().remove();
 }
 function money() {
     var a=parseInt($("#money").html());
     var b=parseInt($("#price").val());
     $("#money").html(""+(a+b));
 }