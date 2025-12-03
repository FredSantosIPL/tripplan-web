<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PlanoDestino $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="plano-destino-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'destino_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
