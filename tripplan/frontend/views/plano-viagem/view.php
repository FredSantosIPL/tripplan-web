<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */

$this->title = $model->nome_viagem;
$this->params['breadcrumbs'][] = ['label' => 'Plano Viagens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plano-viagem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'nome_viagem',
            'data_inicio:date',
            'data_fim:date',
        ],
    ]) ?>

    <p>
        <?= Html::a('Editar Viagem', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar Viagem', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer apagar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>

<div class="destino-view">

    <div class="mt-4 d-flex gap-2">
        <h3>Gerir Viagem</h3>
        <p class="text-muted">Adiciona detalhes ao teu plano:</p>

        <?= Html::a('Inserir Destino',
            ['destino/create', 'plano_viagem_id' => $model->id],
            ['class' => 'btn btn-success ']
        ) ?>

        <?= Html::a('Inserir Estadia',
            ['estadia/create', 'plano_id' => $model->id],
            ['class' => 'btn btn-primary ']
        ) ?>



    </div>


    <?php if (isset($destinosProvider) && $destinosProvider->count > 0): ?>

        <h3 class="mt-5 border-bottom pb-2">Destino</h3>

        <?= GridView::widget([
            'dataProvider' => $destinosProvider,
            'summary' => '',
            'tableOptions' => ['class' => 'table table-hover shadow-sm bg-white rounded'],
            'columns' => [
                // Coluna 1: Nome da Cidade (como está na tua base de dados)
                [
                    'attribute' => 'nome_cidade',
                    'label' => 'Destino', // O título que aparece no topo da coluna
                ],

                // Coluna 2: País
                [
                    'attribute' => 'pais',
                    'label' => 'País',
                ],

                // Coluna 3: Botões (Apagar/Editar)
                [
                    'class' => 'yii\grid\ActionColumn',
                    'controller' => 'destino',
                    'template' => '{update} {delete}', // Botão de editar e apagar
                    'header' => 'Ações',
                ],
            ],
        ]); ?>



    <?php endif; ?>


    <?php if (isset($estadiasProvider) && $estadiasProvider->count > 0): ?>

        <h3 class="mt-5 border-bottom pb-2">Estadia</h3>

        <?= GridView::widget([
            'dataProvider' => $estadiasProvider,
            'summary' => '',
            'tableOptions' => ['class' => 'table table-hover shadow-sm bg-white rounded'],
            'columns' => [
                [
                    'attribute' => 'nome_alojamento', // Verifica se o nome no teu BD é este
                    'label' => 'Alojamento',
                ],
                [
                    'attribute' => 'data_checkin',
                    'label' => 'Check-in',
                    'format' => ['date', 'php:d/m/Y'],
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'controller' => 'estadia', // Garante que tens um EstadiaController
                    'template' => '{update} {delete}',
                    'header' => 'Ações',
                ],
            ],
        ]); ?>


    <?php endif; ?>

</div>





