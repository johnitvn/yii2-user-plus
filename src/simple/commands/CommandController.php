<?php
namespace johnitvn\userplus\simple\commands;

use yii\console\Controller;

/**
 * User manager commands
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class CommandController extends Controller{
    
    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'create-admin'=>'johnitvn\userplus\base\actions\CommandCreateAction',
        ];
    }
    
}
