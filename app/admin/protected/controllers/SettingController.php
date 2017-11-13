<?php
namespace app\controllers;

use app\controllers\SellerController;
use lib\models\Setting;
use lib\models\Signsetting;
use lib\components\AdCommon;
use lib\nodes\Notice;


class SettingController extends SellerController
{
	/**
	* @desc     读取setting表中的数据，并显示视图
	* @access
	* @param     void
	* @return    void
	*/
	public function actionIndex($type = 1)
	{

		$data = Setting::getAll($type);
		$this->data['data'] = $data;

		switch($type)
		{	//系统设置
			case '1':
			 	$other= [
							'title' => '网站设置',
							'formname' => '设置参数',
							];
				break;
			case '2':
				$other= [
							'title' => '前端设置',
							'formname' => '设置参数',
							];
				break;
				//积分设置
		default:
				$other= [
							'title' => '',
							'formname' => '',
							];
		}

		$this->data['other'] = empty($other) ? ['title' => '','formname' => ''] : $other;
		return $this->view();

	}
	/**
	* @desc     修改
	* @access
	* @param     void
	* @return    void
	*/
	public function actionUpdate()
	{
		if ($this->isPost())
		{
			$post = $this->post('Setting');


			if (is_array($post))
			{
				$time = time();
				foreach ($post as $k => $v)
				{
					$result = Setting::updateAll(['value' => $v,'dt'=>$time], ['key' => $k]);
				}
			}

			$this->success(\yii::t('app', 'success'));
		}
		else{
			$this->error(\yii::t('app', 'error'));
		}
	}

	/**
	 *签到积分设置
	 */
    public function actionSignsetting(){
        $signtting=new Signsetting();
        $this->data['signsetting']= $data=$signtting::find()->orderBy('continue_day asc,credits asc')->all();
        return $this->view();
    }
    /**
     *设置系统群发消息
     */
    public function actionMessage(){
        $rows = (new \yii\db\Query())
        ->from('at_lianlian_message')
        ->all();
        $this->data['data']=$rows;
        return $this->view();
    }
    /**
     *设置系统群发消息
     */
    public function actionAddmessage(){
        if (\Yii::$app->request->isPost){
            $model=new \lib\models\LianlianMessage();
            $data=\Yii::$app->request->post();
            $model->load(\Yii::$app->request->post(),'');
            if($model->insert()){
             $this->success('添加成功');
            }
            $this->error(AdCommon::modelMessage($model->errors));
        }

         return $this->view();
    }

    //删除消息
    public function actionDelmessage(){
        //删除系统消息
        if (\Yii::$app->request->isGet){
            $model=new \lib\models\LianlianMessage();
            $iid=\Yii::$app->request->get('iid');
            if ($model->deleteAll(['iid'=>$iid])){
                 $this->success('删除成功');
            }else{
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }
    }
        //发送系统消息
    public function actionSendmessage(){

        $model=new \lib\models\LianlianMessage();
        $iid=\Yii::$app->request->get('iid');
        $data=$model->findOne(['iid'=>$iid])->toArray();
        $allUser=\lib\models\User::find()->all();
        foreach ($allUser  as $user){
            if (Notice::sendmessage($user->wy_accid, $user,$data)==false)
                continue;
        }
            $this->success('发送成功');
    }
    /**
     *签到积分添加
     */
    public function actionSignadd(){
        if (\Yii::$app->request->isPost){
            $signtting=new Signsetting();
            $data=\Yii::$app->request->post();
            $signtting->sign_day=$data['day'];
            $signtting->credits=$data['credits'];
            if (isset($data['continue_day']))$signtting->continue_day=1;
            if ($signtting->save()){
                return $this->success('添加成功！','signsetting');
            }else{
                    return $this->error('添加失败');
                } ;
        }
        return $this->view();
    }
    /**
     *签到积分更新
     */
    public function actionSignupdate(){
        //删除
        if (\Yii::$app->request->isGet){
            $signtting=new Signsetting();
           $iid=\Yii::$app->request->get('iid');

            if ($signtting->deleteAll(['iid'=>$iid])){
               return json_encode(['code'=>'删除成功!']);

            }else{
                return json_encode(['code'=>'删除失败 !']);
            }

        }
        //更新

        if (\Yii::$app->request->isPost){
            $data=\Yii::$app->request->post();
            $signtting=new Signsetting();
            $rs=$signtting::find()->where(['iid'=>$data['iid']])->one();
            $rs->sign_day=$data['day'];
            $rs->credits=$data['credits'];
            if ($rs->save()){
                return json_encode(['code'=>'更新成功!']);
            }else{
                return json_encode(['code'=>'更新失败!']);
            }

      }


    }


}

?>

