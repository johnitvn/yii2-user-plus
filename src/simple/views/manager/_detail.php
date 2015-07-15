<?php
use yii\widgets\DetailView;
use johnitvn\userplus\base\models\UserAccounts;
use yii\helpers\Html;
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            [
               'attribute'=>'administrator',               
               'value'=> $model['administrator']?"Yes":"No"
            ],
            [
               'attribute'=>'creator',               
               'format' => 'raw',
               'value'=> $model['creator']==-1?"Created by Console":
                            $model['creator']==-2?"User register by my self":
                                Html::a(UserAccounts::findOne($model['creator'])->login,['/user/manager/view','id'=>UserAccounts::findOne($model['creator'])->id],["role"=>"modal-remote"])
            ],
            'creator_ip',         
            [
               'attribute'=>'blocked_at',               
               'value'=> $model['blocked_at']==null?"Not blocked":date("d/m/Y H:i:s",$model['blocked_at'])
            ],
            [
               'attribute'=>'created_at',               
               'value'=>date("d/m/Y H:i:s",$model['created_at'])
            ],
            [
               'attribute'=>'updated_at',               
               'value'=>$model['updated_at']==-1?\Yii::t("user","Never Update"):date("d/m/Y H:i:s",$model['updated_at'])
            ],
        ],
    ]) ?>

</div>
