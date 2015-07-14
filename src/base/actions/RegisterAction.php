<?php
namespace johnitvn\userplus\base\actions;

use Yii;
use johnitvn\userplus\base\Action;
use johnitvn\userplus\base\traits\AjaxValidationTrait;

/**
* Register action will be handler user register
* @author John Martin <john.itvn@gmail.com>
* @since 1.0.0
*/
class RegisterAction extends Action{
    
    use AjaxValidationTrait;
    
    /**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     * That means, if you name the action as "error" in "SiteController", then the view name
     * would be "error", and the corresponding view file would be "views/site/error.php".
     */
    public $view;

    /**
     * Runs the register action
     * After register application will redirect to login url
     * ````php
     * $this->controller->redirect($user->loginUrl)
     * ````
     * @return string result content
     */
    public function run() {
        $model = $this->userPlusModule->createModelInstance('RegisterForm'); 
                
        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->request->post()) && $model->register()) {            
            $user = Yii::$app->getUser();           
            return $this->controller->redirect($user->loginUrl);
        } else {
            $view = $this->view == null ? $this->id : $this->view;
            return $this->controller->render($view, [
                        'model' => $model,
            ]);
        }
    }


}