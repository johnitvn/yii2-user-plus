<?php
namespace johnitvn\userplus\simple\models;

use Yii;
use johnitvn\userplus\base\models\RegisterForm as BaseRegisterForm;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class RegisterForm extends BaseRegisterForm {
    
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
    
}
