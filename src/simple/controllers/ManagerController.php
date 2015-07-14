<?php

namespace johnitvn\userplus\simple\controllers;

use Yii;
use yii\filters\AccessControl;
use johnitvn\userplus\base\WebController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ManagerController implements the CRUD actions for UserAccounts model.
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class ManagerController extends WebController {

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        } else if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdministrator()) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('user', 'You are not allowed to perform this action.'));
        } else {
            return true;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                    'toggle-block' => ['post'],
                    'toggle-superuser' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserAccounts models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = $this->userPlusModule->createModelInstance('UserSearch');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAccounts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "User #" . $id,
                'content' => $this->renderPartial('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new UserAccounts model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = $this->userPlusModule->createModelInstance('UserAccounts', ['scenario' => 'create']);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new User",
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->create(Yii::$app->user->getId())) {
                return [
                    'forceReload' => 'true',
                    'title' => "Create new User",
                    'content' => '<span class="text-success">Create User success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new User",
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->create(Yii::$app->user->getId())) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing UserAccounts model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update User #" . $id,
                    'content' => $this->renderPartial('update', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title' => "User #" . $id,
                    'content' => $this->renderPartial('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update User #" . $id,
                    'content' => $this->renderPartial('update', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing UserAccounts model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        if (Yii::$app->user->getId() == $id) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'An error occurred',
                    'content' => '<span class="text-danger">You can not delete yourself</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                ];
            } else {
                return $this->redirect(['index']);
            }
        }

        //$this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            $this->findModel($id)->delete();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    public function actionToggleBlock($id) {
        $model = $this->findModel($id);
        $model->scenario = 'toggle-block';

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->user->getId() == $id) {
            return [
                'title' => 'An error occurred',
                'content' => '<span class="text-danger">You can not block yourself</span>',
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
            ];
        }


        if ($model != null && $model->toggleBlock()) {
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            return [
                'title' => 'An error occurred',
                'content' => '<span class="text-danger">Can not toggle block this user. Getting unknow error</span>',
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
            ];
            return;
        }
    }

    public function actionToggleSuperuser($id) {
        $model = $this->findModel($id);
        $model->scenario = 'toggle-administrator';

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->user->getId() == $id) {
            return [
                'title' => 'An error occurred',
                'content' => '<span class="text-danger">You can not disable superuser of yourself</span>',
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model != null && $model->toggleAdministrator()) {
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            return [
                'title' => 'An error occurred',
                'content' => '<span class="text-danger">Can not toggle block this user. Getting unknow error</span>',
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
            ];
        }
    }

    /**
     * Delete multiple existing UserAccounts model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete() {
        $request = Yii::$app->request;
        $pks = json_decode($request->post('pks')); // Array or selected records primary keys

        if (in_array(Yii::$app->user->getId(), $pks)) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'An error occurred',
                    'content' => '<span class="text-danger">You can not delete yourself. Please get our your account in your selection</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                ];
            } else {
                return $this->redirect(['index']);
            }
        }

        $userClassName = $this->userPlusModule->getModelClassName('UserAccounts');
        foreach (call_user_func($userClassName . '::findAll', $pks) as $model) {
            $model->delete();
        }


        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    public function actionBulkBlock() {
        $request = Yii::$app->request;
        $pks = json_decode($request->post('pks')); // Array or selected records primary keys


        if (in_array(Yii::$app->user->getId(), $pks)) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'An error occurred',
                    'content' => '<span class="text-danger">You can not block yourself. Please get our your account in your selection</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                ];
            } else {
                return $this->redirect(['index']);
            }
        }

        $userClassName = $this->userPlusModule->getModelClassName('UserAccounts');
        foreach (call_user_func($userClassName . '::findAll', $pks) as $model) {
            $model->scenario = 'block';
            $model->block();
        }


        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    public function actionBulkUnblock() {
        $request = Yii::$app->request;
        $pks = json_decode($request->post('pks')); // Array or selected records primary keys

        $userClassName = $this->userPlusModule->getModelClassName('UserAccounts');
        foreach (call_user_func($userClassName . '::findAll', $pks) as $model) {
            $model->scenario = 'unblock';
            $model->unblock();
        }


        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the UserAccounts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return johnitvn\userplus\base\models\UserAccounts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $userClassName = $this->userPlusModule->getModelClassName('UserAccounts');
        if (($model = call_user_func($userClassName . '::findOne', $id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
