<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PlanoDestino $model */

$this->title = 'Update Plano Destino: ' . $model->plano_id;
$this->params['breadcrumbs'][] = ['label' => 'Plano Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->plano_id, 'url' => ['view', 'plano_id' => $model->plano_id, 'destino_id' => $model->destino_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plano-destino-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
