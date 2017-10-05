<?php
namespace app\controllers;

use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\Article;
use lib\models\Selection;
use lib\models\User;
use lib\models\Ucms;
use lib\models\Report;
use app\library\ArticlecatLibrary;

class ArticleController extends SellerController
{
	/**
	 * @desc    文章模型
	 * @var     Article
	 * @access  private
	 */
	private $_article;
	/**
	* @desc
	* @access
	* @param
	* @return
	*/
	public function init()
	{
		parent::init();
		$this->_article  = new Article();
	}


	/**
	 * 文章列表
	 * @return Ambigous <\app\controllers\[type], string, string>
	 */
	public function actionArticlelist(){
		$search = $this->get('search');
		$where  = '1=1';
		//搜索
		if(!empty($search['type']) && !empty($search['keyword']))
		{
			$where .= " and " . $search['type'] ." like '%" . $search['keyword'] . "%'";
		}
		//分类
		if(isset($search['cat_id']) && !empty($search['cat_id'])) $where .= " and er_article.cat_id=" . $search['cat_id'];
		//添加时间搜索
		if(!empty($search['stime']))
		{
			$stime = strtotime($search['stime']);
			$etime = empty($search['etime']) ? time() : strtotime($search['etime']);
			$where .= " and create_time between " . $stime ." and " . $etime;
		}

		$query = $this->query($this->_article ,'cate', $where);

		$this->data['category'] = ArticlecatLibrary::APP()->getCategory();

		$this->data['count'] = $query['count'];
		$this->data['data']  = $query['data'];
		$this->data['page']  = $query['page'];
		$this->data['searchvalue'] = $search;
		$this->data['where'] = $where;

		$this->data['search'] = ['id' => \yii::t('app', '文章ID'),
				'title' => \yii::t('app', '文章标题'),
		];
		return $this->view('list');
	}


	/**
	* @desc    添加文章
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionAddarticle()
	{
		if ($this->isPost()) {
			$post = $this->post('Article');
			$post['cat_id'] = empty($post['cat_id']) ? 0 : $post['cat_id'];
			$post['content'] = AdCommon::dotran($post['content']);
			/*$str = $post['article_img'];
			$res = explode("/",$str);
			array_shift($res);
			array_shift($res);
			array_shift($res);
			$strs = "/".implode("/",$res);
			$post['article_img'] = $strs;*/
			$post['create_time'] = time();
			$this->_article->attributes = $post;
			$this->_article->save();
			if (empty($this->_article->errors)) {
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['articlelist']);
			} else {
				$this->error(AdCommon::modelMessage($this->_article->errors));
			}
		}
		$this->data['model'] = $this->_article;

		$this->data['category'] = ArticlecatLibrary::APP()->getSelectMenu();
		return $this->view();
	}


	/**
	* @desc    修改文章
	* @access  public
	* @param   int $id 文章ID
	* @return  void
	*/
	public function actionEditarticle()
	{
		$id = $this->get('id');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$article = $this->_article->findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('Article');
			$post['content'] = AdCommon::dotran($post['content']);
			/*$str = $post['article_img'];
			$res = explode("/",$str);
			array_shift($res);
			array_shift($res);
			array_shift($res);
			$strs = "/".implode("/",$res);
			$post['article_img'] = $strs;*/
			$article->attributes = $post;
			$article->save();
			if (empty($article->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['articlelist']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($article->errors));
			}
		}
		$content = AdCommon::dedotran($article['content']);
		$article['content'] = AdCommon::dedotran($content);
		$this->data['model'] = $article;
		$path = \lib\models\Setting::find()->select("value")->where(['id' => 7])->one();
		$this->data['path'] = $path->value;
		$this->data['category'] = ArticlecatLibrary::APP()->getSelectMenu();
		return $this->view();
	}


	/**
	 * @desc    删除文章
	 * @access  public
	 * @param   int $id 删除文章ID
	 * @return  void
	 */
	public function actionDelarticle()
	{
		$id = $this->post('data');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$result = $this->_article->findOne($id)->delete();
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
	 * @desc    数据导入
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionDatainput()
	{
		if ($this->isPost())
		{
			$post = $this->post('xls');
			$this->iputExcel($post['xls'],Report::tableName());
//			$this->success(\yii::t('app', 'success'));
			$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['datainput']);

		}
		return $this->view();
	}

    /**
     * @return string
     *
     * 发布操作
     */
    public function actionPusharticle()
    {

          $selection = new Selection();
           if ($this->isPost()){
            $post = \Yii::$app->request->post();

            $selection->article_id = $post['article_id'];
            $selection->sort = $post['Selection']['sort'];
            $selection->block = $post['Selection']['block'];
            $selection->img_link = $post['Selection']['img_link'];
            $selection->create_at = time();
            $selection->update_at = time();
            $selection->save();

            if (empty($selection->errors))
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['articlelist']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($selection->errors));
            }
        }else{
            $id = \Yii::$app->request->get('id');
            if(empty($id)) $this->error(\yii::t('app', 'error'));
            $article = $this->_article->findOne($id);

            $this->data['article'] = $article;
            $this->data['model'] = $selection;

            return $this->view('/selection/push');
        }
	}
}
