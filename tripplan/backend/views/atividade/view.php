<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Atividade $model */

$this->title = $model->nome_atividade;
$this->params['breadcrumbs'][] = ['label' => 'Atividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="atividade-view">

    <!-- Cabeçalho com Botões de Ação -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0 text-info"><i class="fas fa-hiking mr-2"></i> <?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que deseja apagar esta atividade?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- Informações da Atividade -->
    <div class="card shadow-sm border-top-info">
        <div class="card-header bg-white">
            <h5 class="card-title m-0 font-weight-bold text-dark">Detalhes da Atividade</h5>
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

                    // Mostra o nome do Destino em vez do ID
                    [
                        'attribute' => 'destino_id',
                        'label' => 'Localização (Destino)',
                        'format' => 'raw',
                        'value' => isset($model->destino) ?
                            '<i class="fas fa-map-marker-alt text-danger mr-1"></i> ' . Html::encode($model->destino->nome_cidade) :
                            'ID: ' . $model->destino_id,
                    ],

                    // Tenta mostrar o Plano de Viagem associado (Atividade -> Destino -> Plano)
                    [
                        'label' => 'Plano de Viagem',
                        'visible' => isset($model->destino->planoViagem),
                        'value' => isset($model->destino->planoViagem) ? $model->destino->planoViagem->nome_viagem : '-',
                    ],

                    'nome_atividade',

                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return '<span class="badge badge-warning text-dark px-2 py-1">' . Html::encode($model->tipo) . '</span>';
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>