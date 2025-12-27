<?php

use common\models\PlanoViagem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;


/** @var yii\web\View $this */
/** @var common\models\PlanoViagemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'As minhas Viagens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-viagem-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    --><?php //= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//
//        'layout' => "{items}\n<div class='p-3'>{pager}</div>", //remover a frase Showwing...
//
//        'columns' => [
//            //['class' => 'yii\grid\SerialColumn'],
//
//            'nome_viagem',
//            'data_inicio:date',
//            'data_fim:date',
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, PlanoViagem $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                 }
//            ],
//        ],
//    ]); ?>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-3 ">
        <h1 class="display-6 fw-bold text-dark">
            <?= Html::encode($this->title) ?>
            <p>
                <?= Html::a('<i class="fas fa-plus"></i> Nova Viagem', ['create'], [
                'class' => 'btn btn-primary btn-lg shadow-sm rounded-pill px-4'
                ]) ?>
            </p>
        </h1>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_viagem_card', // Criares uma view parcial para o desenho do cartão
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'row'], // Para usar a grid do Bootstrap
        'itemOptions' => ['class' => 'col-md-4 mb-4 mx-3'], // 3 cartões por linha
    ]); ?>


</div>
