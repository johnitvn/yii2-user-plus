<?php
namespace johnitvn\userplus\base\models;

use Yii;
use johnitvn\userplus\base\Model;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class RegisterForm extends Model{
    
    /**
     * @var string User email address
     */
    public $login;

    /**
     * @var string Password
     */
    public $password;

    /**
     * @var string Confirm Password
     */
    public $confirm_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {       
        return [          
            'loginTrim'     => ['login', 'filter', 'filter' => 'trim'],
            'loginRequired' => ['login', 'required'],
            'loginUnique'   => [
                'login',
                'unique',
                'targetClass' => $this->userPlusModule->getModelClassName('UserAccounts'),
                'message' => Yii::t('user', 'This account has already been taken')
            ],
            'passwordRequired' => ['password', 'required'],
            'passwordLength'   => ['password', 'string', 'min' => 6],
            'confirmPasswordRequired' => ['confirm_password', 'required'],
            'confirmPasswordCompare'   => ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t("user","Comfirm Passwords don't match")],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login'            => Yii::t('user', 'Login'),
            'password'         => Yii::t('user', 'Password'),
            'confirm_password' => Yii::t('user', 'Comfirm Password'),
        ];
        
       
        
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'register-form';
    }

    /**
     * Registers a new user account.
     *
     * @return bool registration was successful or not
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = $this->userPlusModule->createModelInstance('UserAccounts',['scenario' => 'register']);
              
        $this->loadAttributes($user);

        if (!$user->register()) {            
            return false;
        }

        return true;
    }

    /**
     * Loads attributes to the user model. 
     * @param UserAccounts $user
     */
    protected function loadAttributes($user){
        $user->setAttributes($this->attributes);
    }

}
