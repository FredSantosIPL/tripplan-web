<?php

use common\models\PlanoDestino;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PlanoDestinoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Plano Destinos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-destino-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Plano Destino', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'plano_id',
            'destino_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PlanoDestino $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'plano_id' => $model->plano_id, 'destino_id' => $model->destino_id]);
                 }
            ],
        ],
    ]); ?>


</div>
