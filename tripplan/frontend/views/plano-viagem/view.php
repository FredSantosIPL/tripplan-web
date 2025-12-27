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
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer apagar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>

<div class="destino-view">

    <div class="mt-4">
        <h3>Gerir Viagem</h3>
        <p>Adiciona detalhes ao teu plano:</p>

        <?= Html::a('Inserir Destino',
            ['destino/create', 'plano_viagem_id' => $model->id],
            ['class' => 'btn btn-success btn-lg shadow-sm']
        ) ?>

        <?= Html::a('Inserir Estadia',
            ['estadia/create', 'plano_viagem_id' => $model->id],
            ['class' => 'btn btn-primary btn-lg shadow-sm ms-2']
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
        

    <?php else: ?>
        <div class="alert alert-light border mt-4">
            Ainda não tens destinos nesta viagem. Clica no botão verde acima! 👆
        </div>
    <?php endif; ?>

</div>





