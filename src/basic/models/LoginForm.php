<?php
namespace johnitvn\userplus\basic\models;

use Yii;

use johnitvn\userplus\simple\models\LoginForm as BaseLoginForm;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class LoginForm extends BaseLoginForm {
      
    public function rules(){      
        $rules = parent::rules();
        $rules['accountConfirmed'] = [
            'login',
            function ($attribute) {                 
                if ($this->user!==null&&!$this->userPlusModule->enableUnconfirmedLogin&&!$this->user->isConfirmed()) {
                    $this->addError($attribute, Yii::t('user', 'Your account is not confirmed'));
                }                    
            }
        ];
        return $rules; 
    }
    
}
