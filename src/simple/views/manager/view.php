<?php
use yii\bootstrap\Tabs;

echo Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('user','User Detail'),
            'content' => $this->render("_detail",['model'=>$model]),
            'active' => true
        ],
        [
            'label' => Yii::t('user','Role Assignment'),
            'content' => $this->render("_assignment",['model'=>$model]),
        ],
    ]
]);
