<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DestinoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="destino-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'agente_viagem_id') ?>

    <?= $form->field($model, 'nome_cidade') ?>

    <?= $form->field($model, 'pais') ?>

    <?= $form->field($model, 'data_chegada') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
