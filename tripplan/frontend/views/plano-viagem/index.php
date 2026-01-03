
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

<!--    <div class="d-flex justify-content-between align-items-center mb-3 mt-3 ">-->
<!--        <h1 class="display-6 fw-bold text-dark">-->
<!--            --><?php //= Html::encode($this->title) ?>
<!--            <p>-->
<!--                --><?php //= Html::a('<i class="fas fa-plus"></i> Nova Viagem', ['create'], [
//                'class' => 'btn btn-primary btn-lg shadow-sm rounded-pill px-4'
//                ]) ?>
<!--            </p>-->
<!--        </h1>-->
<!--    </div>-->
    <div class="rounded shadow-sm p-4 mb-4 d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #007bff 0%, #00d2ff 100%); color: white;">

        <div>
            <h1 class="m-0" style="font-weight: 700; font-size: 2rem;">
                <i class="fas fa-plane-departure mr-2"></i> As minhas Viagens
            </h1>
            <p class="m-0 mt-1" style="opacity: 0.9;">Gere e organiza as tuas próximas aventuras.</p>
        </div>

        <?= \yii\helpers\Html::a('<i class="fas fa-plus"></i> Nova Viagem', ['create'], [
            'class' => 'btn btn-light text-primary font-weight-bold shadow-sm',
            'style' => 'border-radius: 20px; padding: 10px 20px;'
        ]) ?>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_viagem_card', // Criares uma view parcial para o desenho do cartão
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'row'], // Para usar a grid do Bootstrap
        'itemOptions' => ['class' => 'col-md-4 mb-4 mx-3'], // 3 cartões por linha

    ]); ?>



</div>
