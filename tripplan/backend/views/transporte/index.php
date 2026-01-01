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

    <!-- Card Container -->
    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <!-- Título com ícone de autocarro/transporte -->
            <h4 class="card-title m-0 text-primary font-weight-bold">
                <i class="fas fa-bus mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <?= Html::a('<i class="fas fa-plus"></i> Adicionar Transporte', ['create'], ['class' => 'btn btn-success shadow-sm']) ?>
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

                    // Plano de Viagem Associado
                    [
                        'attribute' => 'plano_viagem_id',
                        'label' => 'Viagem',
                        'value' => function ($model) {
                            // Tenta mostrar o nome da viagem, senão mostra o ID
                            // Nota: Confirma se tens a relação getPlanoViagem() no modelo Transporte
                            return isset($model->planoViagem) ? $model->planoViagem->nome_viagem : 'ID: ' . $model->plano_viagem_id;
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Tipo de Transporte com Badge
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'filter' => ['Avião' => 'Avião', 'Comboio' => 'Comboio', 'Autocarro' => 'Autocarro', 'Carro' => 'Carro'],
                        'value' => function($model) {
                            // Badge azul para transportes
                            return '<span class="badge badge-primary px-2 py-1">' . Html::encode(ucfirst($model->tipo)) . '</span>';
                        },
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
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

                    // Data de Partida (Descomentei e formatei)
                    [
                        'attribute' => 'data_partida',
                        'format' => ['datetime', 'php:d/m/Y H:i'],
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Ações
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:160px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Transporte $model, $key, $index, $column) {
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
                                    'data-confirm' => 'Tem a certeza que deseja apagar este transporte?',
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