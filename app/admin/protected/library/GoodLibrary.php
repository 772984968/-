<?php
namespace app\library;
use lib\components\AdCommon;
use lib\models\Goods;
use lib\models\GoodAtt;
use lib\models\GoodsRelated;

class GoodLibrary
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

    public function addAtt($gid, $att)
    {
        $goodAttError = '';
        $goodAtt = new GoodAtt();
        foreach ($att['name'] as $key => $value) {
            if(!empty($value))
            {
                $goodAtt->isNewRecord = true;
                $goodAtt->id = '';
                $goodAtt->attributes = [
                    'good_id' => $gid,
                    'att_name' => $value,
                    'att_value' => $att['value'][$key],
                    'att_price' => $att['price'][$key] == '' ? 0.00 : $att['price'][$key],
                    'att_num'   => $att['num'][$key] == '' ? 0 : $att['num'][$key],
                    'att_image' => '',
                    'att_type'  => $att['type'][$key] == '' ? 0 : $att['type'][$key],
                ];
                $goodAtt->save();
                $goodAttError = !empty($goodAtt->errors) ? $goodAtt->errors : '';
            }
        }

        if(empty($goodAttError))
        {
            return ['state' => true, 'msg' => ''];
        }
        else
        {
            return ['state' => false, 'msg' => ''];
        }
    }

    /**
     * [addThumb 上传缩略图]
     * @param [int] $gid   [商品ID]
     * @param [array] $thumb [缩略图]
     * @return array  [返回值]
     */
    public function addThumb($gid, $thumb)
    {
        $model = new \lib\models\GoodsThumb;
        $modelError = '';
        foreach ($thumb['url'] as $key => $value) {
            $model->id = '';
            $model->attributes = ['good_id' => $gid, 'image' => $value, 'order' => $key+1];
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
     * [addGood 添加商品]
     * @param [type] $form [description]
     * @param array  $att  [description]
     */
    public function addGood($form, $att = array(), $thumb = array())
    {
        $transaction = \yii::$app->db->beginTransaction();
        try 
        {
            $good = new Goods();
            $good->attributes = $form;
            $good->save();

            $goodAttError = '';
            if(count($att['name']) > 0 )
            {   
                $result = $this->addAtt($good->id, $att);
                if(!$result['state']) $goodAttError = $result['msg'];
            }

            $thumbError = '';
            if(isset($thumb['url']) && count($thumb['url']) > 0)
            {
                $result = $this->addThumb($good->id, $thumb);
                if(!$result['state']) $thumbError = $result['msg'];
            }

            if(empty($good->errors) && empty($goodAttError) && empty($thumbError))
            {
                $transaction->commit();
                return ['state' => true, 'msg' => ''];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => AdCommon::modelMessage($good->errors).$goodAttError];
            }
        } 
        catch (Exception $e) 
        {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }

    /**
     * [updateGood 修改商品信息]
     * @param   int $gid [商品ID]
     * @param  [array] $form  [表单内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function updateGood($gid, $form, $thumb = array())
    {
        $transaction = \yii::$app->db->beginTransaction();
        try 
        {
            $model = Goods::findOne($gid);
            $model->attributes = $form;
            $model->save();

            $thumbError = '';
            if(isset($thumb['url']) && count($thumb['url']) > 0)
            {
                \lib\models\GoodsThumb::deleteAll('good_id='.$gid);
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
     * [addRelate 关联商品]
     * @param [int] $gid [商品ID]
     * @param [int] $id  [被关联商品ID]
     * @return ['state' => boolen, 'msg' => '']
     */
    public function addRelated($gid, $id)
    {
        $model = new GoodsRelated();
        if(is_array($id))
        {
            foreach ($id as $key => $value) 
            {
                $model->isNewRecord = true;
                $model->attributes = ['good_id' => $gid, 'related_good_id' => $value];
                $model->save();
                $model->id = '';
            }
        }
        else
        {
            $model->attributes = ['good_id' => $gid, 'related_good_id' => $id];
            $model->save();
        }

        if(empty($model->errors))
        {
            return ['state' => true, 'msg' => ''];
        }
        else
        {
            return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors)];
        }
    }

    /**
     * [delRelated 取消关联]
     * @param [int] $gid [商品ID]
     * @param [int] $id  [被关联商品ID]
     * @return ['state' => boolen, 'msg' => '']
     */
    public function delRelated($gid, $id)
    {
        if(is_array($id))
        {
            foreach ($id as $key => $value) {
                $query = GoodsRelated::findOne(['good_id' => $gid, 'related_good_id' => $value]);
                if(isset($query['id']))$query = $query->delete();
            }
        }
        else
        {
            $query = GoodsRelated::findOne(['good_id' => $gid, 'related_good_id' => $id]);
            if(isset($query['id']))$query = $query->delete();
        }

        if($query)
        {
            return ['state' => true, 'msg' =>''];
        }
        else
        {
            return ['state' => false, 'msg' => ''];
        }
    }

    /**
     * [GoodAtt 查询某商品属性]
     * @param [type] $gid [description]
     * @return  array [返回值]
     */
    public function GoodAtt($gid)
    {
        $att = [];
        $attData = GoodAtt::find()->where(['good_id' => $gid])->all();
        if (!empty($attData))
        {
            foreach ($attData as $k => $v)
            {
                if ($v['att_type'] == 1)
                {
                    $att[$v['att_name']][] = $v['att_value'];
                    //array_unshift($att[$v['att_name']], $v['att_value']);
                }
                else
                {
                    $att[$v['att_name']] = $v['att_value'];
                }
            }
        }
        return $att;
    }

    /**
     * [goodsThumb 查询商品的缩略图]
     * @param  [int] $gid [商品ID]
     * @return [array]  返回值
     */
    public function goodsThumb($gid)
    {
        $data = [];
        $query = \lib\models\GoodsThumb::find()->where(['good_id' => $gid])->all();
        if(!empty($query))
        {
            foreach ($query as $key => $value) {
                $data[$value['id']] = $value['image'];
            }
        }
        return $data;
    }
}