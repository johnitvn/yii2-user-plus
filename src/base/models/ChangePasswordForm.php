<?php
namespace johnitvn\userplus\base\models;

use Yii;
use johnitvn\userplus\base\Model;

/**
 * Change password form get user's old password and new password, validates them
 *  and change the password of current user loged in. 
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ChangePasswordForm extends Model{
    
    /**
     * @var string User email address
     */
    public $old_password;

    /**
     * @var string Password
     */
    public $new_password;

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
            // email rules
            'oldPasswordRequired' => ['old_password', 'required'],

            // password rules
            'newPasswordRequired' => ['new_password', 'required'],
            'newPasswordLength'   => ['new_password', 'string', 'min' => 6],
            
            // confirm password rules
            'confirmPasswordRequired' => ['confirm_password', 'required'],
            'confirmPasswordCompare'   => ['confirm_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>Yii::t("user","Comfirm Passwords don't match")],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password'            => Yii::t('user', 'Old Password'),
            'new_password'         => Yii::t('user', 'New Password'),
            'confirm_password' => Yii::t('user', 'Comfirm New Password'),
        ];
        
       
        
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'change-password-form';
    }

    /**
     * Change pasword of current user loged in. 
     *
     * @return bool Change pasword was success or not
     */
    public function changePassword()
    {
        if (!$this->validate()) {
            return false;
        }
            
        $modelClass = $this->userPlusModule->getModelClassName('UserAccounts');       
        $user = call_user_func($modelClass."::findOne",Yii::$app->user->getId());
        $user->scenario = 'change_password';
        
        $this->loadAttributes($user);
        if (!$user->changePassword()) {            
            $this->addErrors($user->getErrors());
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
