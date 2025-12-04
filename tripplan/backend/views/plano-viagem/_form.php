<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="plano-viagem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome_viagem')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'data_inicio')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'data_fim')->textInput(['type' => 'date']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
