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

    <!-- LÓGICA DE LIGAÇÃO AO DESTINO -->
    <?php if ($model->destino_id): ?>
        <?= $form->field($model, 'destino_id')->hiddenInput()->label(false) ?>

        <div class="alert alert-info shadow-sm mb-4">
            <i class="fas fa-map-marker-alt mr-1"></i> A adicionar estadia ao destino <b>#<?= $model->destino_id ?></b>
        </div>
    <?php else: ?>
        <?php
        // Busca todos os destinos se não houver um pré-selecionado
        $listaDestinos = ArrayHelper::map(Destino::find()->all(), 'id', 'nome_cidade');
        ?>
        <div class="mb-4">
            <?= $form->field($model, 'destino_id')->dropDownList(
                $listaDestinos,
                ['prompt' => 'Selecione o Destino...', 'class' => 'form-control shadow-sm']
            )->label('<i class="fas fa-map-marked-alt"></i> Destino') ?>
        </div>
    <?php endif; ?>

    <!-- Card Container -->
    <div class="card shadow-sm border-0 bg-light">
        <div class="card-header bg-white py-3">
            <h5 class="card-title m-0 text-danger"><i class="fas fa-hotel mr-1"></i> Dados do Alojamento</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'nome_alojamento', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-bed"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Ex: Hotel Ritz, Airbnb Centro, Hostel...']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'tipo', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tag"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Ex: Hotel, Apartamento...']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'data_checkin', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-check"></i></span></div>{input}</div>{error}{hint}'
                    ])->input('date') ?>
                </div>
                <!-- Se tiveres data de checkout no futuro, adiciona aqui -->
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Estadia', ['class' => 'btn btn-success shadow-sm px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>