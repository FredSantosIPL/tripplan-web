<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\FotosMemorias $model */

$this->title = 'Foto #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fotos e Memórias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fotos-memorias-view">

    <!-- Cabeçalho com Botões de Ação -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0 text-warning"><i class="fas fa-camera-retro mr-2"></i> Visualizar Memória</h1>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['index'], ['class' => 'btn btn-secondary mr-2']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mr-2']) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que deseja apagar esta foto?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <!-- COLUNA ESQUERDA: A FOTO -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center bg-light d-flex align-items-center justify-content-center" style="min-height: 300px;">
                    <?php
                    // CORREÇÃO: Gerar o URL do frontend de forma absoluta para evitar erros de rota
                    // Troca '/backend/web' por '/frontend/web' no URL base atual
                    $baseUrl = Url::base(true); // Ex: http://localhost/tripplan/backend/web
                    $frontendUrl = str_replace('/backend/web', '/frontend/web', $baseUrl);

                    // Caminho físico para verificar se o ficheiro existe no disco
                    $caminhoFisico = Yii::getAlias('@frontend/web/') . $model->foto;

                    if ($model->foto && file_exists($caminhoFisico)) {
                        echo Html::img($frontendUrl . '/' . $model->foto, [
                            'class' => 'img-fluid rounded shadow-sm',
                            'style' => 'max-height: 400px; width: auto;',
                            'alt' => 'Memória da viagem'
                        ]);
                    } else {
                        // Placeholder se não houver imagem ou ficheiro não encontrado
                        echo '<div class="text-muted">
                                <i class="fas fa-image fa-3x mb-3 text-secondary"></i><br>
                                Imagem indisponível ou não encontrada.<br>
                                <small class="text-danger">' . ($model->foto ? 'Caminho: ' . $model->foto : 'Sem foto na BD') . '</small>
                              </div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- COLUNA DIREITA: DETALHES -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-top-warning h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title m-0 font-weight-bold text-dark">Detalhes</h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-bordered detail-view mb-0'],
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'width: 80px; text-align: center;'],
                            ],

                            // Autor da foto
                            [
                                'attribute' => 'user_id',
                                'label' => 'Autor',
                                'value' => isset($model->user) ? $model->user->username : 'ID: ' . $model->user_id,
                            ],

                            // Plano de Viagem com Link
                            [
                                'label' => 'Plano de Viagem',
                                'format' => 'raw',
                                'value' => isset($model->planoViagem) ?
                                    Html::a('<i class="fas fa-map-marked-alt mr-1"></i> ' . Html::encode($model->planoViagem->nome_viagem), ['/plano-viagem/view', 'id' => $model->plano_viagem_id]) :
                                    'ID: ' . $model->plano_viagem_id,
                            ],

                            // Comentário/Descrição
                            [
                                'attribute' => 'comentario',
                                'format' => 'ntext',
                                'label' => 'Comentário',
                                'contentOptions' => ['class' => 'text-dark font-italic'],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>