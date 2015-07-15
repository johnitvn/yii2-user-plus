<?php

namespace johnitvn\userplus\basic\controllers;

use johnitvn\userplus\simple\controllers\SecurityController as BaseController;

/**
 * Security controller contain all bussiness action for user manager flow.
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class SecurityController extends BaseController {

    protected $registerView = '@userplus/basic/views/security/register';
    
    protected $loginView = '@userplus/basic/views/security/login';

    /**
     * @inheritdoc
     */
    public function actions() {
        $actions = parent::actions();
        $actions['confirm'] = 'johnitvn\userplus\basic\actions\ConfirmAction';
        $actions['recovery'] = 'johnitvn\userplus\basic\actions\RecoveryPasswordAction';
        $actions['reset'] = 'johnitvn\userplus\basic\actions\ResetPasswordAction';
        $actions['resend'] = 'johnitvn\userplus\basic\actions\ResendConfirmAction';
        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access']['only'][] = 'confirm';
        $behaviors['access']['only'][] = 'recovery';
        $behaviors['access']['only'][] = 'reset';
        $behaviors['access']['only'][] = 'resend';
        $behaviors['access']['rules'][] = [
            'actions' => ['confirm', 'recovery', 'reset', 'resend'],
            'allow' => true,
            'roles' => ['?'],
        ];
        return $behaviors;
    }

}
