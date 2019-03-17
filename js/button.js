
function addCart(artworkID) {
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp=new XMLHttpRequest();
    } else {// IE6, IE5 浏览器执行代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            // document.getElementById("").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","addToCart.php?artworkID="+artworkID,true);
    xmlhttp.send();
}
function addMoney() {
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp=new XMLHttpRequest();
    } else {// IE6, IE5 浏览器执行代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(ev){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById('price').value = xmlhttp.responseText;
        }
    }
    if((parseInt(document.getElementById('price').value)==parseFloat(document.getElementById('price').value))&&document.getElementById('price').value>0&&document.getElementById('price').value<=100000){
        document.getElementById('formMoney').submit();
        xmlhttp.open("GET","addMoney.php?money="+document.getElementById('price').value,true);
        xmlhttp.send();
    }

    //
    // xmlhttp.open("GET","addmoney.php?money="+money,true);
    // xmlhttp.send();

}
// function refreshcurrent() {
//    // alert(1)
//     document.location.reload();
// }
// function pay() {
//     var sum =document.getElementById('totalMoney').innerText;
//     if (window.XMLHttpRequest)
//     {// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
//         xmlhttp=new XMLHttpRequest();
//     } else {// IE6, IE5 浏览器执行代码
//         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//     }
//     xmlhttp.onreadystatechange = function(ev){
//         if (xmlhttp.readyState===4 && xmlhttp.status===200) {
//             if (xmlhttp.responseText.charAt(0)===0){
//
//             }
//         }
//     }
//
// }


