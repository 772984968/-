<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_user_wallet_log".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $type
 * @property string $number
 * @property integer $source_user_id
 * @property string $note
 */
class UserWalletLog extends UserDiamondLog
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_wallet_log';
    }

}
