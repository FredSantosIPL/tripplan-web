<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Destino;

/* @var $this yii\web\View */
/* @var $model common\models\PlanoViagem */
/* @var $form yii\widgets\ActiveForm */

// Tenta carregar destinos. Se a tabela não existir, usa uma lista vazia para não dar erro.
try {
    $todosDestinos = Destino::find()->all();
    $listaDestinos = ArrayHelper::map($todosDestinos, 'id', 'nome');
} catch (\Exception $e) {
    $listaDestinos = []; // Lista vazia se houver erro na BD
}
?>

<style>
    .travel-card {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border: 1px solid #e0e0e0;
        margin-top: 20px;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    /* Checkboxes transformados em botões */
    .destination-selector .checkbox {
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .destination-selector label {
        cursor: pointer;
        padding: 8px 18px;
        border: 1px solid #ddd;
        border-radius: 20px;
        background: #f8f9fa;
        color: #555;
        font-weight: 500;
        transition: all 0.2s;
        margin-bottom: 0;
    }

    /* Estilo quando selecionado */
    .destination-selector input[type='checkbox']:checked + label {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    }

    .destination-selector input[type='checkbox'] {
        display: none; /* Esconde a caixa feia */
    }
</style>

<div class="plano-viagem-form">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="travel-card">

                <h3 class="text-center mb-4">Vamos Planear Nova Viagem</h3>

                <?php $form = ActiveForm::begin(); ?>

                <div class="section-title">Detalhes da Viagem</div>

                <?= $form->field($model, 'nome_viagem')->textInput([
                    'class' => 'form-control form-control-lg',
                    'placeholder' => 'Ex: Férias em Portugal'
                ])->label('Nome da viagem') ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'data_inicio')->textInput(['type' => 'date']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'data_fim')->textInput(['type' => 'date']) ?>
                    </div>
                </div>

                <div class="form-group text-center">
                    <?= Html::submitButton('Guardar Plano', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>