<?php
namespace app\controllers;
use Yii;
use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\Setting;
use lib\models\Adstype;
use lib\models\Ads;
use lib\models\App;
use lib\models\AppInstall;
use lib\models\Feedback;
use lib\models\AppAds;
use lib\models\AppAdstype;
use yii\helpers\VarDumper;

class SystemController extends SellerController
{ 
	private $_adstype;
	private $_appadstype;
	/**
	* @desc    
	* @access  
	* @param   
	* @return  
	*/
	public function init()
	{
		parent::init();
		$this->_adstype = new Adstype();
		$this->_appadstype = new AppAdstype();
	}


	/**
	* @desc     系统设置
	* @access  
	* @param     void
	* @return    void
	*/
	public function actionIndex()
	{
		$data = Setting::find()->where(['type'=>1])->orderBy('id ASC')->all();

		$this->data['data'] = $data;
		
		return $this->view();
	}


	/**
	 * @desc     设置
	 * @access
	 * @param     void
	 * @return    void
	 */
	public function actionPayset()
	{
		$data = Setting::find()->where(['type'=>2])->orderBy('id ASC')->all();
	
		$this->data['data'] = $data;
	
		return $this->view();
	}


	/**
	 * @desc     系统设置
	 * @access
	 * @param     void
	 * @return    void
	 */
	public function actionXieyi()
	{
		$data = Setting::findOne(['type'=>5,'key'=>'shouce']);
	
		$this->data['info'] = $data;
	
		return $this->view();
	}


	/**
	* @desc     修改公共配置
	* @access   
	* @param     void
	* @return    void
	*/
	public function actionUpdate()
	{
		if ($this->isPost())
		{
			$post = $this->post('system');
			if (is_array($post))
			{
				foreach ($post as $k => $v)
				{
					$result = Setting::updateAll(['value' => $v], ['key' => $k]);
				}
			}

			$this->success(\yii::t('app', 'success'));	
		}
		else{
			$this->error(\yii::t('app', 'error'));
		}
	}


	/**
	 * @desc    广告类型列表
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAdstype()
	{
		$adstype = new Adstype();
		$query = $this->query($adstype,'ads',1,'listorder DESC');

		$this->data['count'] = $query['count'];
		$this->data['data']  = $query['data'];
		$this->data['page']  = $query['page'];
		return $this->view();
	}


	/**
	 * @desc    添加广告类型
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAddadstype()
	{
		$adstype = new Adstype();
		if ($this->isPost())
		{
			$post = $this->post('Adstype');
			$post['addtime'] = time();
	
			$adstype->attributes = $post;
			$adstype->save();
	
			if (empty($adstype->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['adstype']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($adstype->errors));
			}
		}
	
		$this->data['model'] = $adstype;
		return $this->view();
	}

	public function actionToupads()
	{
		$id = Yii::$app->request->post('data');
		$result = Ads::findOne($id);
		if($result) {
			$result->listorder = time();
			$result->type .='';
			$result->save();
			$this->success(\yii::t('app', 'success'));
		} else {
			$this->error(\yii::t('app', 'fail'));
		}

	}


	/**
	 * @desc   修改广告类型
	 * @access  public
	 * @param   int $id
	 * @return  void
	 */
	public function actionUpadstype()
	{
		$id = $this->get('id');
		$adtype = Adstype::findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('Adstype');
			$adtype->attributes = $post;
			$adtype->save();
	
			if (empty($adtype->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['adstype']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($adtype->errors));
			}
		}
	
