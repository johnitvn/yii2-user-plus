<?php

namespace johnitvn\userplus\basic\models;

use Yii;
use johnitvn\userplus\base\Model;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ResendForm extends Model {

    /** @var string User's plain password */
    public $login;

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'login' => Yii::t('user', 'Email'),
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'resend-form';
    }

    /** @inheritdoc */
    public function rules() {
        return [
            'requiredFields' => [['login'], 'required'],
            'loginTrim' => ['login', 'trim'],
            'loginPattern' => ['login', 'email'],
        ];
    }

    /**
     * Resend confirmation email to user.
     * If use already confirmed. Don't accept resend confirm email request 
     * @return boolean
     */
    public function resendConfirmation() {
        if (!$this->validate()) {
            return false;
        } else {
            $modelClass = $this->userPlusModule->getModelClassName('UserAccounts');
            $user = call_user_func($modelClass . '::findIdentityByEmail', $this->login);
            if ($user !== null) {
                if ($user->confirmed_at !== null) {
                    // user is confirmed 
                    $this->addError('login', Yii::t("user", "Your account is confirmed. You can login now"));
                    return false;
                } else {
                    $user->scenario = 'confirm';
                    return $user->resendConfirmation();
                }
            } else {
                $this->addError('login', Yii::t("user", "We didn't found any account corresponds with this email"));
            }
        }
    }

}
