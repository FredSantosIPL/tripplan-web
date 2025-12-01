<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="destino-view">

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
                    'nome_cidade',
                    'pais',
                    'data_chegada:date',
                ],
            ]) ?>
        </div>
    </div>

    <br>

    <!-- SECÇÃO: ESTADIAS -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-hotel"></i> Estadias</h3>
            <div class="card-tools">
                <!-- Link para criar nova estadia -->
                <?= Html::a('<i class="fas fa-plus"></i> Adicionar', ['estadia/create'], ['class' => 'btn btn-tool']) ?>
            </div>
        </div>
        <div class="card-body p-0">
            <?php
            // Cria um DataProvider com as estadias deste destino
            $estadiaProvider = new ArrayDataProvider([
                'allModels' => $model->estadias, // Usa a relação definida no Model (hasMany)
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $estadiaProvider,
                'layout' => "{items}\n{pager}", // Remove o sumário para ficar mais limpo
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nome_alojamento',
                    'tipo',
                    'data_checkin:date',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'estadia', // Aponta os botões para o controller correto
                        'template' => '{view} {update}', // Mostra apenas ver e editar
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <!-- SECÇÃO: ATIVIDADES -->
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-hiking"></i> Atividades</h3>
            <div class="card-tools">
                <?= Html::a('<i class="fas fa-plus"></i> Adicionar', ['atividade/create'], ['class' => 'btn btn-tool']) ?>
            </div>
        </div>
        <div class="card-body p-0">
            <?php
            $atividadeProvider = new ArrayDataProvider([
                'allModels' => $model->atividades,
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $atividadeProvider,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nome_atividade',
                    'tipo',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'atividade',
                        'template' => '{view} {update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <br>

    <!-- SECÇÃO: DESPESAS -->
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-euro-sign"></i> Despesas</h3>
            <div class="card-tools">
                <?= Html::a('<i class="fas fa-plus"></i> Adicionar', ['despesa/create'], ['class' => 'btn btn-tool']) ?>
            </div>
        </div>
        <div class="card-body p-0">
            <?php
            $despesaProvider = new ArrayDataProvider([
                'allModels' => $model->despesas,
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $despesaProvider,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'descricao',
                    [
                        'attribute' => 'valor',
                        'format' => ['currency', 'EUR'], // Formata como dinheiro
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'despesa',
                        'template' => '{view} {update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>


</div>
