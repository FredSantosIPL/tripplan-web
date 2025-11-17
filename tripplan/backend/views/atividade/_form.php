<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Atividade $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="atividade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'destino_id')->textInput() ?>

    <?= $form->field($model, 'nome_atividade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
