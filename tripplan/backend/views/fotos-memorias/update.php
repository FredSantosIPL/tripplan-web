<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FotosMemorias $model */

$this->title = 'Update Fotos Memorias: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fotos Memorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fotos-memorias-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
