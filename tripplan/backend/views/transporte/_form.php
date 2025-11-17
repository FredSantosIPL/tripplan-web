<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\transporte $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transporte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'plano_viagem_id')->textInput() ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'origem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'destino')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_partida')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
