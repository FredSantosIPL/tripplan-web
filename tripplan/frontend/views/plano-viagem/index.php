<?php

use common\models\PlanoViagem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var common\models\PlanoViagemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Planear a  sua Viagem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-viagem-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'layout' => "{items}\n<div class='p-3'>{pager}</div>", //remover a frase Showwing...

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'nome_viagem',
            'data_inicio:date',
            'data_fim:date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PlanoViagem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Criar Plano da Viagem', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
