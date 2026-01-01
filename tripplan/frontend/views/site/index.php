<?php

/** @var yii\web\View $this */
use yii\helpers\Url;

$this->title = 'TripPlan Home'; // Título da página
$baseUrl = Yii::$app->request->baseUrl;
?>

<div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="<?= $baseUrl ?>/img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-md-3">Viagens e Turismo</h4>
                        <h1 class="display-3 text-white mb-md-4">Vamos Planear uma Viagem</h1>
                        <a href="<?= Url::to(['/plano-viagem/index']) ?>" class="btn btn-primary py-md-3 px-md-5 mt-2">Planear Viagem</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="<?= $baseUrl ?>/img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-md-3">Viagens e Turismo</h4>
                        <h1 class="display-3 text-white mb-md-4">Descobre o Mundo</h1>
                        <a href="<?= Url::to(['/plano-viagem/create']) ?>" class="btn btn-primary py-md-3 px-md-5 mt-2">Começar Agora</a>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-6" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100 shadow rounded" src="<?= $baseUrl ?>/img/about.jpg" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 pt-5 pb-lg-5">
                <div class="about-text bg-white p-4 p-lg-5 my-lg-5 shadow-sm rounded">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Sobre Nós</h6>
                    <h1 class="mb-3">Os Melhores Pacotes de Viagem ao Teu Alcance</h1>
                    <p>Os nossos agentes garantem a criação dos pacotes turísticos mais divertidos e diversificados para todas as tuas necessidades. Viaja sem preocupações e com o máximo conforto.</p>
                    <div class="row mb-4">
                        <div class="col-6">
                            <img class="img-fluid rounded shadow-sm" src="<?= $baseUrl ?>/img/about-1.jpg" alt="">
                        </div>
                        <div class="col-6">
                            <img class="img-fluid rounded shadow-sm" src="<?= $baseUrl ?>/img/about-2.jpg" alt="">
                        </div>
                    </div>
                    <a href="<?= Url::to(['/site/about']) ?>" class="btn btn-primary mt-1">Saber Mais</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pb-5">
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex mb-4 mb-lg-0 card-service p-4 shadow-sm rounded bg-white">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3 rounded-circle" style="height: 100px; width: 100px;">
                        <i class="fa fa-2x fa-money-check-alt text-white"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="">Preços Competitivos</h5>
                        <p class="m-0 text-muted">Garantimos a melhor relação qualidade-preço do mercado.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex mb-4 mb-lg-0 card-service p-4 shadow-sm rounded bg-white">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3 rounded-circle" style="height: 100px; width: 100px;">
                        <i class="fa fa-2x fa-award text-white"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="">Melhores Serviços</h5>
                        <p class="m-0 text-muted">Atendimento personalizado e suporte 24/7 para ti.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex mb-4 mb-lg-0 card-service p-4 shadow-sm rounded bg-white">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3 rounded-circle" style="height: 100px; width: 100px;">
                        <i class="fa fa-2x fa-globe text-white"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="">Cobertura Mundial</h5>
                        <p class="m-0 text-muted">Destinos em todos os continentes à tua espera.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Destinos</h6>
            <h1>Explora os Melhores Destinos</h1>
        </div>
        <div class="row">
            <?php
            // Array simples para gerar os destinos dinamicamente e manter o código limpo
            $destinos = [
                ['img' => 'destination-1.jpg', 'pais' => 'Estados Unidos', 'cidades' => 'Nova Iorque, LA, Miami'],
                ['img' => 'destination-2.jpg', 'pais' => 'Reino Unido', 'cidades' => 'Londres, Manchester, Liverpool'],
                ['img' => 'destination-3.jpg', 'pais' => 'Austrália', 'cidades' => 'Sydney, Melbourne, Perth'],
                ['img' => 'destination-4.jpg', 'pais' => 'Índia', 'cidades' => 'Nova Deli, Mumbai, Goa'],
                ['img' => 'destination-5.jpg', 'pais' => 'África do Sul', 'cidades' => 'Cidade do Cabo, Joanesburgo'],
                ['img' => 'destination-6.jpg', 'pais' => 'Indonésia', 'cidades' => 'Bali, Jacarta, Lombok'],
            ];

            foreach($destinos as $destino): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2 rounded shadow-sm">
                        <img class="img-fluid w-100" src="<?= $baseUrl ?>/img/<?= $destino['img'] ?>" alt="<?= $destino['pais'] ?>">
                        <a class="destination-overlay text-white text-decoration-none" href="#">
                            <h5 class="text-white"><?= $destino['pais'] ?></h5>
                            <span><?= $destino['cidades'] ?></span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Serviços</h6>
            <h1>Serviços de Viagens e Turismo</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-item bg-white text-center mb-2 py-5 px-4 shadow-sm rounded hover-effect">
                    <i class="fa fa-2x fa-route mx-auto mb-4 text-primary"></i>
                    <h5 class="mb-2">Guias de Viagem</h5>
                    <p class="m-0 text-muted">Descobre os segredos locais com os nossos guias experientes.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-item bg-white text-center mb-2 py-5 px-4 shadow-sm rounded hover-effect">
                    <i class="fa fa-2x fa-ticket-alt mx-auto mb-4 text-primary"></i>
                    <h5 class="mb-2">Reserva de Bilhetes</h5>
                    <p class="m-0 text-muted">Voos, comboios e atrações ao melhor preço garantido.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-item bg-white text-center mb-2 py-5 px-4 shadow-sm rounded hover-effect">
                    <i class="fa fa-2x fa-hotel mx-auto mb-4 text-primary"></i>
                    <h5 class="mb-2">Reserva de Hotéis</h5>
                    <p class="m-0 text-muted">Desde hotéis de luxo a hostels acolhedores.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Pequenos ajustes CSS para dar vida à página */
    .destination-item img {
        transition: transform .5s ease;
    }
    .destination-item:hover img {
        transform: scale(1.1); /* Zoom suave na imagem ao passar o rato */
    }
    .hover-effect {
        transition: all 0.3s ease;
    }
    .hover-effect:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-5px); /* O cartão sobe ligeiramente */
    }
    .rounded { border-radius: 10px !important; }
    .shadow-sm { box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important; }
</style>