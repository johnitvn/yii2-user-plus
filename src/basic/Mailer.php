<?php

namespace johnitvn\userplus\basic;

use Yii;
use yii\base\Object;

/**
 * Class to do all of job related to send email
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Mailer extends Object {

    /**
     * @var string 
     */
    public $viewPath = '@userplus/basic/views/mails';

    /**
     * @var string|array The sender's email<BR>
     * Default: `Yii::$app->params['adminEmail']` OR `no-reply@example.com` 
     */
    public $sender;

    /**
     * @var string The subject of welcome email 
     */
    public $welcomeSubject;

    /**
     * @var string The subject of comfirmation and recomfirmation email 
     */
    public $confirmationSubject;

    /**
     * @var string The subject of recovery password email 
     */
    public $recoverySubject;

    /**
     * @var string The subject of reset password email 
     */
    public $resetPasswordSubject;

    /**
     * Sends an email to a user after registration.
     *
     * @param EmailableInterface $user  The user model implemented UserEmailSendable
     * @param array|null        $data  The data array pass to email view
     * @return bool
     */
    public function sendWelcomeMessage(EmailableInterface $user, array $data = null) {
        // Get email send to 
        $email = $user->getEmail();
        return $this->send($email, $this->welcomeSubject, 'welcome', $data);
    }

    /**
     * Sends an email to a user with confirmation link.
     *
     * @param EmailableInterface     $user   The user model implemented UserEmailSendable
     * @param array|null            $data   The data array pass to email view
     *
     * @return bool
     */
    public function sendConfirmationMessage(EmailableInterface $user, array $data = null) {
        // Get email send to 
        $email = $user->getEmail();
        // Send email
        return $this->send($email, $this->confirmationSubject, 'confirm', $data);
    }

    /**
     * Sends an email to a user with reconfirmation link.
     *
     * @param EmailableInterface     $user   The user model implemented UserEmailSendable
     * @param array|null            $data   The data array pass to email view
     *
     * @return bool
     */
    public function sendReconfirmationMessage(EmailableInterface $user, array $data = null) {
        return $this->sendConfirmationMessage($user, $data);
    }

    /**
     * Sends an email to a user with recovery link.
     *
     * @param EmailableInterface     $user   The user model implemented UserEmailSendable
     * @param array|null            $data   The data array pass to email view
     *
     * @return bool
     */
    public function sendRecoveryMessage(EmailableInterface $user, array $data = null) {
        // Get email send to 
        $email = $user->getEmail();
        // Send email
        return $this->send($email, $this->recoverySubject, 'recovery', $data);
    }

    public function sendResetPasswordMessage(EmailableInterface $user, array $data = null) {
        // Get email send to 
        $email = $user->getEmail();
        // Send email
        return $this->send($email, $this->resetPasswordSubject, 'reset', $data);
    }

    /**
     * Do send email email
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array|null  $params
     *
     * @return bool
     */
    protected function send($to, $subject, $view, array $data = null) {
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;

        if ($this->sender === null) {
            $this->sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail'] : 'no-reply@example.com';
        }

        return $mailer->compose(['html' => 'html/' . $view, 'text' => 'text/' . $view], $data)
                        ->setTo($to)
                        ->setFrom($this->sender)
                        ->setSubject($subject)
                        ->send();
    }

}
