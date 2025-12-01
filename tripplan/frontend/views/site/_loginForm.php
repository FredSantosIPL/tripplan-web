<?php
//use yii\bootstrap5  \Html;
//use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \common\models\LoginForm $model */

$form = ActiveForm::begin([
        'id' => 'login-form-modal',
    'enableClientValidation' => true,
]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nome de Utilizador ou Email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>


    <div class="form-group text-center mt-4">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

<?php ActiveForm::end(); ?>



<?php
// ADICIONE ESTE BLOCO DE SCRIPT NO FINAL DO FICHEIRO
$script = <<< JS
$('form#login-form-modal').on('beforeSubmit', function(e) {
    var \$form = $(this);
    
    // Envia os dados por AJAX para o SiteController
    $.post(
        \$form.attr("action"), // O URL (site/login)
        \$form.serialize()     // Os dados (username, password)
    )
    .done(function(result) {
        if(result == "success") {
            // SE SUCESSO: Recarrega a página para atualizar a Navbar
            $(document).find('#login-modal').modal('hide');
            location.reload();
        } else {
            // SE ERRO: Substitui o conteúdo do modal pelo formulário com erros
            $('.modal-body').html(result);
        }
    })
    .fail(function() {
        console.log("Erro no servidor");
    });

    return false; // Impede o recarregamento normal da página
});
JS;
$this->registerJs($script);
?>
