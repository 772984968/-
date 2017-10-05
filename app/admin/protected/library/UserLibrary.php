<?php
namespace app\library;
use lib\components\AdCommon;
use lib\models\User;
use lib\models\UserBank;
use lib\models\UserAccount;
use lib\models\UserData;
use lib\models\Good;
use lib\models\GoodThumb;
use lib\models\UserThumb;
class UserLibrary
{
    /**
     * [app description]
     * @return [type] [description]
     */
    public static function app()
    {
        $class = __class__;
        $object = new $class;
        return $object;
    }

    /**
     * [addUser 添加用户]
     * @param [type] $user    [description]
     * @param [type] $bank    [description]
     * @param [type] $address [description]
     */
    public function addUser($user, $bank, $info)
    {
        $user['codes'] = AdCommon::uniqueGuid();
        $user['pawd']  = AdCommon::encryption($user['codes'].$user['pawd']);
        $user['register_time'] = time();
        $user['lastlogin'] 		= $user['register_time'];
        $user['register_ip']  	= \Yii::$app->request->getUserIP();
        $transaction = \yii::$app->db->beginTransaction();
        try
        {
            $model = new User();
            $model->attributes = $user;
            $model->save();
            if(empty($model->errors))
            {
                #银行卡
                $bank['uid'] = $model->id;
                $bmodel = new UserBank();
                $bmodel->attributes = $bank;
                $bmodel->save();

                #个人资料
                $info['uid']           = $model->id;
                $amodel = new UserData();
                $amodel->attributes = $info;
                $amodel->save();

                #账户资金
                $userAccount = new UserAccount();
                $userAccount->attributes = ['uid' => $model->id, 'account' => 0, 'account_int' => 0,'account_out' => 0, 'points' => 0];
                $userAccount->save();
                if(empty($model->errors) && empty($bmodel->errors) && empty($amodel->errors) && empty($userAccount->errors))
                {
                    $transaction->commit();
                    return ['state' => true, 'msg' => \yii::t('app', 'success')];
                }
                else
                {
                    $transaction->rollback();
                    return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors).AdCommon::modelMessage($bmodel->errors).AdCommon::modelMessage($amodel->errors).AdCommon::modelMessage($userAccount->errors)];
                }
            }else {
            	return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors)];
            }
        }
        catch (Exception $e) {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }

 /**
     * [updateUser 修改用户]
     * @param  [type] $uid     [description]
     * @param  [type] $user    [description]
     * @param  [type] $bank    [description]
     * @param  [type] $address [description]
     * @return [type]          [description]
     */
    public function updateUser($uid, $user)
    {
        $model  = User::findOne($uid);

        $transaction = \yii::$app->db->beginTransaction();
        try
        {
            #用户基本信息
            $model->attributes = $user;
            $model->save();
            #银行卡
//             if(empty($bmodel['bank_id'])) $bmodel = new UserBank();

//             $bank['uid'] = $model['id'];
//             $bmodel->attributes = $bank;
//             $bmodel->save();

//             #收货地址
//             if(empty($amodel['id'])) $amodel = new UserData();
//             $data['uid'] = $model['id'];
//             $amodel->attributes = $data;
//             $amodel->save();

            if(empty($model->errors))
            {
                $transaction->commit();
                return ['state' => true, 'msg' => \yii::t('app', 'success')];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors)];
            }
        } catch (Exception $e) {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }
    /**
     * [addGood 添加服务]
     * @param [type] $uid [用户ID]
     * @param array  $service  [服务内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function addGood($uid, $service,$thumb = array())
    {
		$transaction = \yii::$app->db->beginTransaction();
		try
		{
			$good = new Good();
			$service['uid'] = $uid;
			$good->attributes = $service;
			$good->save();

			$thumbError = '';
			if(isset($thumb['url']) && count($thumb['url']) > 0)
			{
				$result = $this->addThumb($good->id, $thumb);
				if(!$result['state']) $thumbError = $result['msg'];
			}

			if(empty($good->errors) && empty($thumbError))
			{
				$transaction->commit();
				return ['state' => true, 'msg' => ''];
			}
			else
			{
				$transaction->rollback();
				return ['state' => false, 'msg' => AdCommon::modelMessage($good->errors).$thumbError];
			}
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			return ['state' => false, 'msg' => \yii::t('app', 'fail')];
		}
    }
    /**
     * [updateService 修改服务信息]
     * @param   int $gid [服务ID]
     * @param  [array] $form  [表单内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function updateGood($gid, $form, $thumb = array())
    {
    	$transaction = \yii::$app->db->beginTransaction();
    	try
    	{
    		$model = Good::findOne($gid);
    		$model->attributes = $form;
    		$model->save();

    		$thumbError = '';

    		if(isset($thumb['url']) && count($thumb['url']) > 0)
    		{
    			\lib\models\GoodThumb::deleteAll('gid='.$gid);
    			$result = $this->addThumb($gid, $thumb);
    			if(!$result['state']) $thumbError = $result['msg'];
    		}
    		if(empty($model->errors) && empty($thumbError))
    		{
    			$transaction->commit();
    			return ['state' => true, 'msg' => ''];
    		}
    		else
    		{
    			$transaction->rollback();
    			return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors).$thumbError];
    		}
    	}
    	catch (Exception $e)
    	{
    		$transaction->rollback();
    		return ['state' => false, 'msg' => \yii::t('app', 'fail')];
    	}
    }
    /**
     * [addAlbum 添加相册]
     * @param [type] $uid [用户ID]
     * @param array  $service  [服务内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function addAlbum($uid, $album,$thumb = array())
    {
    	$transaction = \yii::$app->db->beginTransaction();
    	try
    	{
    		$UserThumb = new UserThumb();
    		$UserThumb['uid'] = $uid;
    		$UserThumb->attributes = $album;
    		$UserThumb->save();
    		$thumbError = '';
    		if(isset($thumb['url']) && count($thumb['url']) > 0)
    		{
    			$result = $this->addThumblist($UserThumb->id, $thumb);
    			if(!$result['state']) $thumbError = $result['msg'];
    		}
    		if(empty($UserThumb->errors) && empty($thumbError))
    		{
    			$transaction->commit();
    			return ['state' => true, 'msg' => ''];
    		}
    		else
    		{
    			$transaction->rollback();
    			return ['state' => false, 'msg' => AdCommon::modelMessage($UserThumb->errors).$thumbError];
    		}
    	}
    	catch (Exception $e)
    	{
    		$transaction->rollback();
    		return ['state' => false, 'msg' => \yii::t('app', 'fail')];
    	}
    }
    /**
     * [updateService 修改服务信息]
     * @param   int $gid [服务ID]
     * @param  [array] $form  [表单内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function upAlbum($id, $form, $thumb = array())
    {
    	$transaction = \yii::$app->db->beginTransaction();
    	try
    	{

    		$model = UserThumb::findOne($id);
    		$model->attributes = $form;
    		$model->save();

    		$thumbError = '';

    		if(isset($thumb['url']) && count($thumb['url']) > 0)
    		{
    			\lib\models\UserThumbList::deleteAll('thumbid='.$id);
    			$result = $this->addThumblist($model->id, $thumb);
    			if(!$result['state']) $thumbError = $result['msg'];
    		}
    		if(empty($model->errors) && empty($thumbError))
    		{
    			$transaction->commit();
    			return ['state' => true, 'msg' => ''];
    		}
    		else
    		{
    			$transaction->rollback();
    			return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors).$thumbError];
    		}
    	}
    	catch (Exception $e)
    	{
    		$transaction->rollback();
    		return ['state' => false, 'msg' => \yii::t('app', 'fail')];
    	}
    }
    /**
     * [addThumb 上传预约缩略图]
     * @param [int] $gid   [商品ID]
     * @param [array] $thumb [缩略图]
     * @return array  [返回值]
     */
    public function addThumb($gid, $thumb)
    {
    	$model = new \lib\models\GoodThumb();
    	$modelError = '';
    	foreach ($thumb['url'] as $key => $value) {
    		$model->id = '';
    		$model->attributes = ['gid' => $gid,'title'=>$thumb['title'][$key], 'image' => $value, 'order' => $key+1];
    		$model->save();
    		$model->isNewRecord = true;
    		if(!empty($model->errors)) $modelError = $model->errors;
    	}

    	if(empty($modelError))
    	{
    		return ['state' => true, 'msg' => ''];
    	}
    	else
    	{
    		return ['state' => false, 'msg' => AdCommon::modelMessage($modelError)];
    	}
    }
    /**
     * [addThumb 上传相册集缩略图]
     * @param [int] $gid   [商品ID]
     * @param [array] $thumb [缩略图]
     * @return array  [返回值]
     */
    public function addThumblist($thumbid, $thumb)
    {
    	$model = new \lib\models\UserThumbList();
    	$modelError = '';
    	foreach ($thumb['url'] as $key => $value) {
    		$model->id = '';
    		$model->attributes = ['thumbid' => $thumbid,'title'=>$thumb['title'][$key], 'image' => $value, 'order' => $key+1];
    		$model->save();
    		$model->isNewRecord = true;
    		if(!empty($model->errors)) $modelError = $model->errors;
    	}

    	if(empty($modelError))
    	{
    		return ['state' => true, 'msg' => ''];
    	}
    	else
    	{
    		return ['state' => false, 'msg' => AdCommon::modelMessage($modelError)];
    	}
    }
    /**
     * 给数据包添加字段
     * @param unknown $name
     * @param unknown $type
     */
	public function  addElement($name,$type){
		if($type==1){
			\yii::$app->db->createCommand("ALTER TABLE ".UserData::tableName()." ADD `$name` INT( 11 ) DEFAULT NULL ")->query();
		}elseif ($type==2) {
			$result = \yii::$app->db->createCommand("ALTER TABLE ".UserData::tableName()." ADD `$name` FLOAT( 5,2 ) DEFAULT '' ")->query();
		}elseif ($type==3){
			$result = \yii::$app->db->createCommand("ALTER TABLE ".UserData::tableName()." ADD `$name` VARCHAR( 32 ) DEFAULT '' ")->query();
		}
	}
    /**
     * [tree description]
     * @param  integer $pid [description]
     * @return [type]       [description]
     */
    public function tree($pid = 0)
    {
        if($pid == 0) return ['lt' => 1, 'rt' => 2, 'mark' => 0, 'rank' => 1];
        $parent = User::findOne($pid);
        $lt = $parent['lt']+1;
        $rt = $parent['lt']+2;
        \yii::$app->db->createCommand("update ".User::tableName()." set lt=lt+2 where lt>".$parent['lt']." and mark=" . $parent['mark'])->query();
        \yii::$app->db->createCommand("update ".User::tableName()." set rt=rt+2 where lt>=".$parent['lt']." and mark=" . $parent['mark'])->query();
        \yii::$app->db->createCommand("update ".User::tableName()." set rt=rt+2 where lt<".$parent['lt']." and rt>".$parent['rt']." and mark=" . $parent['mark'])->query();
        return ['lt' => $lt, 'rt' => $rt, 'mark' => $parent['mark'], 'rank' => $parent['rank']+1];
    }

    /**
     * [updateTree description]
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public function updateTree($uid)
    {
        $user = User::findOne($uid);
        \yii::$app->db->createCommand("update ".User::tableName()." set lt=lt-2 where lt>".$user['lt']." and mark=" . $user['mark'])->query();
        \yii::$app->db->createCommand("update ".User::tableName()." set rt=rt-2 where rt>".$user['lt']." and mark=" . $user['mark'])->query();
    }

    /**
     * [doDraw 处理出款]
     * @param  [type] $id     [description]
     * @param  [type] $state  [description]
     * @param  [type] $remark [description]
     * @return [type]         [description]
     */
    public function doDraw($id, $state, $remark, $admin)
    {
        $query = \lib\models\UserAccountDraw::findOne($id);
        if(empty($query['id']))   return ['state' => false, 'msg' => \yii::t('app', 'noRow')];
        if($query['status'] != 1) return ['state' => false, 'msg' => \yii::t('app', 'backFinish')];
        $transaction = \yii::$app->db->beginTransaction();
        try
        {
            $query->status      = $state;
            $query->update_time = time();
            $query->chuli_user  = $admin;
            $query->remark      = $remark;
            $query->save();

            $error = '';
            if($state == 3)
            {
                $account = \lib\models\UserAccount::findOne(['uid' => $query['uid']]);
                $oldMoney = $account->account;
                $account->account = $account->account+$query['tx_money'];
                $account->save();
                $error = $account->errors;

                $model = new \lib\models\UserMoneyRecord;
                $model->attributes = [
                    'uid'             => $query['uid'],
                    'b_account_money' => $oldMoney,
                    'a_account_money' => $account->account,
                    'action_money'    => $query['tx_money'],
                    'action_type'     => 5,
                    'action'          => \yii::$app->params['moneyType'][5],
                    'time'            => time(),
                ];
                $model->save();
            }

            if(empty($query->errors) && empty($error))
            {
                $transaction->commit();
                return ['state' => true, 'msg' => ''];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => AdCommon::modelMessage($query->errors)];
            }
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }
}