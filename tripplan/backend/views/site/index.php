<?php

use yii\helpers\Html;
use yii\helpers\Url;
// Importar modelos para contagem direta (caso o controller não passe as variáveis)
use common\models\User;
use common\models\PlanoViagem;
use common\models\Destino;
use common\models\Estadia;
use common\models\Atividade;
use common\models\Transporte;

$this->title = 'Painel de Controlo';
$this->params['breadcrumbs'][] = $this->title;

// --- Lógica de Contagem (Fallback) ---
// Se o SiteController passar as variáveis, usa-as. Senão, calcula aqui.
$totalUsers = isset($totalUsers) ? $totalUsers : User::find()->count();
$totalAgents = isset($totalAgents) ? $totalAgents : User::find()->where(['status' => 10])->count(); // Exemplo simplificado
$totalTrips = isset($totalTrips) ? $totalTrips : PlanoViagem::find()->count();

$totalDestinos = Destino::find()->count();
$totalEstadias = Estadia::find()->count();
$totalAtividades = Atividade::find()->count();
$totalTransportes = Transporte::find()->count();
?>
<div class="site-index">

    <div class="jumbotron text-center bg-white shadow-sm pt-4 pb-4">
        <h1 class="display-4">Olá, <?= Html::encode(Yii::$app->user->identity->username) ?>!</h1>
        <p class="lead">Bem-vindo ao painel de gestão do <b>TripPlan</b>.</p>

        <?php if (Yii::$app->user->can('admin')): ?>
            <p class="text-muted"><small>Tens permissões de Administrador.</small></p>
        <?php else: ?>
            <p class="text-muted"><small>Painel de Agente de Viagens.</small></p>
        <?php endif; ?>
    </div>

    <div class="body-content mt-4">

        <!-- LINHA 1: Estatísticas Principais -->
        <div class="row">
            <?php if (Yii::$app->user->can('admin')): ?>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $totalUsers ?></h3>
                            <p>Utilizadores Registados</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="<?= Url::to(['/user/index']) ?>" class="small-box-footer">
                            Gerir Utilizadores <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $totalAgents ?></h3>
                        <p>Agentes de Viagem</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Ver Equipa <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $totalTrips ?></h3>
                        <p>Viagens Planeadas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-marked-alt"></i>
                    </div>
                    <a href="<?= Url::to(['/plano-viagem/index']) ?>" class="small-box-footer">
                        Ver Viagens <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- LINHA 2: Recursos de Gestão -->
        <h5 class="mb-3 mt-4 text-muted"><i class="fas fa-layer-group"></i> Recursos de Planeamento</h5>

        <div class="row">
            <!-- Destinos -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $totalDestinos ?></h3>
                        <p>Destinos</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-globe"></i>
                    </div>
                    <a href="<?= Url::to(['/destino/index']) ?>" class="small-box-footer">
                        Gerir Destinos <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Estadias -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $totalEstadias ?></h3>
                        <p>Estadias</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hotel"></i>
                    </div>
                    <a href="<?= Url::to(['/estadia/index']) ?>" class="small-box-footer">
                        Gerir Estadias <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Atividades -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal"> <!-- bg-teal é uma cor do AdminLTE -->
                    <div class="inner">
                        <h3><?= $totalAtividades ?></h3>
                        <p>Atividades</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hiking"></i>
                    </div>
                    <a href="<?= Url::to(['/atividade/index']) ?>" class="small-box-footer">
                        Gerir Atividades <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Transportes -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-indigo"> <!-- bg-indigo é outra cor do AdminLTE -->
                    <div class="inner">
                        <h3><?= $totalTransportes ?></h3>
                        <p>Transportes</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bus"></i>
                    </div>
                    <a href="<?= Url::to(['/transporte/index']) ?>" class="small-box-footer">
                        Gerir Transportes <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>