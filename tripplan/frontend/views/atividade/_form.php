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

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <?php if ($model->plano_viagem_id): ?>
                <?= $form->field($model, 'plano_viagem_id')->hiddenInput()->label(false) ?>

                <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info mb-4">
                    <i class="fas fa-map-marked-alt me-2"></i>
                    A adicionar atividade ao plano <strong>#<?= $model->plano_viagem_id ?></strong>
                </div>

                <?php
                // Filtra cidades apenas deste plano
                $destinos = Destino::find()->where(['plano_viagem_id' => $model->plano_viagem_id])->all();
                $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
                ?>
            <?php else: ?>
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Plano de Viagem</label>
                    <?= $form->field($model, 'plano_viagem_id')->dropDownList(
                        ArrayHelper::map(PlanoViagem::find()->all(), 'id', 'nome_viagem'),
                        ['prompt' => 'Selecione o Plano de Viagem', 'class' => 'form-select']
                    )->label(false) ?>
                </div>

                <?php
                $destinos = Destino::find()->all();
                $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
                ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-map-marker-alt me-1 text-danger"></i> Localização (Cidade)
                    </label>
                    <?= $form->field($model, 'destino_id')->dropDownList(
                        $listaDestinos,
                        ['prompt' => 'Selecione a cidade...', 'class' => 'form-select']
                    )->label(false) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tasks me-1 text-primary"></i> Tipo de Atividade
                    </label>
                    <?= $form->field($model, 'tipo')->dropDownList([
                        'Cultura' => 'Cultura',
                        'Lazer' => 'Lazer',
                        'Gastronomia' => 'Gastronomia',
                        'Desporto' => 'Desporto',
                        'Natureza' => 'Natureza'
                    ], ['prompt' => 'Selecione o Tipo...', 'class' => 'form-select'])->label(false) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label class="form-label fw-bold">
                        <i></i> Nome da Atividade
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-ticket-alt"></i></span>
                        <?= $form->field($model, 'nome_atividade')->textInput([
                            'class' => 'form-control',
                            'placeholder' => 'Ex: Visita ao Museu, Jantar, Surf...'
                        ])->label(false) ?>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4 text-end">
                <?= Html::submitButton('Guardar Atividade', [
                    'class' => 'btn btn-success px-4 rounded-pill shadow-sm fw-bold'
                ]) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>