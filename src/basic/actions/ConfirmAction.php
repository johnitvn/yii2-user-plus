<?php

namespace johnitvn\userplus\basic\actions;

use Yii;
use johnitvn\userplus\base\Action;
use johnitvn\userplus\base\traits\AjaxValidationTrait;

/**
 * Confirm action handler user confirm request
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ConfirmAction extends Action {

    use AjaxValidationTrait;

    /**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     * That means, if you name the action as "error" in "SiteController", then the view name
     * would be "error", and the corresponding view file would be "views/site/error.php".
     */
    public $view;

    /**
     * Runs the confirm action
     *
     * @return string result content
     */
    public function run($token) {
        $userClassName = $this->userPlusModule->getModelClassName('UserAccounts');
        $view = $this->view == null ? $this->id : $this->view;
        if (($model = call_user_func($userClassName . '::findIdentityByConfirmToken', $token)) !== null) {
            if ($this->userPlusModule->confirmWithin != false) {
                $time = explode("$", $token)[0];
                $waitTime = time() - intval($time);
                $confirmWithin = $this->userPlusModule->confirmWithin;
                if ($waitTime > $confirmWithin) {
                    return $this->controller->render($view, [
                                'success' => false,
                                'message' => Yii::t('user', 'The confirmation link is invalid or expired. Please try requesting a new one.'),
                    ]);
                }
            }

            if ($model->confirm()) {
                return $this->controller->render($view, [
                            'success' => true,
                            'message' => Yii::t('user', 'Thank you, registration is now complete.'),
                ]);
            } else {
                return $this->controller->render($view, [
                            'success' => false,
                            'message' => Yii::t('user','Something went wrong and your account has not been confirmed.'),
                ]);
            }
            
        } else {
            $view = $this->view == null ? $this->id : $this->view;
            return $this->controller->render($view, [
                        'success' => false,
                        'message' => Yii::t('user','Something went wrong and your account has not been confirmed.')
            ]);
        }
    }

}
