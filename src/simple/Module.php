<?php

namespace johnitvn\userplus\simple;

use johnitvn\userplus\base\Module as BaseModule;

/**
 * Module implments user plus base and useful for simple bussines.
 * The feature of this module is:
 * + User login handler with: 
 *   + username or email
 *   + password
 * + Use register handler with:
 *   + username or email (You just only choose one of two )
 *   + password (and confirm_password)
 * + User logout handler
 * + Create administrator( Just accept create administrator from command)
 * + User manager GUI
 *  
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 * 
 */
class Module extends BaseModule {

    /**
     * @var array modelMap Model mapping. 
     * Need for customize model.
     * Simple module required three model UserAccounts,LoginForm,RegisterForm
     * ````php
     * [
     *  'UserSearch'=>'',
     *  'UserAccounts'=>'',
     *  'LoginForm'=>'',
     *  'RegisterForm'=>''
     * ]
     * ````
     */
    public $modelMap = [];

    /**
     * @var string The login type accept "email"/"username". 
     * Default is username
     */
    public $loginType = "username";

    /**
     * Initial module
     * @return void
     */
    public function init() {
        parent::init();
        if ($this->loginType !== "username" & $this->loginType !== "email") {
            throw new yii\base\InvalidConfigException('loginType just accept "username"/"email".');
        }
    }

    public function getCommandControllerMap() {
        return [
            'user' => $this->getConsoleControllerNamespace() . '\\UserController',
        ];
    }

    /**
     * Return default model map for modules.
     * When user not config model for map so we will get model class
     * from this default model map
     * @return array Default model map
     */
    protected function getDefaultModelMap() {
        return [
            'UserSearch' => 'johnitvn\userplus\simple\models\UserSearch',
            'UserAccounts' => 'johnitvn\userplus\simple\models\UserAccounts',
            'LoginForm' => 'johnitvn\userplus\simple\models\LoginForm',
            'RegisterForm' => 'johnitvn\userplus\simple\models\RegisterForm',
            'ChangePasswordForm' => 'johnitvn\userplus\simple\models\ChangePasswordForm',
        ];
    }

    /**
     * Return console controller namespace.    
     * @return array The console app controller namespace
     */
    protected function getConsoleControllerNamespace() {
        return 'johnitvn\userplus\simple\commands';
    }

    /**
     * Return web controller namespace.
     * @return string The web app controller namespace
     */
    protected function getWebControllerNamespace() {
        return 'johnitvn\userplus\simple\controllers';
    }

}
