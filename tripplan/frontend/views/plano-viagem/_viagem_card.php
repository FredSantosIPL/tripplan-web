<?php

use yii\helpers\Html;

/** @var common\models\PlanoViagem $model */
?>

<div class="card h-100 shadow-sm border-0 hover-effect">
    <div class="card-body">
        <h5 class="card-title fw-bold text-primary">
            <?= Html::encode($model->nome_viagem) ?>
        </h5>

        <p class="text-muted small mb-3">
            <i class="fas fa-calendar-alt me-2"></i>
            <?= Yii::$app->formatter->asDate($model->data_inicio, 'medium') ?>
            <i class="fas fa-arrow-right mx-1"></i>
            <?= Yii::$app->formatter->asDate($model->data_fim, 'medium') ?>
        </p>

        <div class="d-flex justify-content-end mt-auto">
            <?= Html::a('<i class="fas fa-eye"></i> Ver', ['view', 'id' => $model->id], [
                'class' => 'btn btn-sm btn-outline-primary me-2 rounded-pill'
            ]) ?>
            <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], [
                'class' => 'btn btn-sm btn-outline-secondary rounded-circle'
            ]) ?>
            <?= \yii\helpers\Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger btn-sm', // <--- Isto cria a borda vermelha igual aos outros
                'style' => 'margin-left: 5px;', // Dá um espacinho para não ficar colado
                'title' => 'Apagar',
                'data' => [
                    'confirm' => 'Tens a certeza que queres apagar esta viagem?',
                    'method' => 'post',
                ],
            ]) ?>

        </div>


    </div>
</div>