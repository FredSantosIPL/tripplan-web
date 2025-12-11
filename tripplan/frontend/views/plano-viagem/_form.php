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

    <?= $form->field($model, 'data_inicio')->textInput([
        'placeholder' => 'DD-MM-AAAA',
        'type' => 'date' // Mantém o calendário se quiseres
    ])

    ?>

    <?= $form->field($model, 'data_fim')->textInput([
        'placeholder' => 'DD-MM-AAAA',
        'type' => 'date' // Mantém o calendário se quiseres
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>




</div>
