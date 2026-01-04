<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="plano-viagem-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Card Container -->
    <div class="card shadow-sm border-0 bg-light">
        <div class="card-header bg-white py-3">
            <h5 class="card-title m-0 text-primary"><i class="fas fa-info-circle mr-1"></i> Dados da Viagem</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $form->field($model, 'nome_viagem', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span></div>{input}</div>{error}{hint}'
                    ])->textInput(['maxlength' => true, 'placeholder' => 'Ex: Férias de Verão 2025, Viagem a Paris...']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'data_inicio', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-plus"></i></span></div>{input}</div>{error}{hint}'
                    ])->input('date') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'data_fim', [
                        'template' => '{label}<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-minus"></i></span></div>{input}</div>{error}{hint}'
                    ])->input('date') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Plano', ['class' => 'btn btn-success shadow-sm px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>