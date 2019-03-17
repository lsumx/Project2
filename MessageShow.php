<div id="messageShow">

</div>
<script>
    function showMessage(s) {
        $("#messageShow").html(s);
        let messageBox = document.getElementById("messageShow");
        $("#messageShow").fadeIn();

        setTimeout($("#messageShow").fadeOut(3000),2000);

    }
</script>
<style>
    #messageShow{
        display: none;
        position: fixed;
        top: 20%;
        left: 50%;
        margin-left: -100px;
        border-radius: 30%;
        width: 200px;
        height: 60px;
        line-height: 60px;
        background-color: blanchedalmond;
        text-align: center;
        z-index: 100000;
        font-family: "Al Bayan";
        font-size: 16px;
        color: red;
    }
</style>