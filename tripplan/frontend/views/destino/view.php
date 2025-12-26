<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Favorito;

/** @var yii\web\View $this */
/** @var common\models\Destino $model */

$this->title = $model->nome_cidade; // Sugestão: Use o nome da cidade em vez do ID para o título
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// --- LÓGICA DE FAVORITOS ---
// Verifica se o utilizador está logado e se este destino já consta na tabela 'favorito'
$isFavorito = !Yii::$app->user->isGuest && Favorito::find()
        ->where(['user_id' => Yii::$app->user->id, 'destino_id' => $model->id])
        ->exists();
?>
<div class="destino-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer apagar este item?',
                'method' => 'post',
            ],
        ]) ?>

        <!-- BOTÃO DE FAVORITOS (ADICIONADO) -->
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a(
                $isFavorito ? '<i class="fas fa-heart"></i> Remover dos Favoritos' : '<i class="far fa-heart"></i> Adicionar aos Favoritos',
                ['favorito/toggle', 'destino_id' => $model->id],
                [
                    // Se for favorito, botão vermelho sólido. Se não, outline vermelho.
                    'class' => $isFavorito ? 'btn btn-danger ml-2' : 'btn btn-outline-danger ml-2',
                    'data-method' => 'post', // POST é importante para ações que alteram dados
                    'style' => 'margin-left: 10px;', // Margem extra para garantir separação
                ]
            ) ?>
        <?php else: ?>
            <!-- Botão alternativo para quem não está logado -->
            <?= Html::a('<i class="far fa-heart"></i> Login para Favoritar', ['site/login'], [
                'class' => 'btn btn-outline-secondary ml-2',
                'style' => 'margin-left: 10px;'
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nome_cidade',
            'pais',
            'data_chegada:date',
        ],
    ]) ?>

</div>