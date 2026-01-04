<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Meus Favoritos';
?>
<div class="container-fluid py-5">
    <div class="container py-5">

        <!-- Cabeçalho da Secção -->
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Minha Lista</h6>
            <h1 class="text-dark font-weight-bold">Destinos Favoritos <i class="fas text-danger"></i></h1>
        </div>

        <div class="row">
            <?php if ($dataProvider->count > 0): ?>
                <?php foreach ($dataProvider->getModels() as $favorito): ?>
                    <?php $destino = $favorito->destino; ?>

                    <?php if ($destino): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <!-- Cartão Estilo Moderno sem Imagem de Fundo -->
                            <div class="card shadow-sm border-0 h-100 hover-card">

                                <!-- Parte Superior: Ícone representativo em vez de foto -->
                                <div class="card-header bg-light text-center py-4 border-0">
                                    <div class="d-inline-block rounded-circle bg-white p-3 shadow-sm text-primary">
                                        <i class="fas fa-map-marked-alt fa-3x"></i>
                                    </div>
                                </div>

                                <div class="card-body text-center">
                                    <h4 class="card-title font-weight-bold mb-2">
                                        <?= Html::encode($destino->nome_cidade) ?>
                                    </h4>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-flag mr-1"></i> <?= Html::encode($destino->pais) ?>
                                    </p>
                                </div>

                                <div class="card-footer bg-white border-0 text-center pb-4">
                                    <div class="btn-group">
                                        <a href="<?= Url::to(['destino/view', 'id' => $destino->id]) ?>" class="btn btn-outline-primary rounded-pill mr-2 px-3">
                                            Ver Detalhes
                                        </a>

                                        <?= Html::a('<i class="fas fa-trash-alt"></i>',
                                            ['favorito/toggle', 'destino_id' => $destino->id],
                                            [
                                                'class' => 'btn btn-outline-danger rounded-circle',
                                                'data-method' => 'post',
                                                'title' => 'Remover dos favoritos',
                                                'data-toggle' => 'tooltip'
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="far fa-heart fa-4x text-muted opacity-25"></i>
                    </div>
                    <h3 class="text-muted">Ainda não tens destinos favoritos.</h3>
                    <p class="mb-4">Explora os destinos disponíveis e guarda os teus preferidos aqui!</p>
                    <a href="<?= Url::to(['destino/index']) ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="fas fa-globe mr-2"></i> Explorar Destinos
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'pagination justify-content-center'],
                    'pageCssClass' => 'page-item',
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['class' => 'page-link']
                ]) ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Extra para animação ao passar o rato */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px); /* Cartão sobe ligeiramente */
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .opacity-25 { opacity: 0.25; }
</style>