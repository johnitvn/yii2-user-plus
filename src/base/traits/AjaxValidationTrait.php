<?php
namespace johnitvn\userplus\base\traits;

use Yii;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * The trait contain method for perform ajax validation
 * 
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
trait AjaxValidationTrait
{
    
    /**
     * Perform ajax validation.
     *
     * @param Model $model
     *
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            Yii::$app->end();
        }
    }
    
}
