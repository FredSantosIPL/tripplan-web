<?php

use common\models\Transporte;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\TransporteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Transportes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transporte-index">

    <div class="row mb-3">
        <div class="col-md-8">
            <h1 class="text-primary"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted">Gestão das deslocações (voos, comboios, autocarros) das tuas viagens.</p>
        </div>
        <div class="col-md-4 text-right d-flex align-items-center justify-content-end">
            <?= Html::a('Criar Transporte', ['create'], ['class' => 'btn btn-success shadow-sm btn-lg']) ?>
        </div>
    </div>

    <!-- Card Container -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n<div class='p-3 d-flex justify-content-center'>{pager}</div>",
                'tableOptions' => ['class' => 'table table-hover table-striped mb-0'],
                'columns' => [
                    // Coluna Tipo (Destaque em Negrito)
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark">' . Html::encode(ucfirst($model->tipo)) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Origem
                    [
                        'attribute' => 'origem',
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Destino
                    [
                        'attribute' => 'destino',
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Data Partida
                    [
                        'attribute' => 'data_partida',
                        'label' => 'Partida',
                        'format' => ['date', 'php:d/m/Y H:i'],
                        'contentOptions' => ['class' => 'text-muted', 'style' => 'vertical-align:middle;'],
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:200px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Transporte $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('Ver', $url, [
                                    'class' => 'btn btn-outline-info btn-sm mr-1',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('Editar', $url, [
                                    'class' => 'btn btn-outline-primary btn-sm mr-1',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('Apagar', $url, [
                                    'class' => 'btn btn-outline-danger btn-sm',
                                    'data-confirm' => 'Tens a certeza?',
                                    'data-method' => 'post',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>