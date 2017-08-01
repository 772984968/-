<?php
namespace app\library;

use yii\base\Exception;
use lib\models\Admin;
use lib\models\AdminLogin;
use lib\models\AdminGroup;

/**
 * 
 * @Copyright (C), 2014-03-30, Alisa.
 * @Name Adminlibray.php
 * @Author Alisa 
 * @Version  Beta 1.0
 *              
 **/
class Adminlibrary
{
	
    /**
     * 魔术方法
     * @param type $name 名称
     * @param type $value 数据
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * [app 实例化本类]
     * @param  [type] $initData [参数]
     * @return [type]           [description]
     */
    public static function app($initData = null)
    {
        $name = __CLASS__;
        $object = new $name();
        if(!is_array($initData) || count($initData) <= 0)
        {
            return $object;
        }
        
        foreach($initData as $key => $arr)
        {
            if(!isset($this->$key))
            {
                throw new Exception($this->$key."参数赋值异常", 403);
            }
            $this->$key = $arr;
        }

        return $object;
    }
	
	/**
     * [login 登录方法]
     * @param  [array] $data [表单数据]
     * @return [array]       [返回状态]
     */
	public function login($data)
	{	
		$adminInfo = Admin::findOne(['account' => $data['account'], 'state' => 1]);
		if($adminInfo['id'] == '') return ['status' => 1002, 'msg' => '用户名不存在！'];
        $adminInfo = $adminInfo->toArray();
		$password = Admin::encryPassword($adminInfo['codes'], $data['pwd']);
		//echo $password;die();
		
		if($password != $adminInfo['pass'])
		{
			return ['status' => 1003, 'msg' => '密码错误！'];
		}
		else
		{
            $power = AdminGroup::findOne(['id' => $adminInfo['group_id']]);
            $menu  = isset($power['power']) && $power['power'] != '' ? $power['power'] : array();

            $adminInfo['isAdmin']   = $power['is_admin'];
            $adminInfo['loginTime'] = time();
            $adminInfo['loginIp']   = \Yii::$app->request->getUserIP();

            $this->adminLoginLog($adminInfo);                # 登录日志
            
            $this->_saveSession($adminInfo, $menu);          # session 

			return ['status' => 0, 'msg' => '登录成功！'];
		}
	}

    /**
     * [adminLoginLog 用户登录日志]
     * @param  [type] $admin [用户信息]
     * @return [type]        [description]
     */
    public function adminLoginLog($admin)
    {
        $model = new AdminLogin();
        $model->attributes = [
            'uid'        => $admin['id'],
            'account'    => $admin['account'],
            'nickname'   => $admin['nickname'],
            'login_ip'   => $admin['loginIp'],
            'login_time' => $admin['loginTime'],
        ];

        $model->save();

    }

    /**
     * [adminRole 查询所有管理员角色]
     * @return [type] [description]
     */
    public function adminRole()
    {
        $power = AdminGroup::find()->where(['state'=>1])->all();
        $powers = array();
        if (is_array($power) && !empty($power))
        {
            foreach ($power as $k => $v)
            {
                if ($v['is_admin'] == 0)
                {
                    $powers[$v['id']] = $v['group_name'];
                }
            }
        }

        return $powers;
    }

	
	/**
     * [_saveSession 保存用户会话]
     * @param  [array] $data [用户信息]
     * @return [type]       [description]
     */
	private function _saveSession($data, $menu)
	{
        $data['isLogin']  = true;

		\Yii::$app->session['admin'] = $data;
        \Yii::$app->session['power'] = $menu;
	}
}

?>