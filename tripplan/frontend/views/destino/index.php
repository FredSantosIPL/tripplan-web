<?php

use common\models\Destino;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DestinoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Os Meus Destinos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-index">

    <div class="row mb-3">
        <div class="col-md-8">
            <h1 class="text-primary"><i class="fas mr-2"></i> <?= Html::encode($this->title) ?></h1>
            <p class="text-muted">Gere aqui os locais que vais visitar nas tuas viagens.</p>
        </div>
        <div class="col-md-4 text-right d-flex align-items-center justify-content-end pr-5">
            <?= Html::a('<i class="fas fa-plus"></i> Inserir Novo Destino', ['create'], ['class' => 'btn btn-success shadow-sm btn-lg']) ?>
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
                    // Coluna Cidade
                    [
                        'attribute' => 'nome_cidade',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark"><i class="fas text-primary mr-2"></i>' . Html::encode($model->nome_cidade) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Coluna País
                    [
                        'attribute' => 'pais',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<i class="fas text-muted mr-1"></i> ' . Html::encode($model->pais);
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Data Chegada
                    [
                        'attribute' => 'data_chegada',
                        'label' => 'Chegada',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['class' => 'text-muted', 'style' => 'vertical-align:middle;'],
                    ],

                    // Ações
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:150px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, Destino $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-outline-info btn-sm mr-1',
                                    'title' => 'Ver',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                    'class' => 'btn btn-outline-primary btn-sm mr-1',
                                    'title' => 'Editar',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-outline-danger btn-sm',
                                    'title' => 'Apagar',
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