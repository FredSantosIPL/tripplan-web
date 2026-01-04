<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Destino;
use common\models\PlanoViagem;

/** @var yii\web\View $this */
/** @var common\models\Atividade $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="atividade-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Lógica do Plano de Viagem -->
    <?php if ($model->plano_viagem_id): ?>
        <?= $form->field($model, 'plano_viagem_id')->hiddenInput()->label(false) ?>

        <div class="alert alert-info shadow-sm mb-4">
            <i class="fas fa-hiking mr-1"></i> A adicionar atividade ao plano de viagem <b>#<?= $model->plano_viagem_id ?></b>
        </div>

        <?php
        // Se temos o plano, carregamos apenas os destinos desse plano para o dropdown ficar filtrado
        $destinos = Destino::find()->where(['plano_viagem_id' => $model->plano_viagem_id])->all();
        $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
        ?>
    <?php else: ?>
        <?php
        // Fallback: carrega todos se não houver plano selecionado
        $destinos = Destino::find()->all();
        $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
        ?>

        <div class="mb-4">
            <?= $form->field($model, 'plano_viagem_id')->dropDownList(
                ArrayHelper::map(PlanoViagem::find()->all(), 'id', 'nome_viagem'),
                ['prompt' => 'Selecione o Plano de Viagem...', 'class' => 'form-control shadow-sm']
            )->label('<i class="fas fa-map-marked-alt"></i> Plano de Viagem') ?>
        </div>
    <?php endif; ?>

    <!-- Card Container -->
    <div class="card shadow-sm border-0 bg-light">
        <div class="card-header bg-white py-3">
            <h5 class="card-title m-0 text-primary"><i class="fas fa-hiking mr-1"></i> Detalhes da Atividade</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'destino_id')->dropDownList(
                        $listaDestinos,
                        ['prompt' => 'Selecione a cidade (Destino)...', 'class' => 'form-control shadow-sm']
                    )->label('<i class="fas fa-map-marker-alt"></i> Localização (Cidade)') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tipo', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tag"></i></span></div>{input}</div>{error}{hint}'
                    ])->dropDownList([
                        'Cultura' => 'Cultura',
                        'Lazer' => 'Lazer',
                        'Gastronomia' => 'Gastronomia',
                        'Desporto' => 'Desporto',
                        'Natureza' => 'Natureza'
                    ], ['prompt' => 'Selecione o Tipo...', 'class' => 'form-control shadow-sm']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'nome_atividade', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-ticket-alt"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Ex: Visita ao Museu, Jantar, Surf...']) ?>
                </div>
            </div>

            <!-- Se tiveres campos extra como Custo ou Data, podes adicionar aqui dentro do card -->
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Atividade', ['class' => 'btn btn-success shadow-sm px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>