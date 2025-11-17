<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="destino-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agente_viagem_id')->textInput() ?>

    <?= $form->field($model, 'nome_cidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_chegada')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
