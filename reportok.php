<html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title></title>
    <link rel="stylesheet" href="./static/css/weui.min.css">
    <link rel="stylesheet" href="./static/css/app.css">
    <script>
        // document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        //      WeixinJSBridge.call("hideOptionMenu")
        //     WeixinJSBridge.call("hideToolbar")
        // });
    </script>
</head>
<body><div class="weui-msg">
    <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title">举报成功</h2>
        <p class="weui-msg__desc">您的举报已提交审核，我们会尽快处理！</p>
    </div>
    <div class="weui-msg__opr-area">
        <p class="weui-btn-area">
            <a onclick="closeWindow()" href="javascript:;" class="weui-btn weui-btn_primary">确定</a>
        </p>
    </div>
</div>
<script>
    var wxready=false
    function closeWindow () {
        if (wxready) {
            WeixinJSBridge.call("closeWindow")
        }
    }
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        wxready=true
    });
</script>
<script>
    // wx.ready(function(){
    //   wx.hideAllNonBaseMenuItem();
    //   if (typeof(wxready)=="function") {
    //     wxready();
    //   }
    // });
</script>
<script>;</script><script type="text/javascript" src="http://luo.0466x9.cn/app/index.php?i=2&amp;c=utility&amp;a=visit&amp;do=showjs&amp;m=czt_tushang"></script>

</body></html>