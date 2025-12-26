<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Meus Favoritos';
?>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Minha Lista</h6>
            <h1>Meus Favoritos</h1>
        </div>

        <div class="row">
            <?php if ($dataProvider->count > 0): ?>
                <?php foreach ($dataProvider->getModels() as $favorito): ?>
                <?php $destino = $favorito->destino; ?>
            <div class="destination-item position-relative overflow-hidden mb-2">
                <!-- Imagem do Destino (Placeholder se não houver) -->
                <img class="img-fluid" src="img/destination-1.jpg" alt="" style="width: 100%; height: 200px; object-fit: cover;">

                <div class="destination-overlay text-white text-decoration-none">
                    <a class="text-white text-decoration-none" href="<?= Url::to(['destino/view', 'id' => $destino->id]) ?>">
                        <h5 class="text-white"><?= Html::encode($destino->nome_cidade) ?></h5>
                        <span><?= Html::encode($destino->pais) ?></span>
                    </a>

                    <!-- Botão para Remover dos Favoritos -->
                    <div class="mt-2">
                        <?= Html::a('<i class="fa fa-heart-broken"></i> Remover',
                            ['favorito/toggle', 'destino_id' => $destino->id],
                            [
                                'class' => 'btn btn-sm btn-danger',
                                'data-method' => 'post'
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="lead">Ainda não tens favoritos.</p>
                <a href="<?= Url::to(['destino/index']) ?>" class="btn btn-primary">Explorar Destinos</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-12">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
    </div>
</div>

