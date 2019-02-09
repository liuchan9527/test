<?php
require_once 'SourceBase.php';

class yinongyouxuan_wang extends SourceBase
{
    protected $host = 'http://yinongyouxuan.wang';
    public function pullListPage($page = 1, $maxPage = 10)
    {
        // TODO: Implement pullListPage() method.
    }

    protected function getImgPattern()
    {
        return '/<img src="(.+)"/Us';
    }
    protected function getListPattern()
    {
        return '/<div class="card nopadding">(.+)<\/div><\/div>/Us';
    }
    protected function getM3u8Pattern()
    {
        return '/<video.+src="(.+)".+<\/video>/Us';
    }
    protected function getTitlePattern()
    {
        return '/<h2>(.+)<\/h2>/Us';
    }

    protected function getArticleM3u8Pattern()
    {
        // TODO: Implement getArticleM3u8Pattern() method.
        return '/var down_url = \'(.+)\';/Us';
    }

    protected function getArticleUrlPattern()
    {
        return '/<a href="(.+)"/Us';
    }

    protected function getListM3u8Pattern()
    {
        //此资源站没有
        return true;
    }

    protected function getVideoM3u8($str){

	return dirname($str).'/index.m3u8';
}

    public function getListPageUrl($page)
    {
        return $this -> host .'/movies?page='.$page;
    }

    protected function getArticleUrl($link)
    {
        return $this -> host.$link;
    }
    protected function handleM3u8($mp4Url)
    {
        $mp4Url = str_replace("https://d.9xxav.com/","/",$mp4Url);
        return 'https://p.cdnplay001.com/'.$mp4Url.'.m3u8';
    }
    public function setType($id,$name)
    {
        $this -> types = array(
           'typeid' =>  $id,
            'typename' => $name
        );
    }


}
//print_r(pathinfo('https://d.9xxav.com/20181214/89/2229/2229.mp4'));
//exit;
$class = new yinongyouxuan_wang();
ob_end_clean();
$class -> setType(8,'');
$class -> run(219,434);
$redis = RedisTool::getInstance();
$redis -> del('videoCount');
