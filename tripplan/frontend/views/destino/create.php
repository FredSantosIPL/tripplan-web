<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Destino */

$this->title = 'Adicionar Destino';
?>

<div class="destino-create">
    <div class="container">
        <div class="row justify-content-center"> <div class="col-md-8 col-lg-6"> <div class="card shadow-sm mt-5"> <div class="card-header text-white">
                        <h4 class="m-0"> Adicionar Novo Destino</h4>
                    </div>
                    <div class="card-body">
                        <?= $this->render('_form', [
                            'model' => $model,
                            'cidadesDisponiveis' => $cidadesDisponiveis,
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>