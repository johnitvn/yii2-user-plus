<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::t('user', 'Change Password');
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'change-password-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'old_password')->passwordInput() ?>
                
                <?= $form->field($model, 'new_password')->passwordInput() ?>

                <?= $form->field($model, 'confirm_password')->passwordInput() ?>

                <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>     
    </div>
</div>