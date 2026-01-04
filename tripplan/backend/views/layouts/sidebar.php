<?php

use yii\helpers\Url;

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['/site/index']) ?>" class="brand-link">
        <img src="<?=$assetDir?>/img/tripplan.png" alt="TripPlan Logo" class="brand-image img-circle elevation-3" style="background-color: white;">
        <span class="brand-text font-weight-light">TripPlan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?= Yii::$app->user->identity->username ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    // Secção de Administração
                    ['label' => 'Gerir Utilizadores', 'icon' => 'users', 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('admin')],

                    // Secção Principal (Viagens)
                    ['label' => 'Gestão de Viagens', 'header' => true],
                    ['label' => 'Planos de Viagem', 'icon' => 'map-marked-alt', 'url' => ['/plano-viagem/index']],
                    ['label' => 'Destinos da Viagem', 'icon' => 'map-marker-alt', 'url' => ['/plano-destino/index']],

                    // Login (Só aparece se não estiver logado, o que no backend é raro, mas fica o código)
                    ['label' => 'Entrar', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],

                    // Secção de Recursos (Tabelas de Apoio)
                    ['label' => 'Recursos de Planeamento', 'header' => true],
                    ['label' => 'Destinos (Catálogo)', 'icon' => 'globe', 'url' => ['/destino/index']],
                    ['label' => 'Estadias / Alojamento', 'icon' => 'hotel', 'url' => ['/estadia/index']], // Mudei icon 'home' para 'hotel'
                    ['label' => 'Atividades', 'icon' => 'hiking', 'url' => ['/atividade/index']], // Mudei icon 'list' para 'hiking' (caminhada/atividade)
                    //['label' => 'Despesas', 'icon' => 'money-bill', 'url' => ['/despesa/index']],
                    ['label' => 'Transportes', 'icon' => 'bus', 'url' => ['/transporte/index']]
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>