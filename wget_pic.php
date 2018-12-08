<?php
set_time_limit(0);

$host = 'http://video.z35i.cn';
//下载背景GIF图
function wgetBggif()
{
	for($i=1;$i<=10;$i++){
		file_put_contents('video_pic/bg/'.$i.'.gif',file_get_contents('http://www.hrcycs.cn/app/images/bg/'.$i.'.gif'));
		sleep(1);
	}
}
//取数据库
$db = mysql_connect('localhost','root','root');
mysql_query('use video_store');
mysql_query('set names utf8');

$row = mysql_query('select * from front_video where video_pic!=""');
$size = 0;
header('Content-type:text/html;charset=utf-8');
while($rs = mysql_fetch_assoc($row))
{
	//过滤处理
	$fsize = str_replace('MB','',$rs['video_max'])+0;
	if(strpos($rs['video_name'],'兽') !== false || $fsize > 200){
		continue;
	}
	echo $rs['id'].':'.mb_convert_encoding($rs['video_name'],'gb2312','utf-8')."\r\n";
	//计算总大小
	$size += str_replace('MB','',$rs['video_max']);
	
	//另存为80*80图片缩略图
	$picDir = './'.dirname($rs['video_pic']);
	$picFileName = basename($rs['video_pic']);
	$picFilePath = $picDir.'/'.$picFileName;
	$videoDir = './'.dirname($rs['video_url']);
	$videoName = basename($rs['video_url']);
	$videoFilePath = $videoDir.'/'.$videoName;
	//创建图片和视频路径
	if(!is_dir($picDir)){
		mkdir($picDir,0777,true);
	}
	if(!is_dir($videoDir)){
		mkdir($videoDir,0777,true);
	}
	//检查文件是否存在是否需要下载
	if(!is_file($picFilePath) || filesize($picFilePath) == 0){
		$pic = P($host.$rs['video_pic']);
		file_put_contents($picFilePath,$pic);
		//压缩图片80*80大小
		/*
		$jpg = './video_pic/source/'.$rs['id'].'.jpg';
		file_put_contents($jpg,$pic);
		$arr = getimagesize($jpg);
		$imgHd = imagecreatefromjpeg($jpg);
		$image = imagecreatetruecolor(80,80);
		imagecopyresampled($image,$imgHd,0,0,0,0,80,80,$arr[0],$arr[1]);
		imagejpeg($image,'./video_pic/resize/'.$rs['id'].'.jpg');
		*/
	}
	//下载M3U8
	if(!is_file($videoFilePath) || filesize($videoFilePath) == 0){
		$m3u8 = P($host.$rs['video_url']);
		file_put_contents($videoFilePath,$m3u8);
		echo 'Download:'.$videoFilePath."\r\n";
	}
	//下载TS分段
	$fh = fopen($videoFilePath,'rb');
	if ($fh) {
		while (!feof($fh)) {
			$buffer = fgets($fh, 4096);
			$buffer = trim($buffer);
			if(strpos($buffer,'#') === false && strlen($buffer) > 0){
				$tsFilePath = $videoDir.'/'.$buffer;
				if(!is_file($tsFilePath) || filesize($tsFilePath) == 0){
					$path = $host.dirname($rs['video_url']).'/'.$buffer;
					//下载分段
					$file = P($path,'');
					file_put_contents($tsFilePath,$file);
					echo 'Download:'.$buffer.'  FileSize:'.round(filesize($tsFilePath)/1024/1024,2).'MB'."\r\n";
					usleep(100000);
				}
			}
		}
		fclose($fh);
	}
	
}



function P($url, $params = '', $method = 0) {
		
		
		// $cookie_jar = tempnam('./temp','cookie');//存放COOKIE的文件
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		//curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 ); // 设置40秒等待响应时间
		curl_setopt ( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:7.0.1) Gecko/20100101 Firefox/7.0.1" );
		
		// curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar); //保存cookie信息
		$data = curl_exec ( $ch );
		curl_close ( $ch );
		return $data;
	}
