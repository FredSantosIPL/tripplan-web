<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PlanoDestino $model */

$this->title = $model->plano_id;
$this->params['breadcrumbs'][] = ['label' => 'Plano Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plano-destino-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'plano_id' => $model->plano_id, 'destino_id' => $model->destino_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'plano_id' => $model->plano_id, 'destino_id' => $model->destino_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // Mostra os nomes em vez de apenas os IDs
                    [
                        'attribute' => 'plano_id',
                        'label' => 'Plano de Viagem',
                        'value' => $model->plano->nome_viagem ?? $model->plano_id,
                    ],
                    [
                        'attribute' => 'destino_id',
                        'label' => 'Destino',
                        'value' => $model->destino->nome_cidade ?? $model->destino_id,
                    ],
                    [
                        'label' => 'País',
                        'value' => $model->destino->pais ?? 'N/A',
                    ],
                    [
                        'label' => 'Data Chegada Prevista',
                        'value' => $model->destino->data_chegada ?? 'N/A',
                        'format' => 'date',
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
