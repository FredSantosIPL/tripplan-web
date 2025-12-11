<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Estadia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estadia-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nome_alojamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_checkin')->textInput([
         'placeholder' => 'DD-MM-AAAA',
        'type' => 'date'
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
