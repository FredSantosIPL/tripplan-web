<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Estadia $model */

$this->title = 'Create Estadia';
$this->params['breadcrumbs'][] = ['label' => 'Estadias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
