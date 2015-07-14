<?php

/* @var $this yii\web\View */
/* @var $success integer */
/* @var $message string */
$this->title = Yii::t('user', 'Confirmation');
?>
<div class="alert alert-<?=$success?'success':'danger'?>" role="alert">
	<?php if($success):?>
    	<strong><span style="font-size:16px" class="glyphicon glyphicon-ok-circle"></span></strong> <?=$message?>
	<?php else: ?>
		<strong><span style="font-size:16px" class="glyphicon glyphicon-remove-circle"></span></strong> <?=$message?>
	<?php endif;?>
</div>