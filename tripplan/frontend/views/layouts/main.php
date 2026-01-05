<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <base href="<?= \yii\helpers\Url::to('@web/', true) ?>">
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?> - TripPlan</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <?php $this->registerCsrfMetaTags() ?>

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/style.css" rel="stylesheet">

        <style>
            /* Pequenos ajustes CSS para a Navbar */
            .navbar-brand img { max-height: 100px; } /* Ajuste de altura do logo */
            .nav-item.nav-link { font-weight: 500; transition: 0.3s; padding: 10px 15px; }

            /* CORRIGIDO: Alterado de Verde (#7AB730) para Azul Primário (#007bff) */
            .nav-item.nav-link:hover, .nav-item.nav-link.active { color: #007bff !important; }

            .footer-links a { text-decoration: none; transition: 0.3s; display: block; }
            .footer-links a:hover { color: #fff !important; padding-left: 5px; }
            .btn-pill { border-radius: 50px; padding-left: 20px; padding-right: 20px; }
        </style>

        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-fluid position-relative p-0" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-lg py-3 py-lg-0 pl-3 pl-lg-5 sticky-top">

                <a href="<?= Url::to(['/site/index']) ?>" class="navbar-brand">

                    <img src="img/logo.png" alt="TripPlan Logo">
                </a>

                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0 align-items-center">

                        <!-- Links Principais com Lógica de 'Active' -->
                        <a href="<?= Url::to(['/site/index']) ?>" class="nav-item nav-link <?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">Home</a>
                        <a href="<?= Url::to(['/plano-viagem/index']) ?>" class="nav-item nav-link <?= Yii::$app->controller->id == 'plano-viagem' ? 'active' : '' ?>">Viagens</a>
                        <a href="<?= Url::to(['/destino/index']) ?>" class="nav-item nav-link <?= Yii::$app->controller->id == 'destino' ? 'active' : '' ?>">Destinos</a>
                        <a href="<?= Url::to(['/estadia/index']) ?>" class="nav-item nav-link <?= Yii::$app->controller->id == 'estadia' ? 'active' : '' ?>">Estadias</a>
                        <a href="<?= Url::to(['/atividade/index']) ?>" class="nav-item nav-link <?= Yii::$app->controller->id == 'atividade' ? 'active' : '' ?>">Atividades</a>
                        <a href="<?= Url::to(['/transporte/index']) ?>" class="nav-item nav-link <?= Yii::$app->controller->id == 'transporte' ? 'active' : '' ?>">Transportes</a>
                        <a href="<?= Url::to(['/favorito/index']) ?>" class="nav-item nav-link">Favoritos</a>

                        <!-- Área de Utilizador -->
                        <?php if (Yii::$app->user->isGuest): ?>
                            <div class="ml-3 d-flex">
                                <a href="<?= Url::to(['/site/login']) ?>" class="btn btn-outline-primary btn-pill mr-2">Login</a>
                                <a href="<?= Url::to(['/site/signup']) ?>" class="btn btn-primary btn-pill text-white">Registar</a>
                            </div>
                        <?php else: ?>
                            <div class="nav-item dropdown ml-3">
                                <a href="#" class="nav-link dropdown-toggle user-action text-dark font-weight-bold" data-toggle="dropdown">
                                    <i class="fa fa-user-circle mr-1 text-primary"></i> <?= Html::encode(Yii::$app->user->identity->username) ?>
                                </a>
                                <div class="dropdown-menu border-0 m-0 shadow-sm rounded">
                                    <div class="dropdown-divider"></div>
                                    <?php
                                    echo Html::beginForm(['/site/logout'], 'post', ['class' => 'm-0'])
                                        . Html::submitButton(
                                            '<i class="fa fa-sign-out-alt mr-2"></i> Sair',
                                            ['class' => 'dropdown-item btn btn-link w-100 text-left text-danger']
                                        )
                                        . Html::endForm();
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Content Injection -->
    <?= $content ?>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-4 col-md-6 mb-5">
                <a href="" class="navbar-brand">
                    <h1 class="text-primary"><span class="text-white">Trip</span>Plan</h1>
                </a>
                <p>Organiza as tuas viagens de forma mais eficiente com a TripPlan. A nossa plataforma intuitiva permite planear destinos, estadias, transportes e atividades, tudo num só sistema integrado.</p>

            </div>
            <div class="col-lg-4 col-md-6 mb-5 footer-links">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Links Úteis</h5>
                <div class="d-flex flex-column justify-content-start">

                    <a class="text-white-50 mb-2" href="<?= Url::to(['/site/contact']) ?>"><i class="fa fa-angle-right mr-2"></i>Contactos</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-5 footer-links">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Planeamento</h5>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white-50 mb-2" href="<?= Url::to(['/plano-viagem/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Minhas Viagens</a>
                    <a class="text-white-50 mb-2" href="<?= Url::to(['/estadia/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Estadias</a>
                    <a class="text-white-50 mb-2" href="<?= Url::to(['/atividade/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Atividades</a>
                    <a class="text-white-50 mb-2" href="<?= Url::to(['/transporte/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Transportes</a>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="container-fluid bg-dark text-white- border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">-->
<!--                <p class="m-0 text-white-50">Copyright &copy; --><?php //= date('Y') ?><!-- <a href="#">TripPlan</a>. Todos os direitos reservados.-->
<!--                </p>-->
<!--            </div>-->
<!--<!--            <div class="col-lg-6 text-center text-md-right">-->-->
<!--<!--                <p class="m-0 text-white-50">Designed for <a href="https://www.ipleiria.pt">IPL Project</a></p>-->-->
<!--<!--            </div>-->-->
<!--        </div>-->
<!--    </div>-->
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <?php $this->endBody() ?>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    </body>
    </html>
<?php $this->endPage() ?>