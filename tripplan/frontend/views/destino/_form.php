<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="destino-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nome_cidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_chegada')->textInput([
        'placeholder' => 'DD-MM-AAAA',
        'type' => 'date'
    ]) ?>



    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
