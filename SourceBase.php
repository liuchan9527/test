<?php
require_once 'init.php';
require_once 'SourceInterface.php';
abstract class SourceBase implements SourceInterface
{
    protected $cacheListHtml = './tempList.html';
    protected $cacheArticleHtml = './tempArticle.html';

    protected $cacheList = '';
    protected $cacheArticle = '';
    protected $listUrl = '';//列表URL地址

    public function __construct()
    {

    }

    /**
     * 根据页码返回列表页url
     * @param $page
     * @return mixed
     */
    abstract protected function getListPageUrl($page);

    /**
     * 获取列表块匹配表达式
     * @return mixed
     */
    abstract protected function getListPattern();

    /**
     * 获取图片匹配表达式
     * @return mixed
     */
    abstract protected function getImgPattern();

    /**
     * 视频m3u8地址匹配表达式
     * @return mixed
     */
    abstract protected function getM3u8Pattern();

    /**
     * 标题匹配表达式
     * @return mixed
     */
    abstract protected function getTitlePattern();

    /**
     * 解析详细地址
     * @return mixed
     */
    abstract protected function getArticleUrlPattern();

    /**
     * 获取详细页m3u8匹配地址
     * @return mixed
     */
    abstract protected function getArticleM3u8Pattern();

    /**
     * 从列表获取m3u8匹配规则
     * @return mixed
     */
    abstract protected function getListM3u8Pattern();
    abstract protected function getArticleUrl($link);
    abstract protected function handleM3u8($mp4Url);
    /**
     * 下载页面并存储到临时文件
     * @param $url
     * @param $cacheFile
     * @param $readCache
     * @return string
     */
    protected function downloadHtml($url,$cacheFile,$readCache = true)
    {
        if($readCache && (file_exists($cacheFile) || filesize($cacheFile) != 0))
        {
            return file_get_contents($cacheFile);
        }
        $headers = array(
            'Accept-Language: zh-CN,zh;q=0.9'
        );
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_TIMEOUT, 5);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        $result = curl_exec ( $ch );
        if(curl_errno($ch)){
            exit ('Curl error:'.curl_error($ch));
        }
        curl_close ( $ch );
        file_put_contents($cacheFile , $result);
        return $result;
    }

    /**
     * 主方法
     * @param $maxPage int 拉取最大页码
     */
    public function run($maxPage = 10)
    {
        header('Content-type:text/html;charset=utf-8');
        //下载列表资源
        $page = 0;
        while($page < $maxPage)
        {
	    $list = array();
            $page++;
            $tmpArr = array();
            //获取列表页html内容
            $this -> cacheList = $this -> downloadHtml($this -> getListPageUrl($page),$this -> cacheListHtml,false);
            //1.解析列表段
            preg_match_all($this -> getListPattern(),$this -> cacheList,$blockes);
            foreach($blockes[0] as $key => $block)
            {
                //2.解析图片地址
                preg_match($this -> getImgPattern(),$block,$imgsrc);
                if(!empty($imgsrc[1])){
                    $tmpArr['img'] = $imgsrc[1];
                }

                //3.解析标题
                preg_match($this -> getTitlePattern(),$block,$title);
                if(!empty($title[1])){
                    $tmpArr['title'] = $title[1];
                }
                //4.解析m3u8地址
                    //判断是否能从列表获取到匹配规则
                    if(!$this -> getListM3u8Pattern()){
                        //无匹配规则，从详情页获取
                        preg_match($this -> getArticleUrlPattern(),$block,$articleUrl);
                        if(!empty($articleUrl[1])){
                            //下载article缓存
                            $this -> cacheArticle = $this -> downloadHtml($this -> getArticleUrl($articleUrl[1]),$this -> cacheArticleHtml,false);
                            preg_match($this -> getArticleM3u8Pattern(),$this -> cacheArticle,$articleMp4);
                            if(!empty($articleMp4[1])){
                                $tmpArr['mp4'] = $articleMp4[1];
                                $tmpArr['m3u8'] = $this -> handleM3u8($articleMp4[1]);


                            }
                        }

                    }else{
                        //
                    }
                //5.匹配视频地址
$v = $tmpArr['title'].PHP_EOL;
echo $v;
file_put_contents('325ww.log',$v,FILE_APPEND);
                $list[] = $tmpArr;
            }
        Video::saveThirdVideo($list);
        }
    }

    public function __destruct()
    {
        //@unlink($this -> cacheHtml);
    }
}
