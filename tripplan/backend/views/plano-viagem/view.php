<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plano Viagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plano-viagem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    // Mostra o nome do user em vez do ID
                    [
                        'attribute' => 'utilizador_id',
                        'value' => $model->utilizador->username ?? 'Desconhecido',
                        'label' => 'Criado por',
                    ],
                    'nome_viagem',
                    'data_inicio:date',
                    'data_fim:date',
                ],
            ]) ?>
        </div>
    </div>

    <br>

    <!-- SECÇÃO: TRANSPORTES -->
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plane"></i> Transportes / Deslocações</h3>
            <div class="card-tools">
                <?= Html::a('<i class="fas fa-plus"></i> Adicionar Transporte', ['transporte/create'], ['class' => 'btn btn-tool']) ?>
            </div>
        </div>
        <div class="card-body p-0">
            <?php
            // O Gii deve ter gerado a relação getTransportes() no modelo PlanoViagem
            // Se der erro, verifique common/models/PlanoViagem.php
            $transporteProvider = new ArrayDataProvider([
                'allModels' => $model->transportes ?? [],
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $transporteProvider,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'tipo',
                    'origem',
                    'destino',
                    'data_partida:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'transporte',
                        'template' => '{view} {update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
