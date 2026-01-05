<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\DestinoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Os Meus Destinos';
?>

<div class="destino-index container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="display-5 fw-bold text-primary mb-0">
                <i class="fas me-2"></i>Meus Destinos
            </h1>
            <p class="text-muted lead">Gere aqui os locais da tua próxima aventura.</p>
        </div>

        
    </div>

    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_destino_card', // Chama o ficheiro que criámos acima
            'layout' => "{items}\n<div class='d-flex justify-content-center mt-4'>{pager}</div>",
            'itemOptions' => [
                'tag' => false, // Remove a div extra que o ListView cria
            ],
            'emptyText' => '
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="120" class="mb-3 opacity-50">
                    <h3 class="text-muted">Ainda não tens destinos!</h3>
                    <p>Começa por adicionar a primeira cidade da tua viagem.</p>
                </div>
            ',
        ]) ?>
    </div>

</div>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .hover-lift:hover img {
        transform: scale(1.05); /* Zoom suave na imagem */
    }
</style>