<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::t('user', 'Recovery Password');
$module = Yii::$app->getModule('user');

if($alert):?>
<div class="alert alert-success" role="alert">
    	<strong>
            <span style="font-size:16px" class="glyphicon glyphicon-ok-circle"></span>
        </strong> 
        <?=\Yii::t('user',"We have send recovery link to your email.Please check it!") ?>
</div>
<?php return; endif; ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'recovery-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>
                
                <?= $form->field($model, 'login') ?>             

                <?= Html::submitButton(Yii::t('user', 'Recovery Password'), ['class' => 'btn btn-primary btn-block']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?=Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>        
        </p>
        <?php if ($module->enableRegister): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/security/register']) ?>
            </p>
        <?php endif ?>       
    </div>
</div>