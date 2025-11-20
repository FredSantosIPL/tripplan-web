<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::to(['/site/index']) ?>" class="nav-link">Dashboard</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::to('../../frontend/web') ?>" target="_blank" class="nav-link">
                <i class="fas fa-globe"></i> Ver Site
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">
                    <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : 'Visitante' ?>
                </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-primary">
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

                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">Meu Perfil</a>

                    <?= Html::a('Sair', ['/site/logout'], [
                        'data-method' => 'post',
                        'class' => 'btn btn-default btn-flat float-right'
                    ]) ?>
                </li>
            </ul>
        </li>
    </ul>
</nav>