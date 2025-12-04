<?php

use common\models\PlanoViagem;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\transporte $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transporte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // Busca os planos de viagem.
    // Nota: Num cenário real, talvez quisesse filtrar apenas pelos planos do utilizador logado.
    $planos = PlanoViagem::find()->all();
    $listaPlanos = ArrayHelper::map($planos, 'id', 'nome_viagem');
    ?>

    <?= $form->field($model, 'plano_viagem_id')->dropDownList(
        $listaPlanos,
        ['prompt' => 'Selecione o Plano de Viagem...']
    ) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Avião, Comboio, Autocarro']) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'origem')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'destino')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'data_partida')->textInput(['type' => 'datetime-local']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
