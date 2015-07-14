<?php

namespace johnitvn\userplus\base;

use Yii;
use yii\db\ActiveRecord as YiiActiveRecord;

/**
 * Base class for all ActiveRecord classes in <b>User Plus</b> extension.
 * 
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ActiveRecord extends YiiActiveRecord {

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
