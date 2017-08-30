<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_order".
 *
 * @property integer $iid
 * @property string $order_sn
 * @property integer $user_id
 * @property boolean $status
 * @property integer $member_id
 * @property string $price
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'product', 'type', 'status'], 'integer'],
            ['order_sn', 'string', 'max'=>30],
            [['price'], 'number'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'status' => 'Status',
            'member_id' => 'Member ID',
            'price' => 'Price',
            'create_time' => 'Create Time',
        ];
    }

    //完成支付
    public function payOk()
    {
        if($this->status) {
            $this->addError('iid', '定单已支付完成!');
            return false;
        }

        $t = Yii::$app->getDb()->beginTransaction();
        $this->status = 1;
        if(!$this->save()) {
            $t->rollBack();
            CodeLog::addlog('定单处理','订单状态修改失败');
            return false;
        }

        switch($this->type)
        {
            case 0:
                //修改会员身份
                $userModel = User::findOne($this->user_id);
                $userModel->vip_type = $this->product;
                $userModel->vip_start = date('Y-m-d');
                $userModel->vip_end = date('Y-m-d',strtotime('+1year'));
                if(!$userModel->save()) {
                    $t->rollBack();
                    CodeLog::addlog('定单处理','设置用户为会员失败');
                    return false;
                }

                //推荐人奖励
                if($userModel->inviteCode) {
                    $inviteUser = User::findOne(['llaccounts' => $userModel->inviteCode]);
                    Yii::$app->factory->getwealth('wallet', $inviteUser)->addReward([
                        'number' => Setting::keyTovalue('vip_recommend_reward'),
                        'type' => \Config::WALLET_VIP,
                        'source_user_id' => $userModel->iid,
                        'note' => $userModel->username,
                    ]);
                }
                
                //代理人奖励
                $agents = Agent::getCacheList();
                $use_count = 0;
                $agents_count = count($agents);

                while($topuserModel = $userModel->getTop())
                {
                    if($topuserModel->agent) {
                        $reward_number = 0;
                        $userAgent = Agent::getCacheRow($topuserModel->agent);
                        foreach($agents as $agent) {
                            if($userAgent['label'] >= $agent['label'] && !isset($agent['use'])) {
                                $reward_number += $agent['vip_reward'];
                                $agent['use'] = 1;
                                $use_count++;
                            }
                        }

                        if($reward_number) {
                            Yii::$app->factory->getwealth('wallet', $topuserModel)->addReward([
                                'number' => $reward_number,
                                'type' => \Config::WALLET_AGENT_VIP,
                                'source_user_id' => $userModel->iid,
                                'note' => $userModel->username,
                            ]);
                        }

                        //所有奖都拿完了
                        if($use_count >= $agents_count) {
                            break;
                        }
                    }
                }
                break;
            case 1:
                $userModel = User::findOne($this->user_id);
                Yii::$app->factory->getwealth('wallet', $userModel)->add([
                    'number' => $this->product,
                    'type' => \Config::WALLET_RECHARGE,
                ]);
                break;
        }
        $t->commit();
        return true;
    }
}
