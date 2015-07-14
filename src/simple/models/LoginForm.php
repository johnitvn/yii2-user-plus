<?php
namespace johnitvn\userplus\simple\models;

use Yii;
use johnitvn\userplus\base\models\LoginForm as BaseLoginForm;

/**
 * LoginForm get user's login and password, validates them and logs the user in. 
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class LoginForm extends BaseLoginForm {
    
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
