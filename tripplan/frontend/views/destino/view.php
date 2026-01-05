<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Favorito;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */

$this->title = $model->nome_cidade;
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// --- LÓGICA DE FAVORITOS ---
$isFavorito = !Yii::$app->user->isGuest && Favorito::find()
        ->where(['user_id' => Yii::$app->user->id, 'destino_id' => $model->id])
        ->exists();
?>

<div class="destino-view">

    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h1 class="display-4 text-primary font-weight-bold mb-0">
                <?= Html::encode($model->nome_cidade) ?>
            </h1>
            <p class="lead text-muted">
                <i class="fas fa-map-marker-alt text-danger mr-2"></i><?= Html::encode($model->pais) ?>
            </p>
        </div>
        <div class="col-md-5 text-md-right mt-3 mt-md-0">
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::a(
                    $isFavorito ? '<i class="fas fa-heart"></i> Remover Favorito' : '<i class="far fa-heart"></i> Guardar Destino',
                    ['favorito/toggle', 'destino_id' => $model->id],
                    [
                        'class' => $isFavorito ? 'btn btn-danger btn-lg shadow-sm rounded-pill mb-2' : 'btn btn-outline-danger btn-lg shadow-sm rounded-pill mb-2',
                        'data-method' => 'post',
                    ]
                ) ?>
            <?php else: ?>
                <?= Html::a('<i class="far fa-heart"></i> Login para Guardar', ['site/login'], [
                    'class' => 'btn btn-outline-secondary btn-lg shadow-sm rounded-pill mb-2'
                ]) ?>
            <?php endif; ?>

            <div class="btn-group ml-2 mb-2">
                <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary', 'title' => 'Editar']) ?>
                <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'title' => 'Apagar',
                    'data' => [
                        'confirm' => 'Tem a certeza que quer apagar este destino?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<i class="fas fa-reply"></i> Plano', ['plano-viagem/view', 'id' => $model->plano_viagem_id], ['class' => 'btn btn-secondary', 'title' => 'Voltar ao Plano']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h4 class="text-dark mb-4"><i class="fas fa-info-circle text-primary mr-2"></i> Detalhes da Viagem</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-3 rounded-circle mr-3 text-primary">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase">Data de Chegada</small>
                                    <h5 class="mb-0"><?= Yii::$app->formatter->asDate($model->data_chegada, 'long') ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-dark m-0"><i class="fas fa-bed text-info mr-2"></i> Estadias</h4>
<!--                --><?php //= Html::a('<i class="fas fa-plus"></i> Adicionar Estadia',
//                    ['estadia/create', 'destino_id' => $model->id],
//                    ['class' => 'btn btn-info text-white btn-sm rounded-pill shadow-sm']
//                ) ?>
            </div>

            <div class="row mb-5">
                <?php if (empty($model->estadias)): ?>
                    <div class="col-12">
                        <div class="alert alert-light border text-center p-3">
                            <p class="text-muted mb-0">Ainda não definiste onde vais dormir.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($model->estadias as $estadia): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <h5 class="fw-bold text-info"><?= Html::encode($estadia->nome_alojamento) ?></h5>
                                    <p class="small text-muted mb-0">
                                        <i class="fas fa-calendar-check mr-1"></i> Check-in: <?= date('d/m/Y', strtotime($estadia->data_checkin)) ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-top-0 d-flex gap-2">
                                    <?= Html::a('<i class="fas fa-edit"></i>', ['estadia/update', 'id' => $estadia->id], ['class' => 'btn btn-light btn-sm']) ?>
                                    <?= Html::a('<i class="fas fa-trash"></i>', ['estadia/delete', 'id' => $estadia->id], [
                                        'class' => 'btn btn-light text-danger btn-sm',
                                        'data' => ['confirm' => 'Apagar?', 'method' => 'post']
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-dark m-0"><i class="fas fa-ticket-alt text-warning mr-2"></i> Atividades</h4>
<!--                --><?php //= Html::a('<i class="fas fa-plus"></i> Adicionar Atividade',
//                    ['atividade/create', 'destino_id' => $model->id],
//                    ['class' => 'btn btn-warning text-dark btn-sm rounded-pill shadow-sm']
//                ) ?>
            </div>

            <div class="row mb-5">
                <?php if (empty($model->atividades)): ?>
                    <div class="col-12">
                        <div class="alert alert-light border text-center p-4">
                            <p class="text-muted mb-0">Nenhuma atividade planeada aqui.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($model->atividades as $atividade): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title font-weight-bold text-dark m-0">
                                            <?= Html::encode($atividade->nome_atividade) ?>
                                        </h6>
                                        <span class="badge badge-warning text-dark">
                                            <?= Html::encode($atividade->tipo) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top-0 d-flex gap-2">
                                    <?= Html::a('<i class="fas fa-edit"></i>', ['atividade/update', 'id' => $atividade->id], ['class' => 'btn btn-light btn-sm']) ?>
                                    <?= Html::a('<i class="fas fa-trash"></i>', ['atividade/delete', 'id' => $atividade->id], [
                                        'class' => 'btn btn-light text-danger btn-sm',
                                        'data' => ['confirm' => 'Apagar?', 'method' => 'post']
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="m-0 text-dark"><i class="fas fa-star text-warning mr-2"></i> Avaliações e Notas</h4>
                    <?= Html::a('Escrever Avaliação', ['review/create', 'destino_id' => $model->id], ['class' => 'btn btn-primary btn-sm rounded-pill']) ?>
                </div>
                <div class="card-body">

                    <?php
                    $reviews = $model->reviews;

                    if (count($reviews) > 0):
                        foreach ($reviews as $review): ?>
                            <div class="media mb-4 border-bottom pb-3">
                                <div class="mr-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="font-weight-bold text-primary">
                                            <?= isset($review->user) ? substr($review->user->username, 0, 1) : '?' ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mt-0 font-weight-bold">
                                            <?= isset($review->user) ? Html::encode($review->user->username) : 'Utilizador' ?>
                                        </h6>
                                        <small class="text-muted">Avaliação recente</small>
                                    </div>
                                    <div class="text-warning mb-2">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="<?= $i <= $review->classificacao ? 'fas' : 'far' ?> fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-muted mb-0"><?= Html::encode($review->comentario) ?></p>
                                </div>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <div class="text-center py-4">
                            <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Ainda não existem avaliações para este destino.</p>
                            <p>Sê o primeiro a partilhar a tua experiência!</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

</div>