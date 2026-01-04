<?php

use common\models\Estadia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\EstadiaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estadias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadia-index">

    <div class="row mb-3">
        <div class="col-md-8">
            <h1 class="text-primary"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted">Lista dos alojamentos reservados para as tuas viagens.</p>
        </div>
<!--        <div class="col-md-4 text-right d-flex align-items-center justify-content-end">-->
<!--            --><?php //= Html::a('Criar Estadia', ['create'], ['class' => 'btn btn-success shadow-sm btn-lg']) ?>
<!--        </div>-->
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
                    // Coluna Nome Alojamento (Destaque em Negrito)
                    [
                        'attribute' => 'nome_alojamento',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark">' . Html::encode($model->nome_alojamento) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Coluna Tipo (Com Badge para destacar visualmente sem ícone)
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // Exemplo: Hotel, Hostel, Airbnb
                            return '<span class="badge badge-info px-2 py-1">' . Html::encode($model->tipo) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Data Check-in
                    [
                        'attribute' => 'data_checkin',
                        'label' => 'Check-in',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['class' => 'text-muted', 'style' => 'vertical-align:middle;'],
                    ],

                    // Ações (Botões apenas com Texto, sem ícones)
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:200px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Estadia $model, $key, $index, $column) {
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