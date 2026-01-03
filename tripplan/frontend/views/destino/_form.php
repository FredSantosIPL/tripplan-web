<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Destino */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destino-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nome_cidade')->textInput([
        'maxlength' => true,
        'placeholder' => 'Começa a escrever para ver sugestões...',
        'class' => 'form-control form-control-lg',
        'list' => 'lista-cidades' // Isto liga o input à lista abaixo
    ])->label('Cidade') ?>

    <datalist id="lista-cidades">
        <?php foreach ($cidadesDisponiveis as $cidade): ?>
        <option value="<?= \yii\helpers\Html::encode($cidade) ?>">
            <?php endforeach; ?>
    </datalist>

    <?= $form->field($model, 'pais')->textInput([
        'maxlength' => true,
        'placeholder' => 'Ex: França',
        'class' => 'form-control'
    ]) ?>

    <?= $form->field($model, 'data_chegada')->input('date', [
        'class' => 'form-control'
    ]) ?>

    <div class="form-group mt-4 d-grid gap-2">
        <?= Html::submitButton('Guardar Destino', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>