<?php
namespace yii\extend;

class Paging{
    /**
     * 创建分页数据
     * @param $parameter
     * [
     *      page => 当前页
     *      pagesize => 每页记录数
     *      count => 记录总数
     * ]
     * @return
     *  [
     *      $page => 当前页
     *      $pagesize => 每页记录数
     *      $count => 记录总数
     *      $start      => 当前页，第一条数据开始的位置
     *      $pagecount  => 分布总数
     *  ]
     */
    public static function create($parameter)
    {
        //页号
        $page = intval($parameter['page']) ? intval($parameter['page']) : 1;
        //每页记录数
        $pagesize = intval($parameter['pagesize']) ? intval($parameter['pagesize']) : 5;
        //所有记录数量
        $count = intval($parameter['count']);
        //记录开始
        $start = ( $page-1 ) * $pagesize;
        //总页数
        $pagecount = ceil( $count / $pagesize );

        return compact('page','pagesize','count','start','pagecount');

    }
}

?>