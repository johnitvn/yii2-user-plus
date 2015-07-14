<?php

namespace johnitvn\userplus\simple\controllers;

use johnitvn\userplus\base\WebController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Security controller contain all bussiness action for user manager flow.
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class SecurityController extends WebController {
    
    /**
     *
     * @var string The view of login action 
     */
    protected $loginView = '@userplus/simple/views/security/login';
    
    /**
     *
     * @var string The view of register action
     */
    protected $registerView = '@userplus/simple/views/security/register';
    
    /**
     *
     * @var string The view of change password action 
     */
    protected $changePasswordView = '@userplus/simple/views/security/change-password';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'change-password', 'login', 'register'],
                'rules' => [
                    [
                        'actions' => ['login', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'logout' => [
                'class' => 'johnitvn\userplus\base\actions\LogoutAction',
            ],
            'login' => [
                'class' => 'johnitvn\userplus\base\actions\LoginAction',
                'view' => $this->loginView,
            ],
            'register' => [
                'class' => 'johnitvn\userplus\base\actions\RegisterAction',
                'view' => $this->registerView,
            ],
            'change-password' => [
                'class' => 'johnitvn\userplus\base\actions\ChangePasswordAction',
                'view' => $this->changePasswordView,
            ],
        ];
    }

}
