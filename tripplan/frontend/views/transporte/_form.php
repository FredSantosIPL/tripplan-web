<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\PlanoViagem;

/** @var yii\web\View $this */
/** @var common\models\Transporte $model */
/** @var yii\widgets\ActiveForm $form */



// --- LISTA DE OPÇÕES DE TRANSPORTE ---
$tiposTransporte = [
    'Avião' => ' Avião',
    'Comboio' => ' Comboio',
    'Autocarro' => 'Autocarro',
    'Carro' => 'Carro Alugado/Próprio',
    'Barco' => 'Barco',

];

$planos = PlanoViagem::find()->all();
$listaPlanos = ArrayHelper::map($planos, 'id', 'nome_viagem');

?>


<div class="transporte-form">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">

                    <h3 class="mb-4 text-primary">Detalhes da Viagem</h3>

                    <?php $form = ActiveForm::begin([
                        'options' => ['class' => 'needs-validation'],
                        'fieldConfig' => [
                            'template' => "<div class='mb-3'>{label}\n{input}\n{error}</div>",
                            'labelOptions' => ['class' => 'form-label fw-bold text-secondary'],
                            'inputOptions' => ['class' => 'form-control form-control-lg'],
                            'errorOptions' => ['class' => 'invalid-feedback d-block'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'tipo')->dropDownList(
                        $tiposTransporte,
                        ['prompt' => 'Selecione o meio de transporte...']
                    ) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'origem')->textInput([
                                'placeholder' => 'Ex: Lisboa',
                                'maxlength' => true
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'destino')->textInput([
                                'placeholder' => 'Ex: Paris',
                                'maxlength' => true
                            ]) ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'data_partida')->input('datetime-local') ?>


                    <?= $form->field($model, 'plano_viagem_id')->dropDownList(
                        $listaPlanos,
                        ['prompt' => 'Selecione a viagem...']
                    ) ?>

                    <div class="form-group mt-4 d-grid">
                        <?= Html::submitButton('Guardar Transporte', ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>


                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>

</div>