		$this->data['model'] = $adtype;
		return $this->view();
	}


	/**
	 * @desc    删除广告类型
	 * @access  public
	 * @param   int $id
	 * @return  void
	 */
	public function actionDeladstype()
	{
		$id = $this->post('data');
		if (empty($id)) $this->error(\yii::t('app', 'error'));
		$info = Adstype::findOne($id);
		$result = $info->delete();
		if ($result)
		{
			\lib\models\Ads::deleteAll(['type' => $info->type]);
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}


	/**
	* @desc    广告列表
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionAds()
	{
		$ads = new Ads();
		 $query = $this->query($ads,'',[],'listorder DESC,id DESC');
		 $adstype = $this->_adstype->adstypelist();
		 $this->data['count'] = $query['count'];
		 $this->data['data']  = $query['data'];
		 $this->data['page']  = $query['page'];
		 $this->data['adstype']  = $adstype;

		 return $this->view();
	}


	/**
	* @desc    添加广告
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionAddads()
	{
		$ads = new Ads();
		if ($this->isPost())
		{
			$post = $this->post('Ads');
			if($post['type'] > 0){
				$post['addtime'] = time();

				$ads->attributes = $post;
				$ads->save();

				if (empty($ads->errors))
				{
					$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['adstype']);
				}
				else
				{
					$this->error(AdCommon::modelMessage($ads->errors));
				}
			}else{
				$this->error(\yii::t('app', '类型必须选择！'));
			}
		} else {
			$type = \Yii::$app->request->get('type');
			$ads->type = $type;
		}
		$adstype = $this->_adstype->adstypelist();
		$this->data['adstype']  = $adstype;
		$this->data['model'] = $ads;
		return $this->view();
	}


	/**
	* @desc   修改广告
	* @access  public
	* @param   int $id 
	* @return  void
	*/
	public function actionUpads()
	{
		$id = $this->get('id');
		$ad = Ads::findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('Ads');
			$ad->attributes = $post;
			$ad->save();
//			echo "<pre>";
//			var_dump($ad->errors);die;
			if (empty($ad->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['adstype']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($ad->errors));
			}
		}
		$adstype = $this->_adstype->adstypelist();
		$this->data['adstype']  = $adstype;
		$this->data['model'] = $ad;
		return $this->view();
	}


	/**
	* @desc    删除广告
	* @access  public
	* @param   int $id
	* @return  void
	*/
	public function actionDelads()
	{
		$id = $this->post('data');
		if (empty($id)) $this->error(\yii::t('app', 'error'));
		$result = Ads::findOne($id)->delete();
		if ($result)
		{
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}


	/**
	 * [actionApp app列表]
	 * @return [type] [description]
	 */
	public function actionApp()
	{
		$app = new App();
		$query = $this->query($app);
		$this->data['count'] = $query['count'];
		$this->data['page']  = $query['page'];
		$this->data['data']  = $query['data'];
		return $this->view();
	}


	/**
	 * [actionApp 添加App]
	 * @return [type] [description]
	 */
	public function actionAddapp()
	{
		$app = new App();
		if ($this->isPost())
		{
			$post = $this->post('App');
			$post['addtime'] = time();
			
			$app->attributes = $post;
			$app->save();
			
			if (empty($app->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['app']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($app->errors));
			}
		}
		
		$this->data['model'] = $app;
		return $this->view();
	}


	/**
	 * [actionApp 修改App]
	 * @return [type] [description]
	 */
	public function actionUpapp()
	{
		$id = $this->get('id');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$app = App::findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('App');
			$app->attributes = $post;
			$app->save();
			
			if (empty($app->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['app']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($app->errors));
			}
		}
		
		$this->data['model'] = $app;
		return $this->view();
	}


	/**
	 * [actionApp 删除App]
	 * @return [type] [description]
	 */
	public function actionDelapp()
	{
		$id = $this->post('data');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$result = App::findOne($id)->delete();
		if ($result)
		{
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}


	/**
	 * [actionAppinstall 安装版本]
	 * @return [type] [description]
	 */
	public function actionAppinstall()
	{
		$app = new AppInstall();
		$query = $this->query($app);
		$this->data['count'] = $query['count'];
		$this->data['page']  = $query['page'];
		$this->data['data']  = $query['data'];
		return $this->view();
	}


	/**
	 * [actionFeedback反馈意见列表]
	 * @return [type] [description]
	 */
	public function actionFeedback()
	{
		$Feedback = new Feedback();
	
		$where  = '1=1';
		$query = $this->query($Feedback, '', $where);
		$this->data['count'] = $query['count'];
		$this->data['page']  = $query['page'];
		$this->data['data']  = $query['data'];
	
		 
		return $this->view();
	}


	/**
	 * @desc    广告类型列表
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAppadstype()
	{
		$adstype = new AppAdstype();
		$query = $this->query($adstype);
		$this->data['count'] = $query['count'];
		$this->data['data']  = $query['data'];
		$this->data['page']  = $query['page'];
		return $this->view();
	}


	/**
	 * @desc    添加广告类型
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAppaddadstype()
	{
		$adstype = new AppAdstype();
		if ($this->isPost())
		{
			$post = $this->post('AppAdstype');
			$post['addtime'] = time();

			$adstype->attributes = $post;
			$adstype->save();

			if (empty($adstype->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['appadstype']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($adstype->errors));
			}
		}

		$this->data['model'] = $adstype;
		return $this->view();
	}


	/**
	 * @desc   修改广告类型
	 * @access  public
	 * @param   int $id
	 * @return  void
	 */
	public function actionAppupadstype()
	{
		$id = $this->get('id');
		$adtype = AppAdstype::findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('AppAdstype');
			$adtype->attributes = $post;
			$adtype->save();

			if (empty($adtype->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['appadstype']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($adtype->errors));
			}
		}

		$this->data['model'] = $adtype;
		return $this->view();
	}


	/**
	 * @desc    删除广告类型
	 * @access  public
	 * @param   int $id
	 * @return  void
	 */
	public function actionAppdeladstype()
	{
		$id = $this->post('data');

		if (empty($id)) $this->error(\yii::t('app', 'error'));
		$info = AppAdstype::findOne($id);
		$result = $info->delete();
		if ($result)
		{
			\lib\models\AppAds::deleteAll(['type' => $info->type]);
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}


	/**
	 * @desc    广告列表
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAppads()
	{
		$ads = new AppAds();
		$query = $this->query($ads);
		$adstype = $this->_appadstype->adstypelist();
//		var_dump($adstype);die;
		$this->data['count'] = $query['count'];
		$this->data['data']  = $query['data'];
		$this->data['page']  = $query['page'];
		$this->data['adstype']  = $adstype;

		return $this->view();
	}


	/**
	 * @desc    添加广告
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAppaddads()
	{
		$ads = new AppAds();
		if ($this->isPost())
		{
			$post = $this->post('AppAds');
			$post['addtime'] = time();

			$ads->attributes = $post;
			$ads->save();

			if (empty($ads->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['appads']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($ads->errors));
			}
		}
		$adstype = $this->_appadstype->adstypelist();
		$this->data['adstype']  = $adstype;
		$this->data['model'] = $ads;
		return $this->view();
	}


	/**
	 * @desc   修改广告
	 * @access  public
	 * @param   int $id
	 * @return  void
	 */
	public function actionAppupads()
	{
		$id = $this->get('id');
		$ad = AppAds::findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('AppAds');
			$ad->attributes = $post;
			$ad->save();
			if (empty($ad->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['appads']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($ad->errors));
			}
		}
		$adstype = $this->_appadstype->adstypelist();
		$this->data['adstype']  = $adstype;
		$this->data['model'] = $ad;
		return $this->view();
	}


	/**
	 * @desc    删除广告
	 * @access  public
	 * @param   int $id
	 * @return  void
	 */
	public function actionAppdelads()
	{
		$id = $this->post('data');
		if (empty($id)) $this->error(\yii::t('app', 'error'));
		$result = AppAds::findOne($id)->delete();
		if ($result)
		{
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}

	public function actionUpdatecache()
	{
		/*$urls = [
			"http://api.ciyuanjie.cc/order/setweek?classify=1",
			"http://api.ciyuanjie.cc/order/setweek?classify=2",
			"http://api.ciyuanjie.cc/order/setnewpeople?classify=1",
			"http://api.ciyuanjie.cc/order/setnewpeople?classify=2",
			"http://api.ciyuanjie.cc/order/sethot?classify=1",
			"http://api.ciyuanjie.cc/order/sethot?classify=2",
			"http://api.ciyuanjie.cc/order/sethot?classify=3",
			"http://api.ciyuanjie.cc/order/sethot?classify=4",
			"http://api.ciyuanjie.cc/order/setday?classify=1&type=1",
			"http://api.ciyuanjie.cc/order/setday?classify=1&type=2",
			"http://api.ciyuanjie.cc/order/setday?classify=2&type=3",
			"http://api.ciyuanjie.cc/order/setday?classify=2&type=4",
		];*/
		$urls = [
			"http://api.er.cc/order/setweek?classify=1",
			"http://api.er.cc/order/setweek?classify=2",
			"http://api.er.cc/order/setnewpeople?classify=1",
			"http://api.er.cc/order/setnewpeople?classify=2",
			"http://api.er.cc/order/sethot?classify=1",
			"http://api.er.cc/order/sethot?classify=2",
			"http://api.er.cc/order/sethot?classify=3",
			"http://api.er.cc/order/sethot?classify=4",
			"http://api.er.cc/order/setday?classify=1&type=1",
			"http://api.er.cc/order/setday?classify=1&type=2",
			"http://api.er.cc/order/setday?classify=2&type=3",
			"http://api.er.cc/order/setday?classify=2&type=4",
		];
		
		$curl = new \lib\nodes\Curl();
		foreach ($urls as $url) {
			$curl->get($url);
		}
		echo 'ok';
	}

	//点赞数
	public function actionModifypraisenumber()
	{
		$result = \lib\models\Product::find()->all();
		foreach( $result as $row ) {
			$row->praise_number = \lib\models\ProductPraise::find()->where(['target_id'=>$row->product_id])->count();
			$row->save();
		}
	}
}