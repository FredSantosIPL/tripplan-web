<?php

use common\models\PlanoViagem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Planos de Viagem'; // Corrigi "Viagems" para "Viagem"
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-viagem-index">

    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="card-title m-0 text-primary font-weight-bold">
                <i class="fas fa-plane-departure mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <?= Html::a('<i class="fas fa-plus-circle"></i> Criar Novo Plano', ['create'], ['class' => 'btn btn-success shadow-sm']) ?>
        </div>

        <!-- Corpo do Card com a Tabela -->
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-hover mb-0'], // Estilo Zebra e Hover
                'layout' => "{items}\n<div class='p-3 d-flex justify-content-between align-items-center'>{summary}{pager}</div>",
                'columns' => [

                    // Coluna User (Tenta mostrar o nome se a relação existir, senão mostra o ID)
                    [
                        'attribute' => 'user_id',
                        'label' => 'Utilizador',
                        'value' => function ($model) {
                            return $model->user ? $model->user->username : 'ID: ' . $model->user_id;
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Nome da Viagem em Negrito
                    [
                        'attribute' => 'nome_viagem',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark">' . Html::encode($model->nome_viagem) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Datas formatadas (d/m/Y)
                    [
                        'attribute' => 'data_inicio',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],
                    [
                        'attribute' => 'data_fim',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Botões de Ação Personalizados
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:160px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'urlCreator' => function ($action, PlanoViagem $model, $key, $index, $column) {
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
                                    'data-confirm' => 'Tem a certeza que deseja apagar este plano?',
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