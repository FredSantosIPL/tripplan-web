<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-white shadow-sm pt-4 pb-4">
        <h1 class="display-4">Hello, <?= Html::encode(Yii::$app->user->identity->username) ?>!</h1>
        <p class="lead">Welcome to the <b>TripPlan</b> management dashboard.</p>

        <?php if (Yii::$app->user->can('admin')): ?>
            <p class="text-muted"><small>You have Administrator permissions.</small></p>
        <?php else: ?>
            <p class="text-muted"><small>Travel Agent Dashboard.</small></p>
        <?php endif; ?>
    </div>

    <div class="body-content mt-5">
        <div class="row">

            <?php if (Yii::$app->user->can('admin')): ?>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $totalUsers ?></h3>
                            <p>Registered Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="<?= Url::to(['/user/index']) ?>" class="small-box-footer">
                            Manage Users <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $totalAgents ?></h3>
                        <p>Travel Agents</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        View Team <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $totalTrips ?></h3>

                        <p>Planned Trips</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-plane"></i>
                    </div>

                    <a href="<?= Url::to(['/trip/index']) ?>" class="small-box-footer">
                        View Trips <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>