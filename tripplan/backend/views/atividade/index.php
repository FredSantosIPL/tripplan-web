<?php

use common\models\Atividade;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\AtividadeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Atividades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atividade-index">

    <!-- Card Container -->
    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="card-title m-0 text-info font-weight-bold">
                <i class="fas fa-hiking mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <?= Html::a('<i class="fas fa-plus"></i> Adicionar Atividade', ['create'], ['class' => 'btn btn-success shadow-sm']) ?>
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

                    // Destino
                    [
                        'attribute' => 'destino_id',
                        'label' => 'Localização',
                        'value' => function ($model) {
                            // Tenta mostrar o nome da cidade, senão mostra o ID
                            return isset($model->destino) ? $model->destino->nome_cidade : 'Destino #' . $model->destino_id;
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Nome da Atividade (Destaque)
                    [
                        'attribute' => 'nome_atividade',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark"><i class="fas fa-ticket-alt text-muted mr-1"></i> ' . Html::encode($model->nome_atividade) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Tipo (Badge)
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'filter' => ['Cultura' => 'Cultura', 'Lazer' => 'Lazer', 'Desporto' => 'Desporto', 'Gastronomia' => 'Gastronomia'], // Exemplo de filtro
                        'value' => function($model) {
                            // Badge amarelo para atividades (warning)
                            return '<span class="badge badge-warning text-dark px-2 py-1">' . Html::encode($model->tipo) . '</span>';
                        },
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    ],

                    // Ações
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:160px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Atividade $model, $key, $index, $column) {
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
                                    'data-confirm' => 'Tem a certeza que deseja apagar esta atividade?',
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