<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\Destino $model */
?>

<div class="col-xl-3 col-lg-4 col-md-6 mb-4">
    <div class="card h-100 shadow-sm border-0 border-start border-4 border-primary hover-lift">

        <div class="card-body">
            <div class="mb-3">
                <span class="badge bg-light text-primary border">
                    <i class="far fa-calendar-alt me-1"></i>
                    <?= date('d/m/Y', strtotime($model->data_chegada)) ?>
                </span>
            </div>

            <h4 class="card-title fw-bold text-dark mb-1">
                <?= Html::encode($model->nome_cidade) ?>
            </h4>

            <p class="text-muted mb-0">
                <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                <?= Html::encode($model->pais) ?>
            </p>
        </div>

        <div class="card-footer bg-white border-0 pt-0 pb-3 d-flex justify-content-end ">



            <div class="btn-group">
                <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-light text-secondary',
                    'title' => 'Editar'
                ]) ?>
                <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-light text-danger',
                    'data' => [
                        'confirm' => 'Tens a certeza que queres apagar este destino?',
                        'method' => 'post',
                    ],
                    'title' => 'Apagar'
                ]) ?>
            </div>
        </div>
    </div>
</div>