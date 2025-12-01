<?php

use common\models\Destino;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Despesa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="despesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $destinos = Destino::find()->all();
    $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
    ?>

    <?= $form->field($model, 'destino_id')->dropDownList(
            $listaDestinos,
        ['prompt' => 'Selecione o Destino...']
    ) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
