<?php
require_once 'SourceBase.php';

class www_325ww_com extends SourceBase
{
    protected $host = 'https://www.638ww.com/';
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
        return '/<li>(.+)<\/li>/Us';
    }
    protected function getM3u8Pattern()
    {
        return '/<video.+src="(.+)".+<\/video>/Us';
    }
    protected function getTitlePattern()
    {
        return '/<h3>(.+)<\/h3>/Us';
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
        return false;
    }

    public function getListPageUrl($page)
    {
        if($page == 1){
            return $this -> host . '/Html/93/';
        }
        return $this -> host .'/Html/93/index-'.$page.'.html';
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
$class = new www_325ww_com();
$class -> setType(4,'开放90后');
$class -> run(1,23);
$redis = RedisTool::getInstance();
$redis -> del('videoCount');
