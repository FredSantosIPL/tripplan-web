<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Destino;

/** @var yii\web\View $this */
/** @var common\models\Estadia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estadia-form">


    <?php $form = ActiveForm::begin(); ?>

    <?php
    // Vamos buscar os dados e ver se existem
    $destinos = Destino::find()->all();

    // Transforma em lista.
    $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
    ?>


    <?= $form->field($model, 'destino_id')->dropDownList(
            $listaDestinos,

        ['prompt' => 'Selecione o Destino']
    ) ?>

    <?= $form->field($model, 'nome_alojamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList(
        [
                'Hotel' => 'Hotel',
        'Pousada' => 'Pousada',
        'Resort' => 'Resort',
        'Hostel' => 'Hostel',
        ],
        ['prompt' => 'Selecione o Tipo de Alojamento']
    ) ?>


    <?= $form->field($model, 'data_checkin')->textInput([
         'placeholder' => 'DD-MM-AAAA',
        'type' => 'date'
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
