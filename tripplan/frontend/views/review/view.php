<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Review $model */
/** @var common\models\Destino $destino */

$this->title = 'Avaliar: ' . $destino->nome_cidade;
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['/destino/index']];
$this->params['breadcrumbs'][] = ['label' => $destino->nome_cidade, 'url' => ['/destino/view', 'id' => $destino->id]];
$this->params['breadcrumbs'][] = 'Escrever Avaliação';
?>

<div class="review-create container py-4">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="m-0"><i class="fas fa-star mr-2"></i> Partilha a tua experiência</h4>
                </div>

                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        O que achaste da tua visita a <strong><?= Html::encode($destino->nome_cidade) ?></strong>?
                        A tua opinião ajuda outros viajantes!
                    </p>

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-4">
                            <!-- Dropdown de Estrelas -->
                            <?= $form->field($model, 'rating')->dropDownList([
                                5 => '⭐⭐⭐⭐⭐ - Excelente',
                                4 => '⭐⭐⭐⭐ - Muito Bom',
                                3 => '⭐⭐⭐ - Bom',
                                2 => '⭐⭐ - Razoável',
                                1 => '⭐ - Mau'
                            ], [
                                'prompt' => 'Seleciona uma nota...',
                                'class' => 'form-control shadow-sm',
                                'style' => 'height: 50px;'
                            ])->label('Classificação') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'comentario')->textarea([
                                'rows' => 5,
                                'placeholder' => 'Conta-nos tudo! O que gostaste mais? O que correu menos bem?',
                                'class' => 'form-control shadow-sm p-3'
                            ])->label('O teu comentário') ?>
                        </div>
                    </div>

                    <div class="form-group mt-4 text-right">
                        <?= Html::a('Cancelar', ['/destino/view', 'id' => $destino->id], ['class' => 'btn btn-outline-secondary mr-2']) ?>
                        <?= Html::submitButton('<i class="fas fa-paper-plane"></i> Publicar Avaliação', ['class' => 'btn btn-success btn-lg shadow-sm px-4']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>