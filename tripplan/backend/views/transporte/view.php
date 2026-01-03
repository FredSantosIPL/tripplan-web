<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Transporte $model */

$this->title = 'Transporte #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transportes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transporte-view">

    <!-- Cabeçalho com Botões de Ação -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0 text-primary"><i class="fas fa-bus mr-2"></i> <?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que deseja apagar este transporte?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- Informações do Transporte -->
    <div class="card shadow-sm border-top-primary">
        <div class="card-header bg-white">
            <h5 class="card-title m-0 font-weight-bold text-dark">Detalhes da Deslocação</h5>
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

                    // Mostra o nome do Plano de Viagem
                    [
                        'label' => 'Plano de Viagem',
                        'format' => 'raw',
                        'value' => isset($model->planoViagem) ?
                            Html::a($model->planoViagem->nome_viagem, ['/plano-viagem/view', 'id' => $model->plano_viagem_id]) :
                            'ID: ' . $model->plano_viagem_id,
                    ],

                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return '<span class="badge badge-primary px-2 py-1">' . Html::encode(ucfirst($model->tipo)) . '</span>';
                        }
                    ],

                    [
                        'attribute' => 'origem',
                        'format' => 'raw',
                        'value' => '<i class="fas fa-map-marker-alt text-danger mr-1"></i> ' . Html::encode($model->origem),
                    ],
                    [
                        'attribute' => 'destino',
                        'format' => 'raw',
                        'value' => '<i class="fas fa-flag-checkered text-success mr-1"></i> ' . Html::encode($model->destino),
                    ],

                    [
                        'attribute' => 'data_partida',
                        'format' => ['datetime', 'php:d/m/Y H:i'],
                        'label' => 'Data/Hora de Partida'
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>