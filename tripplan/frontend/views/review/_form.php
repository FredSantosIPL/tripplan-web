<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Review $model */
/** @var common\models\Destino $destino */

// Se a variável $destino não for passada pelo controlador, tentamos obter através do modelo
// Isto previne erros se estiveres a usar o controlador padrão do Gii
$nomeDestino = isset($destino) ? $destino->nome_cidade : ($model->destino ? $model->destino->nome_cidade : 'o Destino');
$idDestino = isset($destino) ? $destino->id : ($model->destino_id ?? null);

$this->title = 'Avaliar: ' . $nomeDestino;
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['/destino/index']];
if ($idDestino) {
    $this->params['breadcrumbs'][] = ['label' => $nomeDestino, 'url' => ['/destino/view', 'id' => $idDestino]];
}
$this->params['breadcrumbs'][] = 'Escrever Avaliação';
?>

<div class="review-create container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card Moderno -->
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">

                <!-- Cabeçalho com Gradiente -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0 font-weight-bold">
                        <i class="fas fa-star text-warning mr-2"></i> Partilha a tua Experiência
                    </h3>
                    <p class="mb-0 mt-2 text-white-50">
                        Como foi a tua viagem a <strong><?= Html::encode($nomeDestino) ?></strong>?
                    </p>
                </div>

                <div class="card-body p-5 bg-light">

                    <?php $form = ActiveForm::begin(); ?>

                    <!-- CAMPOS OCULTOS (IDs) -->
                    <!-- O utilizador não deve editar isto manualmente -->
                    <?= $form->field($model, 'utilizador_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'destino_id')->hiddenInput()->label(false) ?>

                    <!-- Campo de Classificação (Estrelas) -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Classificação Geral</label>
                        <div class="input-group input-group-lg shadow-sm rounded">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-trophy text-warning"></i>
                                </span>
                            </div>
                            <!-- Dropdown de Classificação (1 a 5) -->
                            <?= $form->field($model, 'classificacao', ['options' => ['class' => 'flex-grow-1 m-0']])->dropDownList([
                                5 => '5 Estrelas - Incrível! 🤩',
                                4 => '4 Estrelas - Muito Bom 🙂',
                                3 => '3 Estrelas - Bom 😐',
                                2 => '2 Estrelas - Razoável 😕',
                                1 => '1 Estrela - Mau 😫'
                            ], [
                                'prompt' => 'Seleciona uma nota...',
                                'class' => 'form-control border-left-0 h-100',
                                'style' => 'border-top-left-radius: 0; border-bottom-left-radius: 0;'
                            ])->label(false) ?>
                        </div>
                    </div>

                    <!-- Campo de Comentário -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">O teu Comentário</label>
                        <?= $form->field($model, 'comentario')->textarea([
                            'rows' => 6,
                            'placeholder' => 'Conta-nos tudo! O que gostaste mais? O que correu menos bem? Dicas para outros viajantes...',
                            'class' => 'form-control shadow-sm p-3 border-0',
                            'style' => 'resize: none;'
                        ])->label(false) ?>
                    </div>

                    <hr class="my-4">

                    <!-- Botões de Ação -->
                    <div class="d-flex justify-content-between align-items-center">
                        <?php
                        // Link de cancelar volta para o destino se tivermos ID, senão vai para o index
                        $cancelUrl = $idDestino ? ['/destino/view', 'id' => $idDestino] : ['/destino/index'];
                        ?>
                        <?= Html::a('<i class="fas fa-arrow-left mr-1"></i> Cancelar', $cancelUrl, ['class' => 'btn btn-outline-secondary px-4 py-2 rounded-pill']) ?>

                        <?= Html::submitButton('Publicar Avaliação <i class="fas fa-paper-plane ml-1"></i>', ['class' => 'btn btn-success btn-lg px-5 py-2 rounded-pill shadow-sm']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>

</div>