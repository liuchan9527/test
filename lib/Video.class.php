<?php
class Video
{
    protected static $videoTable = 'third_video2';
    public static function getTodayVideo($limit = 15,$pic = false)
    {
        $where = $pic ? ' video_pic != "" ' : ' video_pic = "" ';

        $sql = 'select * from '.self::$videoTable.' where '.$where.' order by time desc limit 15';
        $videos = Db::query($sql);
        return $videos;
    }
    public static function getVideoById($id)
    {
        $id = $id + 0;
        return Db::getOne('select * from '.self::$videoTable.' where id = '.$id);
    }

    public static function getVideoPage($page = 1,$count = 8,$pic = false,$salt = 0)
    {
	$where = '1=1';
        $where .= $pic ? ' and video_pic != "" ' : ' and video_pic = "" ';
	$salt = $salt == 0 ? date('j') : $salt;
	$where .= ' and id%'.$salt.'=0';
	$where .= ' and status = 1';
        $sql = 'select * from '.self::$videoTable.' where '.$where.' order by id asc limit '.($page-1)*$count.','.$count;
        $videos = Db::query($sql);
        return $videos;
    }
//获取免费播放次数
public static function getFreePlayTimes($ssid)
{
return 0;
 //一天生成一个免费key
 $key = 'Free:'.date('Ymd');
 $redis = RedisTool::getInstance();
 if($redis -> sIsMember($key,$ssid)){
   return 0;
 }
 return 1;
}
//使用免费播放
public static function useFreePlay($ssid)
{
 $key = 'Free:'.date('Ymd');
 $redis = RedisTool::getInstance();
 $redis -> sAdd($key,$ssid);
 if($redis -> ttl($key) == -1){
     $redis -> expire($key,86400);
 }
}
public static function getVideoCount()
{
  $key = 'videoCount';
  $redis = RedisTool::getInstance();
  if($redis -> exists($key)){
	return $redis -> get($key);
  }
  $sql = 'select count(*) c from '.self::$videoTable.' where id%'.date('j').'=0';
  $count = Db::getOne($sql);
  $redis -> setex($key,60*60*2,$count['c']);
  return $count['c'];
}
public static function canPlay($vid,$session_id)
{
  $key = 'Play:'.$session_id.':'.$vid;
  $redis = RedisTool::getInstance();
  return $redis -> exists($key);
}

    /**
     * 保存第三方视频库
     * @param array $videos
     */
    public static function saveThirdVideo(array $videos)
    {
        $sql = 'insert into third_video2(video_name,video_price,video_url,video_pic,`time`,type_id,type_name) values(?,?,?,?,?,?,?)';
        $db = Db::getIns();
        foreach($videos as $video)
        {
            $stmt = $db -> prepare($sql);
            $stmt -> execute(array(
                $video['title'],
                '3',
                $video['m3u8'],
                $video['img'],
                time(),
                $video['type_id'],
                $video['type_name']
            ));
        }
    }
}
