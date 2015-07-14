<?php

namespace johnitvn\userplus\base;

use Yii;
use yii\base\Model as YiiModel;

/**
 * Base class for all Model classes in <b>User Plus</b> extension.
 * 
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Model extends YiiModel {

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
