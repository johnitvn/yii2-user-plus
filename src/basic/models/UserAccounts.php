<?php

namespace johnitvn\userplus\basic\models;

use Yii;
use yii\helpers\Url;
use johnitvn\userplus\Helper;
use johnitvn\userplus\basic\UserConfirmableInterface;
use johnitvn\userplus\basic\UserRecoveryableInterface;
use johnitvn\userplus\base\models\UserAccounts as BaseUserAccounts;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class UserAccounts extends BaseUserAccounts implements UserConfirmableInterface, UserRecoveryableInterface {

    /**
     * @var User Accounts Event
     */
    const BEFORE_RESET_PASSWORD = 'beforeResetPassword';

    /**
     * @var User Accounts Event
     */
    const AFTER_RESET_PASSWORD = 'afterResetPassword';

    /**
     * @var User Accounts Event
     */
    const BEFORE_CONFIRM = 'beforeConfirm';

    /**
     * @var User Accounts Event
     */
    const AFTER_CONFIRM = 'afterConfirm';

    /**
     * @var User Accounts Event
     */
    const BEFORE_RECONFIRM = 'beforeReconfirm';

    /**
     * @var User Accounts Event
     */
    const AFTER_RECONFIRM = 'afterReconfirm';

    /**
     * @var User Accounts Event
     */
    const BEFORE_RECOVERY = 'beforeRecovery';

    /**
     * @var User Accounts Event
     */
    const AFTER_RECOVERY = 'afterRecovery';

    /**
     * Instace of johnitvn\userplus\basic\Mailer
     * @var johnitvn\userplus\basic\Mailer 
     */
    protected $mailer;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->mailer = $this->userPlusModule->mailer;
        $this->on(self::AFTER_REGISTER, [$this, 'afterRegister']);
        $this->on(self::AFTER_RECOVERY, [$this, 'afterRecovery']);
        $this->on(self::AFTER_RESET_PASSWORD, [$this, 'afterResetPassword']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();
        $rules['usernameRequired'] = ['username', 'required'];
        $rules['usernamePattern'] = ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'];
        $rules['usernameLength'] = ['username', 'string', 'min' => 3, 'max' => 255];
        $rules['usernameUnique'] = ['username', 'unique', 'message' => Yii::t('user', 'This username has already been taken')];

        $rules['loginUnique'] = ['login', 'unique', 'message' => Yii::t('user', 'This email has already been taken for other account')];
        $rules['loginPattern'] = ['login', 'email'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['login'] = Yii::t('user', 'Email');
        $labels['username'] = Yii::t('user', 'Username');
        return $labels;
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['register'][] = 'username';
        $scenarios['create'][] = 'username';
        $scenarios['console-create'][] = 'username';
        $scenarios['confirm'] = ['confirm_token', 'confirmed_at'];
        $scenarios['recovery'] = ['recovery_token'];
        $scenarios['reset-password'] = ['password'];
        return $scenarios;
    }

    /**
     * Get username of user
     * @return string Return the username of use
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Do all jobs after register
     * @return boolean
     */
    public function afterRegister() {
        if ($this->userPlusModule->enableConfirmation) {
            $token = $this->generateConfirmToken();
            $route = $this->userPlusModule->confirmationHandlerRoute;
            $url = Url::to([$route, 'token' => $token], true);
            if (!$this->save()) {
                return false;
            }
            $this->mailer->sendConfirmationMessage($this, ['url' => $url]);
        }
    }

    /**
     * Find user by login field
     *
     * @param string email/username to find
     * @return boolean|UserAccounts 
     */
    public static function findIdentityByLogin($login) {
        $userPlusModule = \Yii::$app->getModule('user');
        if ($userPlusModule->loginType == "username") {
            $model = static::findOne(['username' => $login]);
        } else {
            $model = static::findOne(['login' => $login]);
        }
        return $model;
    }

    public static function findIdentityByEmail($email) {
        return static::findOne(['login' => $email]);
    }

    /**
     * 
     * @return boolean
     */
    public function isConfirmed() {
        return $this->confirmed_at !== null;
    }

    /**
     * 
     * @return string
     */
    public function getEmail() {
        return $this->login;
    }

    /**
     * 
     * @return boolean
     */
    public function confirm() {
        $this->trigger(self::BEFORE_CONFIRM);
        $this->scenario = 'confirm';
        $this->confirm_token = null;
        $this->confirmed_at = time();
        if (!$this->save()) {
            return false;
        }
        $this->trigger(self::AFTER_CONFIRM);
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function recovery() {
        $this->trigger(self::BEFORE_RECOVERY);
        $this->generateRecoveryToken();
        if (!$this->save()) {
            return false;
        }
        $this->trigger(self::AFTER_RECOVERY);
        return true;
    }

    /**
     * Do all jobs when after recovery
     */
    public function afterRecovery() {
        $token = $this->recovery_token;
        $route = $this->userPlusModule->resetPasswordHandlerRoute;
        $url = Url::to([$route, 'token' => $token], true);
        $this->mailer->sendRecoveryMessage($this, ['url' => $url]);
    }

    /**
     * 
     * @return boolean
     */
    public function resetPassword() {
        $this->trigger(self::BEFORE_RESET_PASSWORD);
        $this->scenario = 'reset-password';
        $this->password = Helper::generatePassword();
        if (!$this->save()) {
            return false;
        }

        $this->trigger(self::AFTER_RESET_PASSWORD);
        return true;
    }

    /**
     * 
     */
    public function afterResetPassword() {
        $this->mailer->sendResetPasswordMessage($this, ['password' => $this->password]);
    }

    /**
     * 
     * @return boolean
     */
    public function resendConfirmation() {
        $this->trigger(self::BEFORE_RECONFIRM);
        $token = $this->generateConfirmToken();
        $route = $this->userPlusModule->confirmationHandlerRoute;
        $url = Url::to([$route, 'token' => $token], true);
        if (!$this->save()) {
            return false;
        }
        $this->mailer->sendReconfirmationMessage($this, ['url' => $url]);
        $this->trigger(self::AFTER_RECONFIRM);
        return true;
    }

    /**
     * 
     * @return string
     */
    public function generateConfirmToken() {
        $token = Helper::generateRandomString($this->userPlusModule->tokenLenght);
        $this->confirm_token = $token;
        return $this->confirm_token;
    }

    /**
     * 
     * @return string
     */
    public function generateRecoveryToken() {
        $token = Helper::generateRandomString($this->userPlusModule->tokenLenght);
        $this->recovery_token = $token;
        return $this->recovery_token;
    }

    /**
     * 
     * @param string $token
     * @return UserAccounts
     */
    public static function findIdentityByConfirmToken($token) {
        return UserAccounts::findOne(['confirm_token' => $token]);
    }

    /**
     * 
     * @param string $token
     * @return UserAccounts
     */
    public static function findIdentityByRecoveryToken($token) {
        return UserAccounts::findOne(['recovery_token' => $token]);
    }

}
