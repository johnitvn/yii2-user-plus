<?php

namespace johnitvn\userplus\basic\models;

use Yii;
use johnitvn\userplus\simple\models\RegisterForm as BaseRegisterForm;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class RegisterForm extends BaseRegisterForm {
    
    public $username;

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['login'] = Yii::t('user', 'Email');
        $labels['username'] = Yii::t('user', 'Username');
        return $labels;
    }

    public function rules() {
        $rules = parent::rules();

        $rules['loginPattern'] = ['login', 'email'];
        
        $rules['usernameRequired'] = ['username', 'required'];
        $rules['usernamePattern'] = ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'];
        $rules['usernameLength'] = ['username', 'string', 'min' => 3, 'max' => 255];
        
        return $rules;
    }

}
