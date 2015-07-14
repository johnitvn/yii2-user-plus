<?php
namespace johnitvn\userplus\basic\models;

use Yii;
use johnitvn\userplus\base\Model;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class RecoveryForm extends Model {
    
    /** @var string User's plain password */
    public $login;


    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login' => Yii::t('user', 'Email'),
        ];
    }

     /** @inheritdoc */
    public function formName()
    {
        return 'recovery-form';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            'requiredFields' => [['login'], 'required'],
            'loginTrim' => ['login', 'trim'], 
            'loginPattern' => ['login', 'email'],
        ];
    }

    public function recovery(){
        if(!$this->validate()){
            return false;
        }else{
            $modelClass = $this->userPlusModule->getModelClassName('UserAccounts');      
            $user = call_user_func($modelClass.'::findIdentityByEmail',$this->login);
            if($user!==null){
                $user->scenario = 'recovery';
                return $user->recovery();
            }else{
                $this->addError('login',Yii::t("user","We didn't found any account corresponds with this email"));
            }
        }
    }

    
}
