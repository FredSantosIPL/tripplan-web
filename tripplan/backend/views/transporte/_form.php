<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PlanoViagem;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\transporte $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transporte-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Lógica de Ligação Automática ao Plano -->
    <?php if ($model->plano_viagem_id): ?>
        <?= $form->field($model, 'plano_viagem_id')->hiddenInput()->label(false) ?>

        <div class="alert alert-info shadow-sm">
            <i class="fas fa-bus mr-1"></i> A adicionar transporte ao plano de viagem <b>#<?= $model->plano_viagem_id ?></b>
        </div>
    <?php else: ?>
        <?php
        // Busca os planos para o dropdown caso não venha selecionado
        $planos = PlanoViagem::find()->all();
        $listaPlanos = ArrayHelper::map($planos, 'id', 'nome_viagem');
        ?>
        <?= $form->field($model, 'plano_viagem_id')->dropDownList(
            $listaPlanos,
            ['prompt' => 'Selecione o Plano de Viagem...', 'class' => 'form-control shadow-sm']
        )->label('<i class="fas fa-map-marked-alt"></i> Plano de Viagem') ?>
    <?php endif; ?>

    <div class="card bg-light mb-3 shadow-sm border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <!-- Dropdown para o Tipo é melhor que texto livre -->
                    <?= $form->field($model, 'tipo')->dropDownList([
                        'Avião' => 'Avião',
                        'Comboio' => 'Comboio',
                        'Autocarro' => 'Autocarro',
                        'Carro Alugado' => 'Carro Alugado',
                        'Barco' => 'Barco'
                    ], ['prompt' => 'Selecione o tipo de transporte...', 'class' => 'form-control shadow-sm']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'origem', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'De onde parte?']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'destino', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flag-checkered"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Para onde vai?']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'data_partida', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['type' => 'datetime-local']) ?>
                </div>
                <!-- Se tiveres data de chegada, podes adicionar aqui uma coluna col-md-6 -->
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Transporte', ['class' => 'btn btn-success shadow-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>