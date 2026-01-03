<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Estadia $model */


$this->params['breadcrumbs'][] = ['label' => 'Estadias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estadia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
