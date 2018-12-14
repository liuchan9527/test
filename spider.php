<?php
set_time_limit(120);
header('Content-type:text/html;charset=utf8;');
class Spider{
    private $htmlFile = 'tempCache.html';//临时文件下载存放
    public $fileString = '';
    public function __construct()
    {
        if(!file_exists($this -> htmlFile) || (filesize($this -> htmlFile) == 0)){
            $this -> downloadHtml('https://www.601ww.com/Html/60/');
        }
        $this -> fileString = file_get_contents($this -> htmlFile);
    }
    //下载源码
    public function downloadHtml($url){
        //$url = 'https://javhd.com/tour/196?nats=andrews.2.2.238.0.0.0.0.0&atas_uid=BkesYvv6tf.1';
        $headers = array(
            'Accept-Language: zh-CN,zh;q=0.9'
        );
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_TIMEOUT, 10);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        $result = curl_exec ( $ch );
        if(curl_errno($ch)){
            exit ('Curl error:'.curl_error());
        }
        curl_close ( $ch );
        file_put_contents($this -> htmlFile , $result);
    }

    //解析列表
    public function parseList()
    {
        $pattern = '/<li>(.+)<\/li>/Us';
        $imgPattern = '/<img src="(.+)" \/>/Us';
        $videoPattern = '/<video.+src="(.+)".+<\/video>/Us';
        $altPattern = '/<h3>(.+)<\/h3>/Us';
        $list = array();
        preg_match_all($pattern,$this -> fileString,$blockes);
        print_r($blockes);
        $i=0;
        foreach($blockes[0] as $key => $block)
        {
            /*
            $i++;
            if($i>50)break;
            echo $block."\n\n\n";
            continue;
            echo $block."\n\n\n";
            print_r(preg_replace('#<img.+src="(.+)".+"/>#Us','hahah',$block));
            exit;
            */
            preg_match($imgPattern,$block,$imgsrc);
            if(!empty($imgsrc[1])){
                $list[$key]['img'] = $imgsrc[1];
            }else{
                preg_match('/<img.+src="(.+)".+alt="">/Us',$block,$imgsrc);
                $list[$key]['img'] = $imgsrc[1];
            }

            preg_match($videoPattern,$block,$videoSrc);
            if(!empty($videoSrc[1])){
                $list[$key]['video'] = $videoSrc[1];
            }else{
                preg_match('/<img.+data-src="(.+)"/Us',$block,$videoSrc);
                if(!empty($videoSrc[1])){
                    $list[$key]['video'] = $videoSrc[1];
                }else{
                    $list[$key]['video'] = '';
                }
            }
            preg_match($altPattern,$block,$alt);
            if(!empty($alt[1]))
            {
                $list[$key]['alt'] = $alt[1];
            }else{
                $list[$key]['alt'] = '';
            }
        }
        //$this -> download($list);
        print_r($list);
    }
    public function download($list)
    {
        foreach($list as $k => $l)
        {
            $path = '';
            if(!empty($l['alt'])){
                $path = 'source/'.iconv('utf-8','gb2312',$l['alt']);
            }else{
                if(substr($l['img'],0,2) == '//'){
                    $l['img'] = 'https:'.$l['img'];
                }else{
                    $l['img'] = 'https://javhd.com'.$l['img'];
                }
                $path = 'source/'.$k;
            }
            if(!is_dir($path))
                mkdir($path,0777,true);
            //echo pathinfo($l['img'],PATHINFO_BASENAME);exit;
            if(!empty($l['img'])){
                $fname = $path.'/'.pathinfo($l['img'],PATHINFO_BASENAME);
                if(!file_exists($fname)){
                    file_put_contents($fname,file_get_contents($l['img']));
                }
            }
            if(!empty($l['video'])){
                $fname = $path.'/'.pathinfo($l['video'],PATHINFO_BASENAME);
                if(!file_exists($fname)){
                    file_put_contents($fname,file_get_contents($l['video']));
                }
            }
        }
    }

    //视频传到七牛云空间，格式转换成swf，并且名字根据md5(alt) 命名
    public function useMd5RenameVideo()
    {
        $dir = 'source';
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                $path = $dir.'/'.$file;
                if ($file != "." && $file != ".." && is_dir($path)) {
                    $file = iconv('gb2312','utf-8',$file);
                    echo "$file\n";
                    foreach(glob($path .'/*.mp4') as $video)
                    {
                        copy($video,'md5video/'.md5($file).'.mp4');
                    }

                    foreach(glob($path .'/*.jpg') as $video)
                    {
                        copy($video,'md5image/'.md5($file).'.jpg');
                    }

                    foreach(glob($path .'/*.gif') as $video)
                    {
                        copy($video,'md5image/'.md5($file).'.gif');
                    }
                }

            }
            closedir($handle);
        }
    }
}

$javhd = new Spider();
//$javhd -> useMd5RenameVideo();
$javhd -> parseList();