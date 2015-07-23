<?php

namespace johnitvn\userplus\basic;

use johnitvn\userplus\simple\Module as BaseModule;

/**
 * Module implments user plus base and useful for basic bussines.
 * The feature of this module is:
 * + User login handler with: 
 *   + username or email
 *   + password
 * + User confirm handler:
 *   + After register app will send an email with confirm link 
 * to user and use can click to link to confirm your account
 * + Use register handler with:
 *   + username and email
 *   + password (and confirm_password)
 * + User logout handler
 * + Create administrator( Just accept create administrator from command)
 * + User manager GUI
 * 
 * 
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 * 
 */
class Module extends BaseModule {

    public $enableUnconfirmedLogin = true;
    public $enableConfirmation = false;
    public $confirmWithin = 86400; // 24 hours
    public $confirmationHandlerRoute = '/user/security/confirm';
    public $enableRecoveryPassword = false;
    public $resetPasswordHandlerRoute = '/user/security/reset';

    /**
     *
     * @var integer The lenght of token use for recovery and confirmation
     */
    public $tokenLenght = 32;

    /**
     *
     * @var johnitvn\userplus\basic\Mailer The mailer instance 
     */
    public $mailer;

    public function init() {
        parent::init();
        $mailer = \yii\helpers\ArrayHelper::merge($this->mailer, ['class' => 'johnitvn\userplus\basic\Mailer']);
        $this->mailer = \Yii::createObject($mailer);
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
        $parentMap = parent::getDefaultModelMap();
        $parentMap['LoginForm'] = 'johnitvn\userplus\basic\models\LoginForm';
        $parentMap['RegisterForm'] = 'johnitvn\userplus\basic\models\RegisterForm';
        $parentMap['UserAccounts'] = 'johnitvn\userplus\basic\models\UserAccounts';
        $parentMap['RecoveryForm'] = 'johnitvn\userplus\basic\models\RecoveryForm';
        $parentMap['ResendForm'] = 'johnitvn\userplus\basic\models\ResendForm';
        return $parentMap;
    }

    /**
     * Return web controller namespace.
     * @return string The web app controller namespace
     */
    protected function getWebControllerNamespace() {
        return 'johnitvn\userplus\basic\controllers';
    }

    /**
     * Return console controller namespace.    
     * @return array The console app controller namespace
     */
    protected function getConsoleControllerNamespace() {
        return 'johnitvn\userplus\basic\commands';
    }

}
