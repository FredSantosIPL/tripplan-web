<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */


$this->params['breadcrumbs'][] = ['label' => 'Plano Viagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plano-viagem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
