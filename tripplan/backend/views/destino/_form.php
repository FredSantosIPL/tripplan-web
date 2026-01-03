<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PlanoViagem;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="destino-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- LÓGICA DE LIGAÇÃO AO PLANO DE VIAGEM -->
    <!-- Se já tivermos o ID da viagem (vindo do botão "Adicionar"), escondemos este campo -->
    <?php if ($model->plano_viagem_id): ?>
        <?= $form->field($model, 'plano_viagem_id')->hiddenInput()->label(false) ?>

        <!-- Mostra apenas texto informativo visualmente agradável -->
        <div class="alert alert-info shadow-sm">
            <i class="fas fa-link mr-1"></i> A adicionar destino ao plano de viagem <b>#<?= $model->plano_viagem_id ?></b>
        </div>
    <?php else: ?>
        <!-- Caso contrário (criação solta), mostra um dropdown para escolher a viagem -->
        <?= $form->field($model, 'plano_viagem_id')->dropDownList(
            ArrayHelper::map(PlanoViagem::find()->all(), 'id', 'nome_viagem'),
            ['prompt' => 'Selecione o Plano de Viagem associado...', 'class' => 'form-control shadow-sm']
        )->label('<i class="fas fa-map-marked-alt"></i> Associar a Plano de Viagem') ?>
    <?php endif; ?>

    <div class="card bg-light mb-3 shadow-sm border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- CORREÇÃO: Usar 'template' em vez de 'inputTemplate' para compatibilidade -->
                    <?= $form->field($model, 'nome_cidade', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-city"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Ex: Paris, Londres, Lisboa...']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'pais', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-globe-europe"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Ex: França, Reino Unido, Portugal...']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'data_chegada', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>{input}</div>{error}{hint}'
                    ])->input('date') ?>
                </div>
<!--                <div class="col-md-6">-->
<!--                    --><?php //= $form->field($model, 'data_partida', [
//                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-check"></i></span></div>{input}</div>{error}{hint}'
//                    ])->input('date') ?>
<!--                </div>-->
            </div>

            <!-- Campos opcionais -->
<!--            --><?php //= $form->field($model, 'descricao')->textarea([
//                'rows' => 3,
//                'placeholder' => 'Notas sobre este destino (ex: Locais a não perder, dicas de restaurantes...)'
//            ]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Destino', ['class' => 'btn btn-success shadow-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>