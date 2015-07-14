<?php
namespace johnitvn\userplus\base\actions;

use Yii;
use johnitvn\userplus\base\Action;
use johnitvn\userplus\base\traits\AjaxValidationTrait;

/**
* Logout action will be handler user logout request
* @author John Martin <john.itvn@gmail.com>
* @since 1.0.0
*/
class LogoutAction extends Action{
    
    use AjaxValidationTrait;
  
    /**
     * Runs the logout action.
     * After logout application will redirect to login
     * ````php
     * $this->controller->redirect(ii::$app->getUser()->loginUrl);
     * ````
     * @return string result content
     */
    public function run() {
        $user = Yii::$app->getUser();
        $user->logout();
        return $this->controller->redirect($user->loginUrl);
    }


}