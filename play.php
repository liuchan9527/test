<?php
include('init.php');
//$host = 'http://video.z35i.cn';
$id = $_GET['vid']+0;
if(!$id){
    header('Location:list.html');
}
if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false){
 header('Location:list.html');
}
//检查是否免费播放
$freePlay = Video::getFreePlayTimes(session_id());
if($freePlay){
 //使用免费播放机会
 Video::useFreePlay(session_id());
}else{
//检查支付
$isPay = Video::canPlay($id,session_id());
if(!$isPay){
    header('Location:buy.php?vid='.$id);
}
}
$video = Video::getVideoById($id);
if(!$video){
    header('Location:list.php');
}
$pages = ceil(Video::getVideoCount()/8);
?>
<!DOCTYPE html>
<html>
<head>
<title>白屏请等待一下就好</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
<script type="text/javascript" src="/static/js/ckplayer.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/js/jquery.min.js?v=2.1.4"></script>
<script src="/static/js/laydate.js"></script>
<script src="/static/js/laypage.js"></script>
<script src="/static/js/laytpl.js"></script>
<link href="/static/css/style.css" rel="stylesheet">
<link href="/static/css/weui.min.css" rel="stylesheet">
<link href="/static/css/style.min.css" rel="stylesheet">
<link href="/static/css/laypage.css" rel="stylesheet">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131836532-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131836532-1');
</script>

</head>
<body>
<div style="padding: 15px 15px 15px;">

<div class="rich_media_content"  id="video" style="width: 100%; height: 250px;border: solid 1px #323136;padding-left:1px;"></div>


<div id="gdt_area" >
<div style="padding-top:10px;font-size:16px;">
<div style="margin: 0 1px 12px;text-align: center;line-height: 12px;"><span style="position: relative;top: 10px;background: #fff;color: #868686;font-size: 17px;padding: 0 8px">[视频列表]</span></div>
<div style=" background: #fff">
<div>


<section id="container">
    <div class="h_playlist_box" id="article_list">
    </div>
</section>

<div style="clear: both">
</div>
<div id="AjaxPage" style=" text-align: right;"></div>
                    <div id="allpage" style=" text-align: right; background: #fff"></div>
</div>
<script id="arlist" type="text/html">
	 {{# for(var i=0;i<d.length;i++){  }}
	
     <dl style="width: 358px;">
         <dt style="height: 88.3365px;"><em></em>
             <img src="{{d[i].video_pic}}" style="height: 88.3365px; display: inline;" onerror="this.src='/static/img/moren.jpg'">
         </dt>
         <dd>
<span style="min-height: 58.3365px;">{{d[i].video_name}}</span>
<p><i><a href="box.html?vid={{d[i].id}}">点击播放</a></i></p>
</dd></dl>

	  {{# } }}
</script>
 
</div>
</div>
</div>

<style type="text/css">
    .spiner-example{height:200px;padding-top:70px}

</style>

<div class="spiner-example">
    <div class="sk-spinner sk-spinner-three-bounce">
        <div class="sk-bounce1"></div>
        <div class="sk-bounce2"></div>
        <div class="sk-bounce3"></div>
    </div>
</div>


<script type="text/javascript">
var videoObject = {
container: '#video',
variable: 'player', 
loop: true,
//autoplay: true, 
poster: '', 
//video:'https://v-kankan.com/20181031/4385_9dd491d6/index.m3u8' 这个链接还能用
video:'<?php echo $video["video_url"];?>'
};
var player = new ckplayer(videoObject);
</script>
<script type="text/javascript">
function run () {
var index = Math.floor(Math.random()*10);
pmd(index);
};
var times = document.getElementsByClassName('fuckyou').length;
//setInterval('run()',times*200);
function pmd (id) {
var colors = new Array('#FF5151','#ffaad5','#ffa6ff','#d3a4ff','#2828FF','#00FFFF','#1AFD9C','#FF8000','#81C0C0','#B766AD');
var color = colors[id];
var tmp = document.getElementsByClassName('fuckyou');
for (var i = 0; i < tmp.length; i++) {
var id = tmp[i];
var moren = id.style.color;
setTimeout(function(id){
id.style.color = color;
},i*200,id);
setTimeout(function(id,moren){
id.style.color = moren;
},i*200+180,id,moren);
};
}


function Ajaxpage(curr){

        var userid='11';
        var ddh='F74NFU6KPf';
        var id='1069';
        $.getJSON('ajaxpage.php', {
            page: curr || 1,userid:userid,ddh:ddh,id:id
        }, function(data){      //data是后台返回过来的JSON数据

           $(".spiner-example").css('display','none');
            if(data==''){
               
            }else{
                article_list(data); //模板赋值
                laypage({
                    cont: $('#AjaxPage'),//容器。值支持id名、原生dom对象，jquery对象,
                    pages:'<?php echo $pages;?>',//总页数
                    skip: true,//是否开启跳页
                    skin: '#1AB5B7',//分页组件颜色
                    curr: curr || 1,
                    groups: 3,//连续显示分页数
                    jump: function(obj, first){

                        if(!first){
                            Ajaxpage(obj.curr)
                        }
                        $('#allpage').html('第'+ obj.curr +'页，共'+ obj.pages +'页');
                    }
                });
            }
        });
    }

    Ajaxpage();


 function article_list(list){

   var tpl = document.getElementById('arlist').innerHTML;
    laytpl(tpl).render(list, function(html){
        document.getElementById('article_list').innerHTML = html;
    });
}

</script>



</body>
</html>
<?php
$contents = ob_get_contents();
ob_end_clean();
echo base64_encode($contents);
