<?php

use common\models\Destino;
use common\models\PlanoViagem;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PlanoDestino $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="plano-destino-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // LÓGICA INTELIGENTE PARA O PLANO DE VIAGEM
    if ($model->plano_id) {
    // Se o ID já existe (veio do Controller), escondemos o campo input
    // IMPORTANTE: Forçamos o 'value' no hiddenInput para garantir que é enviado no POST
    // Caso contrário, em alguns cenários o ActiveForm pode não gerar o value corretamente se o atributo não for 'safe'
    echo $form->field($model, 'plano_id')->hiddenInput(['value' => $model->plano_id])->label(false);

    $plano = PlanoViagem::findOne($model->plano_id);
    if ($plano) {
    echo '<div class="alert alert-info">';
        echo '<strong>A associar à viagem:</strong> ' . Html::encode($plano->nome_viagem);
        echo '</div>';
    }
    } else {
    // Se estamos a criar do zero (sem contexto), mostramos o dropdown para escolher o plano
    $planos = PlanoViagem::find()->all();
    $listaPlanos = ArrayHelper::map($planos, 'id', 'nome_viagem');

    echo $form->field($model, 'plano_id')->dropDownList(
    $listaPlanos,
    ['prompt' => 'Selecione o Plano de Viagem...']
    );
    }
    ?>

    <?php
    // DROPDOWN PARA ESCOLHER O DESTINO (CIDADE)
    // Busca todos os destinos disponíveis na base de dados
    $destinos = Destino::find()->all();
    $listaDestinos = ArrayHelper::map($destinos, 'id', 'nome_cidade');
    ?>

    <?= $form->field($model, 'destino_id')->dropDownList(
        $listaDestinos,
        ['prompt' => 'Selecione o Destino a adicionar...']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Associar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
