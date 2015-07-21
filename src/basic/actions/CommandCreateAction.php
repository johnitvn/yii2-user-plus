<?php

namespace johnitvn\userplus\basic\actions;

use Yii;
use yii\helpers\Console;
use johnitvn\userplus\base\Command;

/**
 * Command create action will be handler create administrator command from yii console applcation.
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class CommandCreateAction extends Command {

    /**
     * Create new administrator account.
     *
     * @return string result content
     */
    public function run() {
        $this->doCreateAdministrator(Yii::t('user', 'Email'), Yii::t('user', 'Username'), Yii::t('user', 'Password'));
    }

    /**
     * Do create administrator
     * @param string $loginAttributeLabel The login atrribute's label for prompt
     * @param string $passwordAttributeLabel The password atrribute's label for prompt
     */
    public function doCreateAdministrator($loginAttributeLabel, $usernameAtrributeLabel, $passwordAttributeLabel) {
        $login = $this->controller->prompt('Enter ' . $loginAttributeLabel . ':', ['required']);
        $username = $this->controller->prompt('Enter ' . $usernameAtrributeLabel . ':', ['required']);
        $password = $this->controller->prompt('Enter ' . $passwordAttributeLabel . ':', ['required']);

        $user = $this->userPlusModule->createModelInstance('UserAccounts', [
            'login' => $login,
            'password' => $password,
            'username' => $username,
            'scenario' => 'console-create',
        ]);

        if ($user->consoleCreate()) {
            $this->controller->stdout(Yii::t('user', 'User has been created') . "!\n", Console::FG_GREEN);
        } else {
            $this->controller->stdout(Yii::t('user', 'Please fix following errors:') . "\n", Console::FG_RED);
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->controller->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
            $this->promptToRetry($loginAttributeLabel, $usernameAtrributeLabel, $passwordAttributeLabel);
        }
    }

    /**
     * Prompt user to retry
     * @param string $loginAttributeLabel The login atrribute's label for prompt
     * @param string $passwordAttributeLabel The password atrribute's label for prompt
     */
    private function promptToRetry($loginAttributeLabel, $usernameAtrributeLabel, $passwordAttributeLabel) {
        $exit = strtolower($this->controller->prompt('Do you want to retry?[Yes|No]', ['default' => 'N']));
        if ($exit === "yes" || $exit === "y") {
            $this->doCreateAdministrator($loginAttributeLabel, $usernameAtrributeLabel, $passwordAttributeLabel);
        } else if ($exit == "no" || $exit == "n") {
            exit();
        } else {
            $this->promptToRetry($loginAttributeLabel, $usernameAtrributeLabel, $passwordAttributeLabel);
        }
    }

}
