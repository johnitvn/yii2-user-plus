<?php
namespace johnitvn\userplus\basic\commands;

use yii\console\Controller;

/**
 * Controller for alls module commands
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
            'create-admin'=>'johnitvn\userplus\basic\actions\CommandCreateAction',
        ];
    }
}
