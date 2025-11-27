<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Destino;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Estadia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estadia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // Busca todos os destinos e cria um array [id => nome_cidade]
    $listaDestinos = ArrayHelper::map(Destino::find()->all(), 'id', 'nome_cidade');
    ?>

    <?= $form->field($model, 'destino_id')->dropDownList(
        $listaDestinos,
        ['prompt' => 'Selecione o Destino...']
    ) ?>

    <?= $form->field($model, 'nome_alojamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_checkin')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
