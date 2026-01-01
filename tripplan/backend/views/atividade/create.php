<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Atividade $model */

$this->title = 'Adicionar Atividade';
$this->params['breadcrumbs'][] = ['label' => 'Atividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atividade-create">

    <!-- Card Container -->
    <div class="card shadow-sm border-0">

        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="card-title m-0 text-info font-weight-bold">
                <i class="fas fa-plus-circle mr-2"></i> <?= Html::encode($this->title) ?>
            </h4>
            <!-- Botão de Voltar para a lista -->
            <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['index'], ['class' => 'btn btn-secondary btn-sm shadow-sm']) ?>
        </div>

        <!-- Corpo do Card -->
        <div class="card-body">
            <!-- Renderiza o formulário existente (_form.php) -->
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>