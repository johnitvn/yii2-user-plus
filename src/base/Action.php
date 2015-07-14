<?php

namespace johnitvn\userplus\base;

use Yii;
use yii\base\Action as YiiAction;

/**
 * Base class for all action classes in <b>User Plus</b> extension.
 * 
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Action extends YiiAction {

    /**
     * @var Module The curent user plus module(Subclass of johnitvn\userplus\base\Module)
     */
    protected $userPlusModule;

    /**
     * Initial of action
     */
    public function init() {
        // get instance of user module
        $this->userPlusModule = Yii::$app->getModule('user');
    }

}
