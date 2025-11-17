<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */

$this->title = 'Create Destino';
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
