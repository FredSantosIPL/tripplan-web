<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Adicionei 'shadow-sm' para dar profundidade e removi a borda padrão -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::to(['/site/index']) ?>" class="nav-link font-weight-bold">Dashboard</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <!-- Destaquei o link com cor primária e ícone de link externo -->
            <a href="<?= Url::to('../../../frontend/web') ?>" target="_blank" class="nav-link text-primary" title="Abrir site numa nova aba">
                <i class="fas fa-external-link-alt mr-1"></i> Ver Site
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Fullscreen Button -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Modo Ecrã Inteiro">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="user-image img-circle elevation-1" alt="User Image">
                <span class="d-none d-md-inline font-weight-bold">
                    <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : 'Visitante' ?>
                </span>
            </a>

            <!-- Adicionei shadow e removi borda do dropdown -->
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow border-0">
                <!-- User image -->
                <li class="user-header bg-gradient-primary"> <!-- Gradiente para visual mais moderno -->
                    <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : 'Visitante' ?>
                        <small>
                            <?php
                            if(Yii::$app->user->can('admin')) {
                                echo 'Administrador do Sistema';
                            } elseif (Yii::$app->user->can('agente')) {
                                echo 'Agente de Viagens';
                            } else {
                                echo 'Membro';
                            }
                            ?>
                        </small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer bg-light">
                    <a href="#" class="btn btn-default btn-flat shadow-sm rounded">
                        <i class="fas fa-user-circle mr-1 text-muted"></i> Meu Perfil
                    </a>

                    <?= Html::a('<i class="fas fa-sign-out-alt mr-1"></i> Sair', ['/site/logout'], [
                        'data-method' => 'post',
                        'class' => 'btn btn-default btn-flat float-right shadow-sm rounded text-danger'
                    ]) ?>
                </li>
            </ul>
        </li>
    </ul>
</nav>