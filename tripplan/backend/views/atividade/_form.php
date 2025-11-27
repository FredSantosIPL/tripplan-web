<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Destino;

/** @var yii\web\View $this */
/** @var common\models\Atividade $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="atividade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $destinos = \common\models\Destino::find()->all();
    $listaDestinos = \yii\helpers\ArrayHelper::map($destinos, 'id', 'nome_cidade');
    ?>

    <?= $form->field($model, 'destino_id')->dropDownList(
        $listaDestinos,
        ['prompt' => 'Selecione o Destino...']
    ) ?>

    <?= $form->field($model, 'nome_atividade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
