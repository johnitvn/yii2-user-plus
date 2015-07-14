<?php

namespace johnitvn\userplus\basic\controllers;

use johnitvn\userplus\simple\controllers\SecurityController as BaseController;

/**
 * ManagerController implements the CRUD actions for User model.
 */
class SecurityController extends BaseController {
    
    protected $registerView = '@userplus/basic/views/security/register';
    
    protected $loginView = '@userplus/basic/views/security/login';
    
    public function actions() {
        $actions = parent::actions();
        $actions['confirm']='johnitvn\userplus\basic\actions\ConfirmAction';      
        $actions['recovery']='johnitvn\userplus\basic\actions\RecoveryPasswordAction';      
        $actions['reset']='johnitvn\userplus\basic\actions\ResetPasswordAction';      
        $actions['resend']='johnitvn\userplus\basic\actions\ResendConfirmAction';      
        return $actions;
    }
    
  
}
