<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/12
 * Time: 14:38
 */

namespace app\library;

use yii\base\Exception;
use lib\models\Floor;

class FloorLibrary
{
    /**
     * 魔术方法
     * @param type $name 名称
     * @param type $value 数据
     */
    public function _set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * [app 实例化本来]
     * @param  [array] $data [参数]
     * @return [type]       [对象]
     */
    public static function app($data = array())
    {
        $classNmae = __class__;
        $object    = new $classNmae();

        if(!is_array($data) || count($data) <= 0) return $object;

        foreach ($data as $key => $value)
        {
            if (!isset($this->$key))
            {
                throw new Exception($this->$key."参数赋值异常", 403);
            }

            $this->$key = $value;
        }

        return $object;
    }

    /**
     * [getSelectMenu select菜单选项]
     * @param  integer $pid [父ID]
     * @return [type]       [description]
     */
    public function getSelectMenu($pid = 0)
    {
        $menu = $this->getMenu($pid);
        $select = array();

        if (count($menu) > 0)
        {
            foreach ($menu as $key => $value)
            {
                $select[$value['id']] = $value['str_repeat'] . $value['part_name'];
            }
        }

        return $select;
    }

    /**
     * @desc    查询菜单树
     * @access  public
     * @param   int $pid 栏目ID
     * @return  void
     */
    public function getMenu($pid = 0)
    {
        $where = array();
        if (!empty($pid)) $where['pid'] = $pid;

        $data = Floor::find()->orderBy('sort_order asc')->where($where)->all();
        $menu = empty($data) ? array() : $this->getTreeArr(0, $data);

        return $menu;
    }


    /**
     * @desc    所有栏目分类
     * @access  public
     * @param   int $parentid default 0 父栏目ID
     * @param   array $array  所有栏目
     * @param   int $level    栏目等级
     * @param   string $repeat 替换符
     * @return  array
     */
    public function getTreeArr($parentid = 0, $array = array(), $level = 0, $repeat = '-')
    {

        $str_repeat = '';

        if ($level)
        {
            for($i = 0; $i < $level; $i ++)
            {
                $str_repeat .= $repeat;
            }
        }

        $newarray  = array();
        $temparray = array();

        foreach ( ( array ) $array as $value )
        {
            $arr[] = $value->attributes;
        }

        foreach ( ( array ) $arr as $v )
        {
            if ($v ['pid'] == $parentid)
            {
                $v['level'] = $level;
                $v['str_repeat'] = $str_repeat;
                $newarray[] = $v;

                $temparray = self::getTreeArr( $v ['id'], $array, ($level + 2) );

                if ($temparray)
                {
                    $newarray = array_merge ( $newarray, $temparray );
                }
            }
        }

        return $newarray;
    }
}