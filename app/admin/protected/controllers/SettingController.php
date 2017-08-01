<?php
namespace app\controllers;

use app\controllers\SellerController;
use lib\models\Setting;


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
}

?>

