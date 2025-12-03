<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PlanoDestino $model */

$this->title = 'Create Plano Destino';
$this->params['breadcrumbs'][] = ['label' => 'Plano Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-destino-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
