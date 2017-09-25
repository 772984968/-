<?php
namespace app\controllers;

use app\controllers\SellerController;
//use app\lib\components\AdCommon;
use lib\components\AdCommon;
use yii\helpers\Url;
use app\library\AdminLibrary;
use app\library\MenuLibrary;
use lib\models\Admin;
use lib\models\AdminGroup;
use lib\models\AdminLogin;
use lib\models\AdminDolog;


/**
* @description 管理员管理
* @date   2015-03-26
* @author [Alisa] <[]>
*/
class AdminController extends SellerController
{
    /**
     * 管理员列表
     * @return array()
     */
    public function actionIndex()
    {
		$model = new Admin();
		$list = $this->query($model, 'group');
		$this->data['count'] = $list['count'];
		$this->data['data'] = $list['data'];
		$this->data['page'] = $list['page'];
       
        return $this->view();
    }
    
	/**
	 * 添加管理员
	 * @return type
	 */
	public function actionAdd()
	{
		$model = new Admin();
		if($this->isPost())
		{
			$post = $this->post('Admin');
			if(empty($post['group_id']) || empty($post['account'])) $this->error(\yii::t('app', 'groupidEmpty'));
			if(!Admin::checkPassword($post['pass']))
			{
				$this->error(\yii::t('app', 'password'));
			}

			$codes = (!empty($post['pass'])) ? AdCommon::randomkeys() : '';

			$model->attributes = [
                'group_id' => $post['group_id'],
                'account'  => $post['account'],
				'codes'	   => $codes,		
                'pass'     =>  Admin::encryPassword($codes, $post['pass']),
                'nickname' => $post['nickname'],
				'email'    => $post['email'],
				'phone'    => $post['phone'],
				'state'    => $post['state'],
				'uptime'   => time(),	 
            ];
           
            $model->save();

			if (!empty($model->errors))
            {
                $this->error(AdCommon::modelMessage($model->errors));
			}
            else
            {
				$this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['admin']);
            }
		}
		else
		{	
			
			$this->data['power'] = AdminLibrary::app()->adminRole();
			$model->state        = 1;	//设置Admin表中state 默认选中
			$this->data['model'] = $model;
			return $this->view();
		}
	}		

	/**
	 * 管理员修改
	 * @return type
	 */
    public function actionEdit()
	{
		if($this->isPost())
		{
			$post = $this->post('Admin');
			$model = Admin::findOne($post['id']);
			$codes = AdCommon::randomkeys();
			if(!empty($post['pass']))
			{
                if(!Admin::checkPassword($post['pass']))
                {
                    $this->error(\yii::t('app', 'password'));
                }
				$model->codes = $codes;
				$model->pass = Admin::encryPassword($codes, $post['pass']);
			}

			$model->group_id = $post['group_id'];
			$model->account = $post['account'];
			$model->nickname = $post['nickname'];
			$model->email = $post['email'];
			$model->phone = $post['phone'];
			$model->state = $post['state'];
			$model->uptime = time();
            $model->save();

			if(empty($model->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['admin']);
			}
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
		}
		else
		{
			$id = (int)$this->get('id');
			$model = Admin::find()->with('group')->where(['id' => $id])->one();
	
			$this->data['power'] = AdminLibrary::app()->adminRole();
			$this->data['model'] = $model;
			return $this->view();
		}
	}	

	/**
	 * 删除管理员
	 */
	public function actionDel()
	{
		$id = (int)$this->post('data');
		if (empty($id)) 
        {
            $this->error(\Yii::t('app', 'error'));
        }
		$query = Admin::findOne($id)->delete();
		if ($query) 
		 {
			 $this->success(\Yii::t('app', 'success'));
		 }
		 else
		 {
			 $this->error(\Yii::t('app', 'fail'));
		 }
	}

    /**
     * [actionInfo 管理员个人资料]
     * @return [type] [description]
     */
    public function actionInfo()
    {
        $id = $this->get('id');
        if ($id == '') $this->error(\yii::t('app', 'error'));
        $model = Admin::findOne($id);
        if (empty($model['id'])) $this->error(\yii::t('app', 'adminEmpty'));

        if($this->isPost())
        {
            $post = $this->post('Admin');
            if(!empty($post['pass']))
            {
                if(!Admin::checkPassword($post['pass'])) $this->error(\yii::t('app', 'password'));

                $post['pass'] = Admin::encryPassword($model->codes, $post['pass']);
            }
            $post['uptime']    = time();
            $model->attributes = $post;
            $model->save();
            if(empty($model->errors))
            {
                $this->success(\yii::t('app', 'success'));
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }

        $this->data['power'] = AdminLibrary::app()->adminRole();
        $this->data['model'] = $model;
        return $this->view('edit');
    }

	/**
	 * 管理员登录日志
	 * @return type
	 */
	public function actionAdlogin()
	{
		$search = $this->get('search');
        $where   = '';

		if(!empty($search['type']) && !empty($search['keyword']))
		{
			$where = $search['type']. " like '%" .$search['keyword'] ."%'";
		}

		if(!empty($search['stime']))
		{
            $stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
			$where = 'login_time BETWEEN '. $stime . ' and '. $etime;
		}	

        $model = new AdminLogin();
        $query = $this->query($model, '', $where);

		$this->data['data']   = $query['data'];
		$this->data['page']   = $query['page'];
        $this->data['count']  = $query['count'];
		$this->data['search'] = ['uid' => \yii::t('app', 'adminId'), 'account' => \yii::t('app', 'account')];
		return $this->view();
	}

	/**
	 * 管理员操作日志
	 * @return type
	 */
	public function actionLog()
	{
		$search = $this->get('search');
		$where = '1=1';
        
		if(!empty($search['type']) && !empty($search['keyword']))
		{
            if ($search['type'] == 'title') 
            {
                $where = $search['type']. " like '%" .$search['keyword'] ."%'";
            }
            else
            {
                $where = $search['type']. "='" .$search['keyword'] ."'";
            }
			
		}

		if(!empty($search['stime']))
		{
			$stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
            $where = 'time BETWEEN '. $stime . ' AND ' . $etime;
		}	
        $model = new AdminDolog();
        $query = $this->query($model, '', $where);
        $this->data['data']   = $query['data'];
        $this->data['page']   = $query['page'];
        $this->data['count']  = $query['count'];
		$this->data['search'] = ['uid' => \yii::t('app', 'adminId'), 'username' => \yii::t('app','account'), 'title' => \yii::t('app','doing')];
		return $this->view();
	}

	/**
     * 角色列表
     * @return [type] [description]
     */
    public function actionRole()
    {   
        $model = new AdminGroup();
        $query = $this->query($model);
        
        $this->data['data'] = $query['data'];
        $this->data['page'] = $query['page'];
        $this->data['count'] = $query['count'];

        return $this->view();
    }

    /**
     * [actionAddrole 添加角色]
     * @return [type] [description]
     */
    public function actionAddrole()
    {  
        if ($this->isPost()) 
        {
            $model = new AdminGroup();
            $roleName  = $this->post('roleName');
            $pPower = $this->post('power');
            $sPower = $this->post('powerid');
            $rolePower = implode(',', array_merge((array)$pPower, (array)$sPower));

            $model->attributes = [
                'group_name' => $roleName,
                'create_time' => time(),
                'create_user' => $this->admin['account'],
                'power'       => $rolePower,
            ];

            if (!$model->validate()) 
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
            else
            {
                $model->save();
                $this->success(\Yii::t('app', 'success'), Url::toRoute(\yii::$app->params['url']['role']));
            }

        } 

        $menu = MenuLibrary::app()->getUserMenu();
        $this->data['menu'] = MenuLibrary::app()->powerHtml($menu);
        return $this->view();
    }

    /**
     * [actionUprole 修改角色]
     * @return [type] [description]
     */
    public function actionEditrole()
    {
        $id    = $this->get('id');
        if (empty($id)) 
        {
            $this->error(\Yii::t('app', 'error'));
        }

        $model = AdminGroup::findOne(['id' => $id]);
            
        if ($this->isPost()) 
        {
            $roleName  = $this->post('roleName');
            $pPower = $this->post('power');
            $sPower = $this->post('powerid');
            $rolePower = implode(',', array_merge((array)$pPower, (array)$sPower));

            $model->group_name = $roleName;
            $model->power      = $rolePower;

            if (!$model->validate()) 
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
            else
            {
                $model->save();
                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['role']);
            }

        } 
        
        #角色权限
        $rolePower = explode(',', $model['power']);
        $menu      = MenuLibrary::app()->getUserMenu();

        $this->data['menu'] = MenuLibrary::app()->powerHtml($menu, $rolePower);
        $this->data['model'] = $model;
        return $this->view();
    }

    /**
     * [actionDelrole 删除角色]
     * @return [type] [description]
     */
    public function actionDelrole()
    {
        $id    = $this->post('data');
        if (empty($id)) 
        {
            $this->error(\Yii::t('app', 'error'));
        }

        $is_admin = Admin::findOne(['group_id' => $id]);

        if ($is_admin['id']) 
        {
           $this->error(\Yii::t('app', 'delRole'));
        }
        else
        {
            $query = AdminGroup::deleteAll(['id' => $id]);

            if ($query) 
            {
                $this->success(\Yii::t('app', 'success'));
            }
            else
            {
                $this->error(\Yii::t('app', 'fail'));
            }
        }

    }

    /**
     * 用户类型列表
     * @return [type]
     */
    public function actionLabel()
    {
        $usercate = \app\lib\models\UserCate::find()->all();
        $catelist = Menulibrary::app()->getTreeArr(0,$usercate);
        $this->data['data'] = $catelist;
        return $this->view();
    }

    /**
     * 更改用户类型权限列表
     * @return [type]
     */
    public function actionUplabel()
    {
        $id = \yii::$app->request->get('id','');
        if($id !='')
        {
            if ($this->isPost()) 
            {   
                //商品标签的id
                $id  = $this->post('id');
                //价格
                $power = $this->post('power');
                $powerid = $this->post('powerid');
                //批发价
                $powerp = $this->post('powerp');
                $powerpid = $this->post('powerpid');
                //发布
                $push = $this->post('push');
                $pushid = $this->post('pushid');
                //以价格购买
                $buy = $this->post('buy');
                $buyid = $this->post('buyid');
                //以批发价购买
                $buyp = $this->post('buyp');
                $buypid = $this->post('buypid');
                try
                {
                    $transaction = \Yii::$app->db->beginTransaction();
                    if($power != '' && $powerid !='')
                    {
                       $this->SaveData($id,$powerid,$power);
                    }
                    if($powerp != '' && $powerpid !='')
                    {
                       $this->SaveData($id,$powerpid,$powerp);
                    }
                    if($push != '' && $pushid !='')
                    {
                       $this->SaveData($id,$pushid,$push);
                    }
                    if($buy != '' && $buyid !='')
                    {
                       $this->SaveData($id,$buyid,$buy);
                    }
                    if($buyp != '' && $buypid !='')
                    {
                       $this->SaveData($id,$buypid,$buyp);
                    }
                    //提交事务
                    $transaction->commit();
                    $this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['label']);
                }catch(Exception $e)
                {
                    $transaction->rollBack();
                    $this->error('更新失败');
                }
            } 
            //用户类型信息
            $usercate =new \lib\models\UserCate();
            $userdata = $usercate->find()->where("pid !=0")->asArray()->all();
            //用户类型信息
            $username = \app\lib\models\UserCate::find()->where(['id' => $id])->asArray()->one();
            //标签访问权限
            $goodsModel =new \lib\models\GoodsPower();
            $goodspower = $goodsModel->find()->where(['user_type' => $id])->asArray()->all();
            $access = [];
            if($goodspower)
            {
                foreach ($goodspower as $k => $v) 
                {
                    $access[$v['power_type']] = explode(',',$v['power']);
                }
            }

            $this->data['name'] = isset($username['name'])?$username['name']:'';
            $this->data['userdata'] = $userdata; 
            $this->data['id'] = $id;
            $this->data['access'] = $access;

            return $this->view();
        }
    }

    private function SaveData($id,$powerid,$power)
    {
        $goodsModel =new \lib\models\GoodsPower();
        $powerlist = implode(',',$powerid);
        $goodspower = $goodsModel->find()->where(['user_type' => $id,'power_type' => $power])->one();
        if($goodspower)
        {
            $goodspower->modified = time();
            $goodspower->power = $powerlist;
            $goodspower->save();
        }else
        {
            $goodsModel->user_type = $id;
            $goodsModel->power_type = $power;
            $goodsModel->created = time();
            $goodsModel->modified = time();
            $goodsModel->power = $powerlist;
            $goodsModel->save();
        }
    }
}   