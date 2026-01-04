<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FotosMemorias $model */


$this->params['breadcrumbs'][] = ['label' => 'Fotos Memorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fotos-memorias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
