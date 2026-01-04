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

    <!-- CABEÇALHO DO DESTINO -->
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
            <!-- Botão de Favoritos -->
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
            </div>
        </div>
    </div>

    <div class="row">
        <!-- COLUNA ÚNICA: DETALHES E REVIEWS -->
        <div class="col-12">
            <!-- Cartão de Informações -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h4 class="text-dark mb-4"><i class="fas fa-info-circle text-primary mr-2"></i> Detalhes da Viagem</h4>
                        <!-- Botão Mapa (Mantido de forma discreta) -->
                        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($model->nome_cidade . ',' . $model->pais) ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill">
                            <i class="fas fa-map-marked-alt mr-1"></i> Ver no Mapa
                        </a>
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

            <!-- SECÇÃO DE REVIEWS (AVALIAÇÕES) -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="m-0 text-dark"><i class="fas fa-star text-warning mr-2"></i> Avaliações e Notas</h4>
                    <?= Html::a('Escrever Avaliação', ['review/create', 'destino_id' => $model->id], ['class' => 'btn btn-primary btn-sm rounded-pill']) ?>
                </div>
                <div class="card-body">

                    <!-- LISTA DE COMENTÁRIOS -->
                    <?php
                    $reviews = $model->reviews;

                    if (count($reviews) > 0):
                        foreach ($reviews as $review): ?>
                            <div class="media mb-4 border-bottom pb-3">
                                <div class="mr-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <!-- Mostra a inicial do username -->
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
                                        <!-- Loop para mostrar estrelas baseado na classificacao -->
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