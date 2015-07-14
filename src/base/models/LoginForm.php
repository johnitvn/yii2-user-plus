<?php
namespace johnitvn\userplus\base\models;

use Yii;
use johnitvn\userplus\base\Model;

/**
 * LoginForm get user's login and password, validates them and logs the user in. 
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class LoginForm extends Model{
    
    /** @var string The login field*/
    public $login;

    /** @var string User's plain password */
    public $password;

    /** @var string Whether to remember the user */
    public $rememberMe = false;

    /** @var johnitvn\userplus\base\models\UserAccounts The instance of johnitvn\userplus\base\models\UserAccounts*/
    protected $user;

       
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login'            => Yii::t('user', 'Login'),
            'password'         => Yii::t('user', 'Password'),
            'rememberMe'       => Yii::t('user', 'Remember me next time'),
        ];
    }

     /** @inheritdoc */
    public function formName()
    {
        return 'login-form';
    }


    /** @inheritdoc */
    public function beforeValidate()
    {   
        if (parent::beforeValidate()) {            
            $userClassName = $this->userPlusModule->getModelClassName('UserAccounts');
            $this->user = call_user_func($userClassName.'::findIdentityByLogin',$this->login);
            return true;
        } else {
            return false;
        }
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            'requiredFields' => [['login', 'password'], 'required'],
            'loginTrim' => ['login', 'trim'],
            'loginInfoValidate' => [
                'password',
                function ($attribute) {
                    if ($this->user === null || !$this->user->validatePassword($this->password) ) {
                        $this->addError($attribute, Yii::t('user', 'Invalid login or password'));
                    }          
                }
            ],           
            'accountAvaiable' => [
                'password',
                function ($attribute) {                   
                    if ($this->user->isBlocked()) {
                        $this->addError($attribute, Yii::t('user', 'Your account has been blocked'));
                    }                    
                }
            ],            
            'rememberMe' => ['rememberMe', 'boolean'],          
        ];
    }
    
    /**
     * Validates form and logs the user in.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->getUser()->login($this->user,$this->rememberMe?$this->userPlusModule->rememberFor:0);
        } else {
            return false;
        }
    }
}
