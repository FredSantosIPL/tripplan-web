<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Estadia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estadia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'destino_id')->textInput() ?>

    <?= $form->field($model, 'nome_alojamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_checkin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
