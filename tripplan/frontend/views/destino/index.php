<?php

use common\models\Destino;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DestinoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Destinos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p></p>
    <p></p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'layout' => "{items}\n<div class='p-3'>{pager}</div>",

        'tableOptions' => [
            'class' => 'table table-hover table-striped mb-0',
        ],

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'nome_cidade',
            'pais',
            'data_chegada:date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Destino $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },


            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Insere o Destino', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


</div>
