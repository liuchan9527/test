<?php
class Video
{
    public static function getTodayVideo($limit = 15,$pic = false)
    {
        $where = $pic ? ' video_pic != "" ' : ' video_pic = "" ';

        $sql = 'select * from front_video where '.$where.' order by time desc limit 15';
        $videos = Db::query($sql);
        return $videos;
    }
    public static function getVideoById($id)
    {
        $id = $id + 0;
        return Db::getOne('select * from front_video where id = '.$id);
    }

    public static function getVideoPage($page = 1,$count = 8,$pic = false)
    {
        $where = $pic ? ' video_pic != "" ' : ' video_pic = "" ';

        $sql = 'select * from front_video where '.$where.' order by time desc limit '.($page-1)*$count.','.$count;
        $videos = Db::query($sql);
        return $videos;
    }
}