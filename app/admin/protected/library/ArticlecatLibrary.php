<?php
namespace app\library;

use yii\base\Exception;
use lib\models\Articlecat;

/**
 *
 * @Copyright (C), 2016-01-20, Alisa.
 * @Name Menulibrary.php
 * @Author lijunwei
 * @Version  Beta 1.0
 *
 **/
class ArticlecatLibrary
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
     * @param  integer $parent_id [父ID]
     * @return [type]       [description]
     */
    public function getSelectMenu($parent_id = 0)
    {
        $menu = $this->getMenu($parent_id);
        $select = array();

        if (count($menu) > 0)
        {
            foreach ($menu as $key => $value)
            {
                $select[$value['cat_id']] = $value['str_repeat'] . $value['cat_name'];
            }
        }

        return $select;
    }

    /**
    * @desc    查询菜单树
    * @access  public
    * @param   int $parent_id 栏目ID
    * @return  void
    */
    public function getMenu($parent_id = 0)
    {
        $where = array();
        if (!empty($parent_id)) $where['parent_id'] = $parent_id;

        $data = articlecat::find()->orderBy('sort_order asc')->where($where)->all();
        $menu = empty($data) ? array() : $this->getTreeArr(0, $data);

        return $menu;
    }


    /**
    * @desc    所有栏目分类
    * @access  public
    * @param   int $parent_id default 0 父栏目ID
    * @param   array $array  所有栏目
    * @param   int $level    栏目等级
    * @param   string $repeat 替换符
    * @return  array
    */
    public function getTreeArr($parent_id = 0, $array = array(), $level = 0, $repeat = '-')
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
            if ($v ['parent_id'] == $parent_id)
            {
                $v['level'] = $level;
                $v['str_repeat'] = $str_repeat;
                $newarray[] = $v;

                $temparray = self::getTreeArr( $v['cat_id'], $array, ($level + 2) );

                if ($temparray)
                {
                    $newarray = array_merge ( $newarray, $temparray );
                }
            }
        }

        return $newarray;
    }


    /**
     * @desc    查询栏目树
     * @access  public
     * @param   int $categoryid 栏目ID
     * @return  void
     */
    public function getCategory($where=array())
    {
        $data = articlecat::find()->where($where)->orderBy('cat_id ASC')->all();
        if(empty($data)) return $data;
        foreach ( ( array ) $data as $value ) {
            $arr[$value['cat_id']] = $value->attributes;
        }
        return $arr;
    }


    /**
     * [getShopMenu 禁止菜单列表]
     * @param  [type] $menu [description]
     * @return [type]       [description]
     */
    public function getBanMenu($menu = array())
    {
        if(empty($menu)) $menu = power::find()->orderBy('order asc')->all();
        $arr = array();
        foreach ($menu as $key => $value)
        {
            if(!$value['isdefault']){
                $arr[$value['id']] = $value->getAttributes();
                $arr[$value['id']]['url'] = isset(\yii::$app->params['url'][$value['url']]) ? \yii::$app->params['url'][$value['url']] : '';
            }
        }

        $userMenu = $this->generateTree($arr);

        return $userMenu;
    }



    /**
     * [getUserMenu 用户权限]
     * @param  [type] $menu [description]
     * @return [type]       [description]
     */
    public function getUserMenu($menu = array())
    {
        if(empty($menu)) $menu = power::find()->where(['state' => 1])->orderBy('order asc')->all();
        $arr = array();
        foreach ($menu as $key => $value)
        {
            $arr[$value['id']] = $value->getAttributes();
            $arr[$value['id']]['url'] = isset(\yii::$app->params['url'][$value['url']]) ? \yii::$app->params['url'][$value['url']] : '';
        }

        $userMenu = $this->generateTree($arr);

        return $userMenu;
    }

    /**
     * [generateTree 分类树]
     * @param  [array] $items [description]
     * @return [type]        [description]
     */
    public function generateTree($items)
    {
        $tree = array();
        foreach($items as $item){
            if(isset($items[$item['pid']]))
            {
                $items[$item['pid']]['menu'][] = &$items[$item['id']];
            }
            else
            {
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    /**
     * [powerHtml 生成角色权限菜单]
     * @param  array  $userPower [角色权限]
     * @return [type]            [description]
     */
    public function classifyHtml($classify = array(), $userPower = array())
    {
        $html = '<table id="table" class="table table-hover table-bordered">';
        foreach ($classify as $k => $v)
        {
            $checked = in_array($v['id'], $userPower) || ((isset($v['isdefault']) && $v['isdefault'])) ? 'checked="checked"' : '';
            $hidden  = (isset($v['isdefault']) && $v['isdefault']) ? 'hidden' : '';
            $html .= '<tr class="root_div">';
            $html .= '<td width="100"><input type="checkbox" id="inlineCheckbox1" name="classify[]" value="' . $v['id'] .'" '. $checked . $hidden .'>&nbsp;<b>' . $v['name'] . '</b></td>';
            $html .= '<td class="son_div">';
            if (isset($v['menu']) && !empty($v['menu']))
            {
                $html .= $this->powerTree($userPower, $v['menu'], '');
            }

            $html .= '</td>';
            $html .= '</tr>';

        }
        $html .= '</table>';
        return $html;
    }

    /**
     * [powerTree 递归循环子菜单]
     * @param  [type] $userPower [角色权限]
     * @param  [type] $item [子菜单]
     * @param  [type] $html [description]
     * @return [type]       [description]
     */
    public function classifyTree($userPower, $item, $html)
    {
        foreach ($item as $key => $value)
        {
            $checked  = in_array($value['id'], $userPower) || ((isset($value['isdefault']) && $value['isdefault'])) ? 'checked="checked"' : '';
            $hidden   = (isset($value['isdefault']) && $value['isdefault']) ? 'hidden' : '';

            $html .= '<span><input type="checkbox" id="inlineCheckbox1" name="powerid[]" value="' . $value['id'] .'" '. $checked  . $hidden .'>&nbsp;' . $value['name']."</span>";

            if (isset($value['menu']) && !empty($value['menu'])) $html = $this->powerTree($userPower, $value['menu'], $html);
        }

        return $html;
    }

    /**
     * [getPower 查询用户权限]
     * @param  [type] $classify [角色菜单ID]
     * @return [type]        [description]
     */
    public function getClassify($classify = '')
    {
        $where = !empty($classify) ? 'where id in(' . $classify . ') and state=1' : 'where state=1';
        $query = Power::findBySql('select url from ' . Power::tableName() . $where)->all();
        $url   = array();

        foreach ($query as $key => $value)
        {
           array_unshift($url, $value['url']);
        }

        return $url;
    }

    /**
     * [setPower 角色权限]
     * @param [type] $classify [description]
     */
    public function setClassify($classify)
    {
        $query = Power::findBySql('select * from '.Power::tableName().' where id in(' . $classify . ') and state=1')->all();

        return $this->getUserMenu($query);
    }
}