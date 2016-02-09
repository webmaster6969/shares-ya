<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="site-share">
    <h1>Add share</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'share-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'share') ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <h2>List share</h2>
    
    <ul class="list-share">
        <?php foreach ($model->getShare() as $key => $item) { ?>
        <li><?php echo $item->share; ?> <!--<span class="remove">Remove</span>--></li>
        <?php } ?>
    </ul>
    
    
    <?php $formRemove = ActiveForm::begin([
        'id' => 'share-form-remove',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $formRemove->field($model, 'remove')->hiddenInput(['value' => '1']); ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Remove All', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
</div>