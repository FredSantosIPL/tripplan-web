<?php

use common\models\Destino;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DestinoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Destinos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-index">

    <!-- Card Container: Estilo consistente com o resto do Dashboard -->
    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="card-title m-0 text-success font-weight-bold">
                <i class="fas fa-map-marked-alt mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <?= Html::a('<i class="fas fa-plus"></i> Adicionar Destino', ['create'], ['class' => 'btn btn-success shadow-sm']) ?>
        </div>

        <!-- Corpo do Card com a Tabela -->
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-hover mb-0'],
                'layout' => "{items}\n<div class='p-3 d-flex justify-content-between align-items-center'>{summary}{pager}</div>",
                'columns' => [
                    

                    // Agente de Viagem (Podes adicionar lógica para mostrar o nome se tiveres a relação)
                    [
                        'attribute' => 'agente_viagem_id',
                        'label' => 'Agente ID',
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Cidade em Negrito
                    [
                        'attribute' => 'nome_cidade',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark"><i class="fas fa-city mr-1 text-muted"></i> ' . Html::encode($model->nome_cidade) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // País
                    [
                        'attribute' => 'pais',
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Data de Chegada Formatada
                    [
                        'attribute' => 'data_chegada',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Ações Personalizadas
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:160px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Destino $model, $key, $index, $column) {
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
                                    'data-confirm' => 'Tem a certeza que deseja apagar este destino?',
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