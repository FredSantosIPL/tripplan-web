<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */

$this->title = $model->nome_viagem;
$this->params['breadcrumbs'][] = ['label' => 'Plano Viagens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plano-viagem-view">

    <div class="trip-card shadow-sm">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-borderless'],
            'attributes' => [

                'nome_viagem',
                'data_inicio:date',
                'data_fim:date',
            ],
        ]) ?>

    </div>



    <div class="mt-5 mb-3">
        <h2>Gerir Viagem</h2>
        <p class="text-muted">Personaliza os detalhes do teu plano:</p>
    </div>

    <div class="trip-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="m-0">Destinos</h3>
            <?= Html::a('Inserir Destino',
                ['destino/create', 'plano_viagem_id' => $model->id],
                ['class' => 'btn btn-success rounded-pill']
            ) ?>
        </div>

        <?php if (isset($destinosProvider) && $destinosProvider->count > 0): ?>
            <?= GridView::widget([
                'dataProvider' => $destinosProvider,
                'summary' => '',
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    ['attribute' => 'nome_cidade', 'label' => 'Cidade'],
                    ['attribute' => 'pais', 'label' => 'País'],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'destino',
                        'template' => '{update} {delete}',
                        'header' => 'Ações',
                        'buttons' => [
                            'update' => function ($url) { return Html::a('✏️', $url, ['class' => 'btn-action']); },
                            'delete' => function ($url) { return Html::a('🗑️', $url, ['class' => 'btn-action text-danger', 'data-method' => 'post']); },
                        ],
                    ],
                ],
            ]); ?>
        <?php else: ?>
            <div class="alert alert-light border">Ainda não tens destinos. Clica no botão acima!</div>
        <?php endif; ?>
    </div>

    <div class="trip-card shadow-sm mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="m-0"> Estadias</h3>
            <?= Html::a('Inserir Estadia',
                ['estadia/create', 'plano_id' => $model->id],
                ['class' => 'btn btn-primary rounded-pill']
            ) ?>
        </div>



        <?php if (isset($estadiasProvider) && $estadiasProvider->count > 0): ?>
            <?= GridView::widget([
                'dataProvider' => $estadiasProvider,
                'summary' => '',
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    ['attribute' => 'nome_alojamento', 'label' => 'Alojamento'],
                    ['attribute' => 'data_checkin', 'label' => 'Check-in', 'format' => ['date', 'php:d/m/Y']],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'estadia',
                        'template' => '{update} {delete}',
                        'header' => 'Ações',
                        'buttons' => [
                            'update' => function ($url) { return Html::a('✏️', $url, ['class' => 'btn-action']); },
                            'delete' => function ($url) { return Html::a('🗑️', $url, ['class' => 'btn-action text-danger', 'data-method' => 'post']); },
                        ],
                    ],
                ],
            ]); ?>
        <?php else: ?>
            <div class="alert alert-light border">Nenhuma estadia registada.</div>
        <?php endif; ?>
    </div>

</div>







