<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PlanoViagem;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\FotosMemorias $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fotos-memorias-form">

    <!-- IMPORTANTE: Adicionar 'enctype' para permitir upload de ficheiros -->
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- 1. Campo User ID (Automático / Escondido) -->
    <!-- Preenchemos com o ID do utilizador atual para não teres de escrever -->
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

    <!-- 2. Lógica de Ligação Automática ao Plano -->
    <?php if ($model->plano_viagem_id): ?>
        <?= $form->field($model, 'plano_viagem_id')->hiddenInput()->label(false) ?>
        <div class="alert alert-info shadow-sm">
            <i class="fas fa-camera mr-1"></i> A adicionar foto ao plano de viagem <b>#<?= $model->plano_viagem_id ?></b>
        </div>
    <?php else: ?>
        <?= $form->field($model, 'plano_viagem_id')->dropDownList(
            ArrayHelper::map(PlanoViagem::find()->all(), 'id', 'nome_viagem'),
            ['prompt' => 'Selecione o Plano de Viagem...', 'class' => 'form-control shadow-sm']
        )->label('<i class="fas fa-map-marked-alt"></i> Plano de Viagem') ?>
    <?php endif; ?>

    <div class="card bg-light mb-3 shadow-sm border-0">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <!-- 3. Campo de Upload (imageFile vem do modelo virtual) -->
                    <?= $form->field($model, 'imageFile')->fileInput(['class' => 'form-control-file border p-1 bg-white rounded']) ?>
                    <small class="text-muted">Formatos aceites: jpg, png, jpeg</small>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <!-- 4. Comentário (Substitui 'descricao') -->
                    <?= $form->field($model, 'comentario')->textarea([
                        'rows' => 4,
                        'placeholder' => 'Escreva uma memória ou comentário sobre esta foto...'
                    ]) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('<i class="fas fa-upload"></i> Guardar Foto', ['class' => 'btn btn-success shadow-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>