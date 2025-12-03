<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var common\models\LoginForm $model */

// 1. Início do Formulário
$form = ActiveForm::begin([
    'id' => 'login-form-modal',
    'enableAjaxValidation' => false, // Desligamos isto para controlar nós o AJAX
    'enableClientValidation' => true,
    'options' => ['class' => 'form-horizontal'],
]); ?>

<?= $form->errorSummary($model, ['class' => 'alert alert-danger', 'header' ]) ?>

    <div class="form-group mb-3">
        <label>Nome de Utilizador</label>
        <?= $form->field($model, 'username')->textInput(['class' => 'form-control', 'autofocus' => true])->label(false) ?>
    </div>

    <div class="form-group mb-3">
        <label>Senha</label>
        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control'])->label(false) ?>
    </div>

    <div class="form-group mb-3">
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block w-100', 'name' => 'login-button']) ?>
    </div>

<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function() {

        $('#login-form-modal').on('beforeSubmit', function(e) {
            var $form = $(this);


        $.post(
            $form.attr("action"),
            $form.serialize()
        )
        .done(function(result) {
            if(result == "success") {
                // Se correu bem, recarrega a página
                $('#login-modal').modal('hide');
                location.reload();
            } else {
                // Se a pass estiver errada, o Controller devolveu o formulário com erro.
                // Nós metemos esse formulário novo dentro do modal.
                $('.modal-body').html(result);
            }
        })
        .fail(function() {
            console.log("Erro no servidor");
        });

        return false; // Impede a mudança de página

        });
</script>