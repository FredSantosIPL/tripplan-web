<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */

$this->title = $model->nome_viagem;
$this->params['breadcrumbs'][] = ['label' => 'Planos de Viagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plano-viagem-view">

    <!-- Cabeçalho com Título e Botões de Ação Principais -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0 text-primary"><i class="fas fa-map-marked-alt mr-2"></i> <?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que deseja apagar este plano e todos os seus detalhes?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- ROW 1: Detalhes Principais da Viagem -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4 border-top-primary">
                <div class="card-header bg-white">
                    <h5 class="card-title m-0 font-weight-bold text-dark">Informações Gerais</h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-bordered detail-view mb-0'],
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'label' => 'ID do Plano',
                            ],
                            // Tenta mostrar o nome do user em vez do ID
                            [
                                'attribute' => 'user_id',
                                'value' => $model->user->username ?? 'Desconhecido (ID: ' . $model->user_id . ')',
                                'label' => 'Criado por',
                            ],
                            'nome_viagem',
                            [
                                'attribute' => 'data_inicio',
                                'format' => ['date', 'php:d/m/Y'],
                            ],
                            [
                                'attribute' => 'data_fim',
                                'format' => ['date', 'php:d/m/Y'],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: Destinos e Atividades (Novas Secções) -->
    <div class="row">

        <!-- COLUNA ESQUERDA: Destinos -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm card-outline card-success h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 text-success"><i class="fas fa-map-pin"></i> Destinos / Alojamento</h5>
                    <?= Html::a('<i class="fas fa-plus"></i> Adicionar',
                        ['destino/create', 'plano_viagem_id' => $model->id],
                        ['class' => 'btn btn-sm btn-success shadow-sm']
                    ) ?>
                </div>
                <div class="card-body p-0">
                    <?php
                    $destinosProvider = new ArrayDataProvider([
                        'allModels' => $model->destinos ?? [],
                        'pagination' => ['pageSize' => 5],
                    ]);
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $destinosProvider,
                        'layout' => "{items}\n<div class='p-2 text-center'>{pager}</div>",
                        'emptyText' => '<div class="p-3 text-muted text-center">Sem destinos definidos.</div>',
                        'tableOptions' => ['class' => 'table table-sm table-striped mb-0'],
                        'columns' => [
                            'nome_cidade',
                            'pais',
                            'data_chegada:date',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Ações',
                                'template' => '{view} {update} {delete}', // Adicionei update
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'text-info mr-1']);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'text-primary mr-1']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                            'class' => 'text-danger',
                                            'data-confirm' => 'Apagar este destino?',
                                            'data-method' => 'post',
                                        ]);
                                    },
                                ],
                                // CORREÇÃO: Forçar a rota absoluta para /destino/...
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    return Url::to(['/destino/' . $action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

        <!-- COLUNA DIREITA: Atividades -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm card-outline card-primary h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 text-primary"><i class="fas fa-hiking"></i> Atividades</h5>
                    <?= Html::a('<i class="fas fa-plus"></i> Adicionar',
                        ['atividade/create', 'plano_viagem_id' => $model->id],
                        ['class' => 'btn btn-sm btn-primary shadow-sm']
                    ) ?>
                </div>
                <div class="card-body p-0">
                    <?php
                    $atividadesProvider = new ArrayDataProvider([
                        'allModels' => $model->atividades ?? [],
                        'pagination' => ['pageSize' => 5],
                    ]);
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $atividadesProvider,
                        'layout' => "{items}\n<div class='p-2 text-center'>{pager}</div>",
                        'emptyText' => '<div class="p-3 text-muted text-center">Sem atividades planeadas.</div>',
                        'tableOptions' => ['class' => 'table table-sm table-striped mb-0'],
                        'columns' => [
                            'nome_atividade',
                            'tipo',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Ações',
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'text-info mr-1']);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'text-primary mr-1']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                            'class' => 'text-danger',
                                            'data-confirm' => 'Apagar esta atividade?',
                                            'data-method' => 'post',
                                        ]);
                                    },
                                ],
                                // CORREÇÃO: Forçar a rota absoluta para /atividade/...
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    return Url::to(['/atividade/' . $action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3: Transportes -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm card-outline card-info">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 text-info"><i class="fas fa-plane"></i> Transportes / Deslocações</h5>
                    <?= Html::a('<i class="fas fa-plus"></i> Adicionar Transporte',
                        ['transporte/create', 'plano_viagem_id' => $model->id],
                        ['class' => 'btn btn-sm btn-info shadow-sm']
                    ) ?>
                </div>
                <div class="card-body p-0">
                    <?php
                    $transporteProvider = new ArrayDataProvider([
                        'allModels' => $model->transportes ?? [],
                        'pagination' => ['pageSize' => 5],
                        'sort' => [
                            'attributes' => ['data_partida', 'tipo'],
                        ],
                    ]);
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $transporteProvider,
                        'layout' => "{items}\n<div class='p-3'>{pager}</div>",
                        'emptyText' => '<div class="p-3 text-muted text-center">Nenhum transporte associado a esta viagem.</div>',
                        'tableOptions' => ['class' => 'table table-striped table-hover mb-0'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'tipo',
                                'value' => function($data) {
                                    return ucfirst($data->tipo);
                                }
                            ],
                            'origem',
                            'destino',
                            [
                                'attribute' => 'data_partida',
                                'format' => ['datetime', 'php:d/m/Y H:i'],
                                'label' => 'Partida'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Ações',
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'text-info mr-2']);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'text-primary mr-2']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                            'class' => 'text-danger',
                                            'data-confirm' => 'Apagar este transporte?',
                                            'data-method' => 'post',
                                        ]);
                                    },
                                ],
                                // CORREÇÃO: Forçar a rota absoluta para /transporte/...
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    return Url::to(['/transporte/' . $action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 4: Fotos e Memórias -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm card-outline card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 text-warning"><i class="fas fa-camera-retro"></i> Fotos e Memórias</h5>
                    <?= Html::a('<i class="fas fa-plus"></i> Adicionar Foto',
                        ['fotos-memorias/create', 'plano_viagem_id' => $model->id],
                        ['class' => 'btn btn-sm btn-warning shadow-sm text-white']
                    ) ?>
                </div>
                <div class="card-body p-0">
                    <?php
                    $fotosProvider = new ArrayDataProvider([
                        'allModels' => $model->fotosMemorias ?? [],
                        'pagination' => ['pageSize' => 5],
                    ]);
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $fotosProvider,
                        'layout' => "{items}\n<div class='p-3'>{pager}</div>",
                        'emptyText' => '<div class="p-3 text-muted text-center">Nenhuma memória registada nesta viagem.</div>',
                        'tableOptions' => ['class' => 'table table-striped table-hover mb-0'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // COLUNA 1: FOTO (Miniatura)
                            [
                                'label' => 'Foto',
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'width:120px;'],
                                'value' => function($data) {
                                    if ($data->foto && file_exists(Yii::getAlias('@frontend/web/') . $data->foto)) {
                                        return Html::img(Url::to('../../frontend/web/') . $data->foto, [
                                            'width' => '100px',
                                            'class' => 'img-thumbnail rounded'
                                        ]);
                                    }
                                    return '<span class="text-muted small">Sem imagem</span>';
                                }
                            ],

                            // COLUNA 2: Comentário
                            [
                                'attribute' => 'comentario',
                                'label' => 'Memória / Comentário',
                                'contentOptions' => ['style' => 'vertical-align:middle;'],
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Ações',
                                'template' => '{view} {update} {delete}',
                                'contentOptions' => ['style' => 'vertical-align:middle;'],
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'text-info mr-2']);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'text-primary mr-2']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                            'class' => 'text-danger',
                                            'data-confirm' => 'Apagar esta foto?',
                                            'data-method' => 'post',
                                        ]);
                                    },
                                ],
                                // CORREÇÃO: Forçar a rota absoluta para /fotos-memorias/...
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    return Url::to(['/fotos-memorias/' . $action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>