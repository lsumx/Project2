$(function () {
    var count = 0;

    $("#img").mousemove(function (e) {
        var smalldiv = $("#smalldiv");
        var ZoomSizeWidth = $("#img1").width() / $("#img_zoom").width(); //宽放大的倍数  
        var ZoomSizeHeight = $("#img1").height() / $("#img_zoom").height();//高放大的倍数  
        $("#bigimg").show();
        smalldiv.show();
        var mouseX = e.pageX + 5;
        var mouseY = e.pageY + 5;


        if (e.pageX < $(this).offset().left + smalldiv.width() / 2) {//当鼠标的X坐标小于图片与div遮罩层的x坐标和是ｄｉｖｘ＝０；  
            divX = 0;
        }
        else if (e.pageX > $(this).offset().left + smalldiv.width() / 2 && e.pageX < $(this).offset().left + $(this).width() - smalldiv.width() / 2) {//鼠标的X坐标在图片内部并且小于图片最右边的X坐标  
            divX = e.pageX - $(this).offset().left - smalldiv.width() / 2;
        }
        else if (e.pageX > $(this).offset().left + $(this).width() - smalldiv.width() / 2) {//鼠标的X坐标大于图片的最右边的X坐标 （Y轴同理）  
            divX = $(this).width() - smalldiv.width();
        }

        if (e.pageY < $(this).offset().top + smalldiv.height() / 2) {
            divY = 0;
        }
        else if (e.pageY > $(this).offset().top + smalldiv.height() / 2 && e.pageY < $(this).offset().top + $(this).height() - smalldiv.height() / 2) {
            divY = e.pageY - $(this).offset().top - smalldiv.height() / 2;
        }
        else if (e.pageY > $(this).offset().top - smalldiv.height()) {
            divY = $(this).height() - smalldiv.height();
        }

        $("#bigimg").css("top", mouseY).css("left", mouseX);
        smalldiv.css("top", divY).css("left", divX);
        smalldiv.appendTo("#img");
        var tempX = smalldiv.offset().left - $(this).offset().left;//通过对大图的位置偏移来起到放大的效果  
        var tempY = smalldiv.offset().top - $(this).offset().top;
        $("#img1").css("top", -tempY * ZoomSizeHeight).css("left", -tempX * ZoomSizeWidth);
    });

    $("#img_zoom").mouseleave(function () {

        $("#smalldiv").hide();
        $("#bigimg").hide();
    });
})
