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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'plano_id',
            'destino_id',
        ],
    ]) ?>

</div>
