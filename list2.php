<?php
include('init.php');
//15个
$videos = Video::getTodayVideo(15,false);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>更多视频</title>
    <link href="./static/css/weui.min.css" type="text/css" rel="stylesheet" />
    <link href="./static/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

    <style>
        body {
            background-color: #f0f0f0;
        }

        .link {
            text-decoration: underline;
        }

        .paginationNav {
            padding: 0 20px;
        }

        .f-14 {
            font-size: 14px;
        }

        .f-12 {
            font-size: 12px;
        }

        .qrcode {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="weui-panel">
        <div class="weui-panel__hd">扫一扫加我</div>
        <div class="weui-panel__bd">
            <div class="weui-media-box weui-media-box_text">
                <p class="text-center">
                    <img src=""
                        class="qrcode" alt="">
                </p>
            </div>
        </div>

    </div>
    <div class="weui-panel">
        <div class="weui-panel__hd">视频列表</div>
        <div class="weui-panel__bd">
            <div class="weui-media-box weui-media-box_small-appmsg">
                <div class="weui-cells">



					<?php
					foreach($videos as $video){
					?>
                        <a class="weui-cell weui-cell_access" href="https://w.url.cn/s/AwiMTIU">
                            <div class="weui-cell__hd"></div>
                            <div class="weui-cell__bd weui-cell_primary">
                                <div class="f-14"><?php echo $video['video_name'];?></div>
                            </div>
                            <span class="weui-cell__ft f-12">
                                点击次数（<?php mt_rand(10,300);?>）
                            </span>
                        </a>
                    <?php
					}
					?>
                </div>
            </div>
        </div>
    </div>



    <div class="list-page" style="text-align: center;">

        <p style="font-size:14px;"> 50 条记录 1/5 页  <a href='/index.php/web/yuantu/more/openid/001/p/2.html'>下一页</a>     <span class='current'>1</span><a href='/index.php/web/yuantu/more/openid/001/p/2.html'>2</a><a href='/index.php/web/yuantu/more/openid/001/p/3.html'>3</a><a href='/index.php/web/yuantu/more/openid/001/p/4.html'>4</a><a href='/index.php/web/yuantu/more/openid/001/p/5.html'>5</a>   </p>

    </div>

</body>

</html>