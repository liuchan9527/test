<?php
if(empty($_SERVER['HTTP_REFERER'])){
header('Location:list.html');
}
include('init.php');
//15个
//$videos = Video::getTodayVideo(15,true);
$page = isset($_GET['page']) ? $_GET['page']+0 : 1;
$videos = Video::getVideoPage($page,20,true);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<title></title>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131836532-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131836532-1');
</script>

<style>
body{ padding:0; margin:0; font-family: "微软雅黑", "宋体";background:#302f34;}
ul,li,input,span{ padding:0; margin:0; list-style-type:none;}
.clear{ clear:both;}
input[type=button], input[type=submit], input[type=file], button { cursor: pointer; -webkit-appearance: none;}

.header{ height:70px; position:relative;width:100%;}
.head{ height:70px; background:#f4f4f4; border-bottom:1px solid #eeeeee; position:fixed; width:100%;}
.logo{ padding-left:20px; padding-top:15px;}
.h30{ height:30px;}
.h30a{ height:30px;}
.h10{ height:10px;}
.h10a{ height:10px;}
.mass{ width:800px; margin:0 auto; } 

.h_h50{ height:50px;}
.h_h20{ height:20px;}

.login_h1{ line-height:25px; height:60px; text-align:center; font-family:"微软雅黑", "宋体";color:#FF0; background:#999;}
.login_h1 font{ font-size:12px; color:#FFF;}
.login_coty{ margin:0 auto; width:96%; text-align:left; line-height:20px; font-size:12px; color:#999; margin-top:20px;  }
.login_coty li{ float:left; width:100%; height: auto;}
.img_a{ float:left; width:80px; height:80px; overflow:hidden; margin-bottom:20px;}
.img_b{ margin-left:90px;  margin-bottom:20px;}
.img_b_a{ line-height:25px; font-size:16px;}
.z1 {color:#FFF;}
.z1 a{ color:#FFF; text-decoration:none;line-height:30px;} 
.z1 a:hover{ color:#F00; text-decoration:underline;}
.z2 {color:#F0F;}
.z2 a{ color:#F0F; text-decoration:none;line-height:30px;} 
.z2 a:hover{ color:#F00; text-decoration:underline;}
.z3 {color:#3F0;}
.z3 a{ color:#3F0; text-decoration:none;line-height:30px;} 
.z3 a:hover{ color:#F00; text-decoration:underline;} 
.z4 {color:#0FF;}
.z4 a{ color:#0FF; text-decoration:none;line-height:30px;} 
.z4 a:hover{ color:#F00; text-decoration:underline;}
.img_b_b{ padding-top:5px; font-size:12px;}
.img_b_b a{ color:#FF0; text-decoration:none;line-height:30px;} 
.img_b_b a:hover{ color:#F00; text-decoration:underline;}
 

.hc{ margin:0 auto; width:120px; height:120px; border-radius:60px 60px; text-align:center; color:#FFF; background:#f96160; font-size:50px; line-height:120px; font-family: Georgia, Times, serif;}
.hc{ margin:0 auto; width:120px; height:120px; border-radius:60px 60px; text-align:center; color:#FFF; background:#f96160; font-size:50px; line-height:120px; font-family: Georgia, Times, serif;}
.foot{ background:#302f34; height:40px; line-height:38px; text-align: center; width:100%; position: absolute; bottom:0px;color:#CCC;}
.foot img{ position:relative;top:3px; padding-right:5px;}
.foot a{color:#CCC; text-decoration:none;}
.foot a:hover{color:#CCC; text-decoration:none;}

  
@media screen and (max-width:900px) {
.login_coty{ width:96%;  }
.mass{ width:100%;}
.reg{ display:none;}	
.login{ float: none; width:96%;}
.login_account{ display:block;}
.login_bd2{display:block;}
.h_navn_l{ display: none;}
.h_navn_r{ margin-left:0px;}
.h30a{ display:none;}
.h_menu_nav{ display:block;}
.foot{width:100%;}
}
.loadmore{width:100%;text-align:center;font-size:14px;color:#0f0;}
.loadmore a{padding:10px;color:#0f0;}

</style>
    <script src="https://cdn.bootcss.com/jquery/1.8.1/jquery.js"></script>
</head>
<body>
<Div class="mass">
     <div class="login_h1">
       精彩视频<br/>
       <font>如无法跳转请重新进入链接;此商户被多人投诉等提示请放心付款</font>
     </div>
    
    <div class="login_coty">
      <ul>
        
      

          <?php
          foreach($videos as $video){
          ?>
              <li>
                  <div class="img_a">
                      <img src='<?php echo $video['video_pic'];?>' width=80 height=55 onerror="this.src='./static/img/moren.jpg'"/>            </div>
                  <div class="img_b">
                      <div class="img_b_a"><div class="z<?php echo mt_rand(1,4);?>">
                              <a href='buy.php?vid=<?php echo $video['id'];?>' target='_blank'>
                                  【<?php echo $video['type_name'];?>】<?php echo $video['video_name'];?>
                              </a></div></div>
                      <!--<div class="img_b_b"> 视频时间：<?php echo $video['video_time'];?> 视频大小：<?php echo $video['video_max'];?></div>-->
                  </div>
              </li>
          <?php
          }
          ?>
  			</ul>
         <div class="clear"></div>
        <div class='loadmore'>
            <?php
            if($page > 1){
                echo '<a href="/list.php?page='.($page-1).'">上一页</a>';
            }
            echo '<span>第'.$page.'页</span>'
            ?>
            <a href='/list.php?page=<?php echo $page+1;?>'>下一页</a></div>

</Div>
</Div>


 <script>
        function onBridgeReady() {
            WeixinJSBridge.call('hideOptionMenu');
        }

        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady();
        }
 </script>
</body>
</html>
<?php
$contents = ob_get_contents();
ob_end_clean();
echo base64_encode($contents);
