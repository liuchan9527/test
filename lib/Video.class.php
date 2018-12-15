<?php
class Video
{
    protected static $videoTable = 'third_video';
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

    public static function getVideoPage($page = 1,$count = 8,$pic = false)
    {
        $where = $pic ? ' video_pic != "" ' : ' video_pic = "" ';

        $sql = 'select * from '.self::$videoTable.' where '.$where.' order by time desc limit '.($page-1)*$count.','.$count;
        $videos = Db::query($sql);
        return $videos;
    }
public static function getVideoCount()
{
  $key = 'videoCount';
  $redis = RedisTool::getInstance();
  if($redis -> exists($key)){
	return $redis -> get($key);
  }
  $sql = 'select count(*) c from '.self::$videoTable;
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
        $sql = 'insert into third_video(video_name,video_price,video_url,video_pic,`time`) values(?,?,?,?,?)';
        $db = Db::getIns();
        foreach($videos as $video)
        {
            $stmt = $db -> prepare($sql);
            $stmt -> execute(array(
                $video['title'],
                '3',
                $video['m3u8'],
                $video['img'],
                time()
            ));
        }
    }
}
