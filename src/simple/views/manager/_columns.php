<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\jui\DatePicker;

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id',
        'width' => '40px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'login',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_at',
        'value' => function($model) {
            return date('d/m/Y', $model->created_at);
        },
        'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'created_at',
            'dateFormat' => 'php:Y-m-d',
            'options' => [
                'class' => 'form-control',
            ],
        ]),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'width' => '50px',
        'attribute' => 'blocked_at',
        'label'=>'Status',
        'value' => function ($model) {
            if ($model->blocked_at !== null) {
                return Html::a(Yii::t('user', 'Unblock'), ['toggle-block', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-warning btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                ]);
            } else {
                return Html::a(Yii::t('user', 'Block'), ['toggle-block', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-danger btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                ]);
            }
        },
        'format' => 'raw',
        'visible' => Yii::$app->user->identity->isAdministrator(),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'width' => '130px',
        'attribute' => 'administrator',
        'value' => function ($model) {
            if (!$model->administrator) {
                return Html::a(Yii::t('user', 'Set SU'), ['toggle-superuser', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-danger btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                ]);
            } else {
                return Html::a(Yii::t('user', 'Remove SU'), ['toggle-superuser', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-info btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                ]);
            }
        },
        'format' => 'raw',
        'visible' => Yii::$app->user->identity->isAdministrator(),
        'filter' => [0 => 'Not Admin', 1 => 'Admin'],
    ]
];
        
$rbacModule = Yii::$app->getModule('rbac');
if (get_class($rbacModule) === 'johnitvn\rbacplus\Module') {
    /**
     * Intergrate with Rbac Plus extension
     */
    $columns[] = [
            'class' => 'kartik\grid\DataColumn',
            'header' => Yii::t('rbac', 'Assignment'),   
            'hAlign' => 'center',
            'value'=>function($model){
                return Html::a('<span class="glyphicon glyphicon-king"></span>',
                                ['/rbac/assignment/assignment', 'id' => $model->id], 
                                [
                                    'role' => 'modal-remote',
                                    'title' => Yii::t('user', 'Assignment'),
                                ]
                        );
            },
            'format' => 'raw',    
            'visible' => Yii::$app->user->identity->isAdministrator(),        
        ];
    
}
        
        
$columns[] = [   
    'class' => 'kartik\grid\ActionColumn',
    'dropdown' => false,
    'vAlign' => 'middle',
    'hAlign' => 'center',
    'urlCreator' => function($action, $model, $key, $index) {
        return Url::to([$action, 'id' => $key]);
    },
    'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
    'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
    'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
    'data-confirm' => false, 'data-method' => false, // for overide yii data api
    'data-request-method' => 'post',
    'data-toggle' => 'tooltip',
    'data-confirm-title' => 'Are you sure?',
    'data-confirm-message' => 'Are you sure want to delete this item'],
];

return $columns;