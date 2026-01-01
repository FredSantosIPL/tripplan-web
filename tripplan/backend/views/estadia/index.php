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

    <!-- Card Container -->
    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="card-title m-0 text-danger font-weight-bold">
                <i class="fas fa-hotel mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <?= Html::a('<i class="fas fa-plus"></i> Adicionar Estadia', ['create'], ['class' => 'btn btn-success shadow-sm']) ?>
        </div>

        <!-- Corpo do Card -->
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-hover mb-0'],
                'layout' => "{items}\n<div class='p-3 d-flex justify-content-between align-items-center'>{summary}{pager}</div>",
                'columns' => [
                    // ID Centrado
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width:80px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    ],

                    // Destino (Mostra nome da cidade se existir relação, senão ID)
                    [
                        'attribute' => 'destino_id',
                        'label' => 'Destino',
                        'value' => function ($model) {
                            return isset($model->destino) ? $model->destino->nome_cidade : 'ID: ' . $model->destino_id;
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Nome Alojamento em Negrito com ícone de cama
                    [
                        'attribute' => 'nome_alojamento',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark"><i class="fas fa-bed text-muted mr-1"></i> ' . Html::encode($model->nome_alojamento) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Tipo com Badge
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            // Exemplo: Hotel, Airbnb, Hostel
                            return '<span class="badge badge-info px-2 py-1">' . Html::encode($model->tipo) . '</span>';
                        },
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    ],

                    // Data Check-in formatada
                    [
                        'attribute' => 'data_checkin',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Ações com Ícones
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:160px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Estadia $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-info btn-sm text-white mr-1',
                                    'title' => 'Ver Detalhes',
                                    'data-toggle' => 'tooltip',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                    'class' => 'btn btn-primary btn-sm mr-1',
                                    'title' => 'Editar',
                                    'data-toggle' => 'tooltip',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Apagar',
                                    'data-confirm' => 'Tem a certeza que deseja apagar esta estadia?',
                                    'data-method' => 'post',
                                    'data-toggle' => 'tooltip',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>