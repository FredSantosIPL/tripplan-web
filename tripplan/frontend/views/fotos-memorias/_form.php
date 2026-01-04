<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\FotosMemorias $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="foto-comentario-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <label class="form-label fw-bold">Carregar Foto</label>
            <?= $form->field($model, 'foto')->fileInput([
                'class' => 'form-control mb-4',
                'accept' => 'image/*' // Aceita jpg, png, etc
            ])->label(false) ?>

            <label class="form-label fw-bold">Comentário / Memória</label>
            <?= $form->field($model, 'comentario')->textarea([
                'rows' => 4,
                'placeholder' => 'Escreve uma memória ou comentário sobre esta foto...'
            ])->label(false) ?>

            <?= $form->field($model, 'plano_viagem_id')->hiddenInput()->label(false) ?>

            <?php // echo $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Guardar Foto', ['class' => 'btn btn-success px-4']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>