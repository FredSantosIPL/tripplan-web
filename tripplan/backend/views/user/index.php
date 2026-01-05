<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use Yii;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizadores'; // Traduzi para PT
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!-- Card Container: Estilo Dashboard Profissional -->
    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="card-title m-0 text-primary font-weight-bold">
                <i class="fas fa-users mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <?= Html::a('<i class="fas fa-user-plus"></i> Criar Utilizador', ['create'], ['class' => 'btn btn-success shadow-sm']) ?>
        </div>

        <!-- Corpo do Card com a Tabela -->
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-hover mb-0'], // Estilo Zebra e Hover
                'layout' => "{items}\n<div class='p-3 d-flex justify-content-between align-items-center'>{summary}{pager}</div>",
                'columns' => [

                    // Username em Negrito
                    [
                        'attribute' => 'username',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="font-weight-bold text-dark">' . Html::encode($model->username) . '</span>';
                        },
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Email com Ícone
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'label' => 'Email',
                        'contentOptions' => ['style' => 'vertical-align:middle;'],
                    ],

                    // Coluna Status com Badge Colorido (Visual muito melhor)
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => [10 => 'Ativo', 9 => 'Inativo'], // Filtro dropdown
                        'value' => function($model) {
                            if ($model->status == 10) {
                                return '<span class="badge badge-success px-2 py-1">Ativo</span>';
                            } else {
                                return '<span class="badge badge-secondary px-2 py-1">Inativo</span>';
                            }
                        },
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    ],

                    // Ações Personalizadas
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Ações',
                        'headerOptions' => ['style' => 'width:180px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'template' => '{view} {update} {desativar} {promote}',

                        'urlCreator' => function ($action, User $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },

                        'buttons' => [
                            // Botão Ver
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-info btn-sm text-white mr-1',
                                    'title' => 'Ver Detalhes',
                                    'data-toggle' => 'tooltip',
                                ]);
                            },
                            // Botão Editar
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                    'class' => 'btn btn-primary btn-sm mr-1',
                                    'title' => 'Editar',
                                    'data-toggle' => 'tooltip',
                                ]);
                            },
                            // Botão Apagar
//                            'delete' => function ($url, $model) {
//                                return Html::a('<i class="fas fa-trash"></i>', $url, [
//                                    'class' => 'btn btn-danger btn-sm mr-1',
//                                    'title' => 'Apagar',
//                                    'data-confirm' => 'Tem a certeza que deseja apagar este utilizador?',
//                                    'data-method' => 'post',
//                                    'data-toggle' => 'tooltip',
//                                ]);
//                            },
                            'desativar' => function ($url, $model) {
                                // Cria a rota para a ação 'desativar' com o ID do utilizador
                                $url = \yii\helpers\Url::to(['desativar', 'id' => $model->id]);

                                // Cria o botão amarelo (btn-warning) com o ícone de bloqueio (fa-ban)
                                return Html::a('<i class="fas fa-ban"></i>', $url, [
                                    'class' => 'btn btn-warning btn-sm mr-1',
                                    'title' => 'Desativar',
                                    'aria-label' => 'Desativar',
                                    // Adiciona a mensagem de confirmação
                                    'data-confirm' => 'Tem a certeza que deseja desativar este utilizador?',
                                    // Garante que o pedido é feito via POST para segurança
                                    'data-method' => 'post',
                                    'data-toggle' => 'tooltip',
                                ]);
                            },
                            // Botão PROMOVER (A tua lógica personalizada)
                            'promote' => function ($url, $model, $key) {
                                $auth = Yii::$app->authManager;
                                $isAgent = $auth->getAssignment('agente', $model->id);
                                $isAdmin = $auth->getAssignment('admin', $model->id);

                                if ($isAgent || $isAdmin) {
                                    return ''; // Não mostra nada se já tiver cargo
                                }

                                return Html::a('<i class="fas fa-briefcase"></i>', ['promote', 'id' => $model->id], [
                                    'class' => 'btn btn-warning btn-sm text-dark', // Mudei para amarelo (warning) para destacar
                                    'title' => 'Promover a Agente',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => 'Promover este utilizador a Agente?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>