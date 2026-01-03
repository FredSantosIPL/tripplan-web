<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */

$this->title = $model->nome_cidade; // Fica melhor o nome da cidade que o ID
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="destino-view">

    <!-- Cabeçalho com Botões de Ação -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0 text-success"><i class="fas fa-map-marker-alt mr-2"></i> <?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que deseja apagar este destino?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- Informações do Destino -->
    <div class="card shadow-sm mb-4 border-top-success">
        <div class="card-header bg-white">
            <h5 class="card-title m-0 font-weight-bold text-dark">Informações do Destino</h5>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-bordered detail-view mb-0'],
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'contentOptions' => ['style' => 'width: 100px; text-align: center;'],
                    ],
                    [
                        'label' => 'Plano de Viagem',
                        'value' => isset($model->planoViagem) ? $model->planoViagem->nome_viagem : 'N/A',
                        'visible' => isset($model->planoViagem),
                    ],
                    'nome_cidade',
                    'pais',
                    'data_chegada:date',
                    'data_partida:date', // Adicionei caso exista no modelo
                    'descricao:ntext',   // Adicionei caso exista no modelo
                ],
            ]) ?>
        </div>
    </div>

    <!-- SECÇÃO: ESTADIAS (Única secção mantida) -->
    <div class="card shadow-sm card-outline card-danger">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="card-title m-0 text-danger"><i class="fas fa-hotel"></i> Estadias / Alojamento</h5>
            <div class="card-tools">
                <!-- Link inteligente: Envia o destino_id para a criação da estadia -->
                <?= Html::a('<i class="fas fa-plus"></i> Adicionar Estadia',
                    ['estadia/create', 'destino_id' => $model->id],
                    ['class' => 'btn btn-sm btn-danger shadow-sm']
                ) ?>
            </div>
        </div>
        <div class="card-body p-0">
            <?php
            // Cria um DataProvider com as estadias deste destino
            $estadiaProvider = new ArrayDataProvider([
                'allModels' => $model->estadias ?? [], // Usa a relação definida no Model
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $estadiaProvider,
                'layout' => "{items}\n<div class='p-3'>{pager}</div>",
                'emptyText' => '<div class="p-3 text-muted text-center">Nenhuma estadia registada neste destino.</div>',
                'tableOptions' => ['class' => 'table table-striped table-hover mb-0'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'nome_alojamento',
                        'format' => 'raw',
                        'value' => function($model) {
                            return '<span class="font-weight-bold">' . Html::encode($model->nome_alojamento) . '</span>';
                        }
                    ],
                    [
                        'attribute' => 'tipo',
                        'value' => function($model) {
                            return ucfirst($model->tipo);
                        }
                    ],
                    'data_checkin:date',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Ações',
                        'controller' => 'estadia', // Aponta para o EstadiaController
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
                                    'data-confirm' => 'Apagar esta estadia?',
                                    'data-method' => 'post',
                                ]);
                            },
                        ],
                        // Força a rota correta para estadia
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return Url::to(['/estadia/' . $action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>