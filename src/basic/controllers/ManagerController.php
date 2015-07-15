<?php
namespace johnitvn\userplus\basic\controllers;

use Yii;
use yii\web\Response;
use johnitvn\userplus\simple\controllers\ManagerController as BaseController;

/**
 * ManagerController implements the CRUD actions for User model.
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ManagerController extends BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions']['hand-confirm'] = ['post'];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actionHandConfirm($id) {        
        $model = $this->findModel($id);
        $model->scenario = 'confirm';
        $model->confirm();        
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['forceClose' => true, 'forceReload' => true];
    }

}
