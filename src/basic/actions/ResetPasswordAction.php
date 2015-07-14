<?php

namespace johnitvn\userplus\basic\actions;

use Yii;
use johnitvn\userplus\base\Action;
use johnitvn\userplus\base\traits\AjaxValidationTrait;

/**
 * Reset password action handler user reset password request
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ResetPasswordAction extends Action {

    use AjaxValidationTrait;

    /**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     * That means, if you name the action as "error" in "SiteController", then the view name
     * would be "error", and the corresponding view file would be "views/site/error.php".
     */
    public $view;

    /**
     * Runs the reset password action
     *
     * @return string result content
     */
    public function run($token) {
        $modelClassName = $this->userPlusModule->getModelClassName('UserAccounts');
        $view = $this->view == null ? $this->id : $this->view;
        if (($userModel = call_user_func($modelClassName . '::findIdentityByRecoveryToken', $token)) !== null && $userModel->resetPassword()) {
            return $this->controller->render($view, [
                'success' => true,
                'message' => Yii::t("user", 'The new password will send to your email. Please change your password after login'),
            ]);
        } else {
            return $this->controller->render($view, [
                'success' => false,
                'message' => Yii::t("user", 'Something went wrong and your account can not reset password please retry request again.'),
            ]);
        }
    }

}
