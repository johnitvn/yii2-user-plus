<?php

namespace johnitvn\userplus\base;

use yii\base\Action as YiiAction;

/**
 * Base class for all action classes in <b>User Plus</b> extension.
 * 
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 * @property ConsoleController $controller
 */
class Command extends YiiAction {

    /**
     * @var Module The curent user plus module(Subclass of johnitvn\userplus\base\Module)
     */
    protected $userPlusModule;

    public function init() {
        parent::init();
        $this->userPlusModule = $this->controller->userPlusModule;
    }

}
