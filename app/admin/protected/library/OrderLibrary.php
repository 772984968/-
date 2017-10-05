<?php
namespace app\library;
use lib\components\AdCommon;
use lib\models\Order;
use lib\models\OrderGoods;
//use lib\models\OrderBack;
//use lib\models\OrderStatus;
use lib\models\OrderGoodsSend;

class OrderLibrary
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
     * [getOrderGoods 查询订单商品]
     * @param  array  $order [description]
     * @return [type]        [description]
     */
    public function getOrderGoods($where)
    {
        $data = array();
        $query = OrderGoods::find()->where($where)->all();
        if(!empty($query))
        {
            foreach ($query as $key => &$value) {
                $data[$value['order_id']][] = $value;
            }
        }
        return $data;
    }

    /**
     * [updateState 更新状态记录]
     * @param  [int] $orderid [订单ID]
     * @param  [int] $state   [更新的订单状态]
     * @param  string $remark  [备注]
     * @return [type]          [description]
     */
    public function updateState($orderid, $state, $remark = '')
    {
        $insert = [
            'order_id'    => $orderid,
            'status'      => $state,
            'status_time' => time(),
            'remark'      => $remark,
        ];
        $model = new OrderStatus();
        $model->attributes = $insert;
        $model->save();
    }

    /**
     * [goodSend 订单发货]
     * @param  [array] $form [表单信息]
     * @return [type]       [description]
     */
    public function goodSend($form)
    {
        $order = Order::findOne($form['order_id']);
        if($order->order_status == 5)
        {
            return ['state' => false, 'msg' => \yii::t('app', 'sendError')];
        }
        $transaction = \yii::$app->db->beginTransaction();
        try 
        {
            #物流信息表
            $goodQuery = \yii::$app->db->createCommand("SELECT GROUP_CONCAT(id)AS id FROM kk_order_goods WHERE order_id=".$order['id'])->queryOne();
            $sendNUm   = \yii::$app->db->createCommand("SELECT SUM(num) AS num FROM kk_order_goods WHERE order_id=".$order['id'])->queryOne();
            $form['uid']            = $order['uid'];
            $form['order_good_id'] = isset($goodQuery['id'])? $goodQuery['id']: 0;
            $form['send_num']       = isset($sendNUm['num']) ? $sendNUm['num'] : 0;
            $model = new OrderGoodsSend();
            $model->attributes = $form;
            $model->save();
            #订单表
            $order->order_status = 5;
            $order->save();

//            $this->updateState($form['order_id'], 5, \yii::t('app', 'send'));

            if(empty($model->errors) && empty($order->errors))
            {
                $transaction->commit();
                return ['state' => true, 'msg' => ''];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors).AdCommon::modelMessage($order->errors).AdCommon::modelMessage($goods->errors)];
            }
        } 
        catch (Exception $e) 
        {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }

    /**
     * [closeOrder 关闭订单]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function closeOrder($id)
    {
        $order = Order::findOne($id);
        $order->order_status = 3;
        $order->save();
       // $this->updateState($id, 8, \yii::t('app', 'closeOrder'));
        if(empty($order->errors))
        {
            return ['state' => true, 'msg' => ''];
        }
        else
        {
            return ['state' => false, 'msg' => AdCommon::modelMessage($order->errors)];
        }
    }

    /**
     * [sending 配货中]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function sending($id)
    {
        $order = Order::findOne($id);
        $order->order_status = 4;
        $order->save();
        $this->updateState($id, 4, \yii::t('app', 'sending'));
        if(empty($order->errors))
        {
            return ['state' => true, 'msg' => ''];
        }
        else
        {
            return ['state' => false, 'msg' => AdCommon::modelMessage($order->errors)];
        }
    }

    /**
     * [getBackGoods 查询某订单中退货的商品]
     * @param  [type] $orderid [description]
     * @return [type]          [description]
     */
    public function getBackGoods($orderid)
    {
        $data = [];
        $query = OrderBack::find()->where('order_id='.$orderid)->all();
        if(!empty($query))
        {
            foreach ($query as $key => $value) {
                $data[$value['order_good_id']] = $value;
            }
        }
        return $data;
    }
	

    /**
     * [doBack 退货操作]
     * @param  [int] $id [退货记录ID]
     * @param  [int] $state [状态]
     * @param  [int] $backNum [退货数量]
     * @return [array]          [返回值]
     */
    public function doBack($id, $state)
    {
        $back = OrderBack::findOne($id);
        $order = Order::findOne($back['order_id']);
        $transaction = \yii::$app->db->beginTransaction();
        try 
        {
            $back->status    = $state;
            $back->back_time = time();
            $accountError = '';
            if($state == 7)
            {
                $sendNUm   = \yii::$app->db->createCommand("SELECT SUM(num) AS num FROM db_order_goods WHERE order_id=".$order['id'])->queryOne();
            	$back->back_num = isset($sendNUm['num']) ? $sendNUm['num'] : 0;
                $money    = $order['pay_money'];
                #账户资金
                $account  = \lib\models\UserAccount::findOne(['uid' => $order['uid']]);
                $oldMoney = $account['account_fill'];
                $account->account_fill = $account['account_fill']+$money;
                $account->save();
                $accountError = $account->errors;
                #资金记录
                $model = new \lib\models\UserFillRecode;
                $model->attributes = [
                    'uid'             => $order['uid'],
                    'b_account_money' => $oldMoney,
                    'a_account_money' => $account->account_fill,
                    'action_money'    => $money,
                    'action_type'     => 3,
                    'action'          => \yii::$app->params['moneyType'][6],
                    'time'            => time(),
                ];
                $model->save();

                $this->updateGoodNum($back['order_good_id']);
            }
            
            $back->save();

            if(empty($back->errors))
            {
                if($state == 4 || $state == 5) 
                {
                    Order::updateAll(['order_status' => 5], 'id='.$back['order_id']);
                }
                else if($state == 7)
                {
                    Order::updateAll(['order_status' => 10], 'id='.$back['order_id']);
                }     
            }
            
            if(empty($back->errors) && empty($accountError))
            {
                $transaction->commit();
                return ['state' => true, 'msg' => ''];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => \yii::t('app', 'fail')];
            }
        } 
        catch (Exception $e) 
        {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }

    /**
     * 更改商品库存
     * @param $order_id
     * @return bool
     */
    private function updateGoodNum($order_id)
    {
        $order_good_id = explode(",", $order_id);
        if (empty($order_good_id) || count($order_good_id) <= 0)
        {
            return false;
        }
        foreach ($order_good_id as $orderGoodID)
        {
            $orderGood = \lib\models\OrderGoods::findOne(['id' => $orderGoodID]);
            if (empty($orderGood))
            {
                continue;
            }
            $goodsData = \lib\models\Goods::findOne(['id' => $orderGood->good_id, 'is_put' => 1]);
            if (!empty($goodsData))
            {
                $update_num = $goodsData->num + $orderGood->num;
                \lib\models\Goods::updateAll(['num' => $update_num], ['id' => $goodsData->id]);
            }
        }
        return true;
    }
}