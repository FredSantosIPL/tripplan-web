<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= \yii\helpers\Url::to('@web/', true) ?>">
    <meta charset="utf-8">
    <title>TripPlan - Travel Manager</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
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


    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<!-- Navbar Start -->
<div class="container-fluid position-relative nav-bar p-0">
    <div class="container-fluid position-relative p-0" style="z-index: 9;">
        <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">

            <a href="<?= Url::to(['/site/index']) ?>" class="navbar-brand">
                <img src="img/logo.png" alt="logo" class=" w-25">
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">

                    

                        <a href="<?= Url::to(['/plano-viagem/index']) ?>" class="nav-item nav-link ">Viagem</a>
                    <a href="<?= Url::to(['/destino/index']) ?>" class="nav-item nav-link ">Destino</a>
                        <a href="<?= Url::to(['/estadia/index']) ?>" class="nav-item nav-link ">Estadia</a>
                        <a href="<?= Url::to(['/atividade/index']) ?>" class="nav-item nav-link ">Actividades</a>
                        <a href="<?= Url::to(['/transporte/index']) ?>" class="nav-item nav-link ">Transporte</a>
                    <a href="<?= Url::to(['/favorito/index']) ?>" class="nav-item nav-link ">Favoritos</a>


                    <a href="<?= Url::to(['/site/contact']) ?>" class="nav-item nav-link">Contactos</a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                        </a>
                        <div class="dropdown-menu border-0 m-0">



                    <?php if (Yii::$app->user->isGuest): ?>
                        <a href="<?= Url::to(['/site/signup']) ?>" class="nav-item nav-link">Signup</a>
                        <a href="<?= Url::to(['/site/login']) ?>" class="dropdown-item" data-toggle="modal"
                           data-target="#login-modal">Login</a>
                        <a href="<?= Url::to(['/']) ?>" class="nav-item nav-link">Perfil</a>
                    <?php else: ?>
                        <?php
                        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline m-0'])
                            . Html::submitButton(
                                'Logout',
                                ['class' => 'nav-item nav-link btn btn-link logout p-0']
                            )
                            . Html::endForm();
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->


<!-- Carousel Start -->
<div class="container-fluid p-0 pt-5">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">

            <?= $content ?>

        </div>
    </div>
</div>


<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
    <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
            <a href="" class="navbar-brand">
                <h1 class="text-primary"><span class="text-white">Trip</span>Plan</h1>
            </a>
            <p>Organize as suas viagens de forma mais eficiente com a TripPlan. A nossa plataforma intuitiva
                permite planear destinos, estadias, transportes e atividades , tudo num só sistema integrado.</p>

        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Serviços</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white-50 mb-2" href=""><i class="fa fa-angle-right mr-2"></i>Login</a>
                <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Signup</a>
                <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Contactos</a>
                <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Perfil</a>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Viagem</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white-50 mb-2" href="<?= Url::to(['/plano-viagem/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Planos Viagem</a>
                <a class="text-white-50 mb-2" href="<?= Url::to(['/estadia/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Estadia</a>
                <a class="text-white-50 mb-2" href="<?= Url::to(['/atividade/index']) ?>"><i class="fa fa-angle-right mr-2"></i>Atividades</a>


            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<?php $this->endBody() ?>
<!-- JavaScript Libraries -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>


<!-- janela do login -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Aceder à TripPlan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <p class="small text-center w-100">
                    Não tem conta? <a href="<?= Url::to(['/site/signup']) ?>">Registar aqui</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#login-modal').on('show.bs.modal', function (e) {
            var modal = $(this);
            // Carrega o conteúdo do formulário de login usando AJAX
            modal.find('.modal-body').load('<?= Url::to(['site/login']) ?>', function() {

            });
        });
    });
</script>


</body>

</html>
<?php $this->endPage() ?>