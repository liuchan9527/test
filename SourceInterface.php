<?php
interface SourceInterface
{
    /**
     * 拉取列表资源
     * @param $page int 拉取初始页
     * @param $maxPage int 拉取最大页码
     * @return mixed
     */
    public function pullListPage($page = 1,$maxPage = 10);

}