<?php
namespace johnitvn\userplus\simple\models;

use Yii;
use johnitvn\userplus\base\models\UserAccounts as BaseUserAccounts;

/**
 * User Accounts is model class of table 'user_accounts'
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 * 
 * @property integer $id
 * @property string $login
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $administrator
 * @property integer $creator
 * @property string $creator_ip
 * @property string $confirm_token
 * @property string $recovery_token
 * @property integer $blocked_at
 * @property integer $confirmed_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserAccounts extends BaseUserAccounts{
    
   
    /**
     * @inheritdoc
     */
    public function rules(){       
        $rules = parent::rules();
        
        if($this->userPlusModule->loginType=="username"){
            $rules['loginPattern'] =  ['login', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'];
            $rules['loginLength'] =  ['login', 'string', 'min' => 3, 'max' => 255];
        }else{
            $rules['loginPattern'] = ['login','email'];
        }
        
        return $rules; 
    }
  
   /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        if($this->userPlusModule->loginType=="username"){
            $labels['login'] =  Yii::t('user', 'Username');
        }else{
            $labels['login'] =  Yii::t('user', 'Email');
        }
        return $labels;
    }
    
}
