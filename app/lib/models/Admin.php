<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property string $id
 * @property integer $group_id
 * @property string $codes
 * @property string $nickname
 * @property string $account
 * @property string $email
 * @property string $phone
 * @property string $pass
 * @property string $uptime
 * @property integer $state
 * @property string $login_key
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'account', 'pass'], 'required'],
            [['group_id', 'uptime', 'state','is_admin'], 'integer'],
            [['codes', 'login_key'], 'string', 'max' => 32],
            [['nickname'], 'string', 'max' => 4],
            [['account'], 'string', 'max' => 36],
            [['email'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 11],
            [['pass'], 'string', 'max' => 33],
            [['account'], 'unique'],
            [['codes'], 'unique'],
            ['phone', 'checkPhone',     'on'=>'default'],
            ['account', 'checkAccount', 'on'=>'default'],
            ['email', 'checkName',      'on'=>'default'],
            ['nickname', 'checkName',   'on'=>'default'],
            ['email', 'checkEmail', 'on' => 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => '角色组',
            'codes' => 'Codes',
            'nickname' => '昵称',
            'account' => '用户名',
            'email' => '邮箱',
            'phone' => '手机号',
            'pass' => '密码',
            'uptime' => 'Uptime',
            'state' => '状态',
            'login_key' => 'Login Key',
            'is_admin' => '是否是管理员'
        ];
    }

    /**
     * [getGroup join db_admin_group]
     * @return [type] [description]
     */
    public function getGroup()
    {
        return $this->hasOne(AdminGroup::className(), ['id' => 'group_id']);
    }

    /**
     * [checkEmail 检查邮箱]
     * @return [type] [description]
     */
    public function checkEmail()
    {
        if(!empty($this->email) && !\lib\components\AdCommon::isEmail($this->email))
        {
            $this->addError('email', \yii::t('app', 'emailError'));
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
    * @desc 验证用户名
    * @access  public
    * @param   void
    * @return  void
    */
    public function checkAccount()
    {
        if (!\lib\components\AdCommon::isAlpha_numeric($this->account))
        {
            $this->addError('account','用户名格式有误！');
            return false;
        }

        if ($this->id)
        {
            $team = $this->find()->where("account='".$this->account."' and id!=".$this->id)->one();
        }
        else 
        {
            $team = $this->findOne(['account' => $this->account]);
        }
        
        if ($team['id'])
        {
            $this->addError('account','用户名已存在！');
            return false;
        }
        
        return true;
    }
    
    /**
    * @desc 验证姓名
    * @access  public
    * @param   void
    * @return  boolen
    */
    public function checkName()
    {
        if(!\lib\components\AdCommon::isChinese($this->nickname) && !\lib\components\AdCommon::isEnglish($this->nickname))
        {
            $this->addError('nickname','姓名格式有误！');
            return false;
        }
        
        return true;
    }
    
    /**
    * @desc 验证手机号格式
    * @access  public
    * @param   void
    * @return  boolen
    */
    public function checkPhone()
    {
        if(!\lib\components\AdCommon::isMobile($this->phone))
        {
            $this->addError('phone', '手机号格式错误！');
            return false;
        }
         if ($this->id)
        {
            $team = $this->find()->where("phone='".$this->phone."' and id!=" . $this->id)->one();
        }
        else 
        {
            $team = $this->findOne(array('phone' => $this->phone));
        }
        
        if ($team['id'])
        {
            $this->addError('phone','手机号已存在！');
            return false;
        }
        
        return true;
    }

    /**
     * [checkPassword 查询密码是否符合格式]
     * @param  [string] $password [密码]
     * @return [bool]            
     */
    public static function checkPassword($password)
    {
        if((empty($password)) && (strlen($password) < 6 || strlen($password) > 12))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * [encryPassword 密码加密]
     * @param  [string] $code [code码]
     * @param  [string] $pass [密码]
     * @return [string]       [加密结果]
     */
    public static function encryPassword($code, $pass)
    {
        return md5($code.$pass);
    }
}
