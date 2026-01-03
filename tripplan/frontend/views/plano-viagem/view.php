<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */

$this->title = $model->nome_viagem;
$this->params['breadcrumbs'][] = ['label' => 'Planos de Viagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Cálculos de datas
$inicio = new DateTime($model->data_inicio);
$fim = new DateTime($model->data_fim);
$diferenca = $inicio->diff($fim);
$dias = $diferenca->days + 1;
?>

<div class="plano-viagem-view">

    <div class="card shadow-sm mb-5 border-0">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-6 fw-bold text-primary mb-0">
                        <i class="fas me-2"></i><?= Html::encode($this->title) ?>
                    </h1>
                    <p class="text-muted mt-2 mb-0">
                        <i class="far fa-calendar-alt"></i>
                        <?= Yii::$app->formatter->asDate($model->data_inicio, 'long') ?>
                        até
                        <?= Yii::$app->formatter->asDate($model->data_fim, 'long') ?>
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="badge bg-info text-dark p-3 rounded-pill fs-6 shadow-sm">
                        <i class="fas fa-clock"></i> Duração: <?= $dias ?> dias
                    </div>
                    <div class="mt-3">
                        <?= Html::a('Editar Viagem', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tens a certeza?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold border-start border-4 border-primary ps-3">Destinos</h3>
        <?= Html::a('<i class="fas fa-plus"></i> Adicionar Destino',
            ['destino/create', 'plano_viagem_id' => $model->id],
            ['class' => 'btn btn-success shadow-sm rounded-pill px-4']
        ) ?>
    </div>

    <div class="row mb-5">
        <?php if (empty($model->destinos)): ?>
            <div class="col-12">
                <div class="alert alert-light border text-center p-4">

                    <p>Adiciona as cidades que vais visitar.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($model->destinos as $destino): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body">
                            <h4 class="card-title fw-bold"><?= Html::encode($destino->nome_cidade) ?></h4>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <i class="fas fa-globe-europe"></i> <?= Html::encode($destino->pais) ?>
                            </h6>
                            <p class="card-text text-secondary">
                                <small>Chegada: <?= Yii::$app->formatter->asDate($destino->data_chegada, 'php:d M, Y') ?></small>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex gap-2 pb-3">
                            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['destino/update', 'id' => $destino->id], ['class' => 'btn btn-light btn-sm flex-grow-1']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i>', ['destino/delete', 'id' => $destino->id], [
                                'class' => 'btn btn-light text-danger btn-sm',
                                'data' => ['confirm' => 'Apagar destino?', 'method' => 'post']
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold border-start border-4 border-info ps-3">Estadias</h3>
        <?= Html::a('<i class="fas fa-plus"></i> Adicionar Estadia',
            ['estadia/create', 'plano_id' => $model->id],
            ['class' => 'btn btn-primary shadow-sm rounded-pill px-4']
        ) ?>
    </div>

    <div class="row">
        <?php if (empty($model->estadias)): ?>
            <div class="col-12">
                <div class="alert alert-light border text-center p-4">
                    <p>Adiciona hotéis ou alojamentos.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($model->estadias as $estadia): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">
                                <?= Html::encode($estadia->nome_alojamento) ?>
                            </h5>
                            <p class="card-text mt-3">
                                <i class="fas fa-calendar-check text-success"></i>
                                <strong>Check-in:</strong> <br>
                                <?= Yii::$app->formatter->asDate($estadia->data_checkin, 'php:d M, Y') ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex gap-2 pb-3">
                            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['estadia/update', 'id' => $estadia->id], ['class' => 'btn btn-light btn-sm flex-grow-1']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i>', ['estadia/delete', 'id' => $estadia->id], [
                                'class' => 'btn btn-light text-danger btn-sm',
                                'data' => ['confirm' => 'Apagar estadia?', 'method' => 'post']
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); }
</style>