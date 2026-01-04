<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PlanoViagem $model */

$this->title = $model->nome_viagem;
$this->params['breadcrumbs'][] = ['label' => 'Planos de Viagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// 1. CÁLCULO DE DATAS
$inicio = new DateTime($model->data_inicio);
$fim = new DateTime($model->data_fim);
$diferenca = $inicio->diff($fim);
$dias = $diferenca->days + 1;

// 2. LÓGICA DE ATIVIDADES (SEM VARIÁVEIS AUXILIARES)
$todasAtividades = [];
if (!empty($model->destinos)) {
    foreach ($model->destinos as $destino) {
        if (!empty($destino->atividades)) {
            foreach ($destino->atividades as $atividade) {
                $todasAtividades[] = $atividade;
            }
        }
    }
}

// 3. LÓGICA DE ESTADIAS (CORRIGIDA - SEM VARIÁVEL AUXILIAR)
$todasEstadias = [];
if (!empty($model->destinos)) {
    foreach ($model->destinos as $destino) {
        if (!empty($destino->estadias)) {
            foreach ($destino->estadias as $estadia) {
                // REMOVIDA A LINHA QUE DAVA ERRO ($estadia->cidade_aux = ...)
                // Guardamos apenas a estadia limpa
                $todasEstadias[] = $estadia;
            }
        }
    }
}
?>

<div class="plano-viagem-view">

    <div class="card shadow-sm mb-5 border-0">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-6 fw-bold text-primary mb-0">
                        <i class="fas me-2"></i><?= Html::encode($this->title) ?>
                    </h1>
                    <p class="text-muted mt-2 mb-0">
                        <i class="far fa-calendar-alt"></i>
                        <?= date('d/m/Y', strtotime($model->data_inicio)) ?> até <?= date('d/m/Y', strtotime($model->data_fim)) ?>
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="badge bg-info text-dark p-3 rounded-pill fs-6 shadow-sm">
                        <i class="fas fa-clock"></i> Duração: <?= $dias ?> dias
                    </div>
                    <div class="mt-3">
                        <?= Html::a('Editar Viagem', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'data' => ['confirm' => 'Tens a certeza?', 'method' => 'post'],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold border-start border-4 border-primary ps-3">Destinos</h3>
        <?= Html::a('<i class="fas fa-plus"></i> Adicionar Destino',
            ['destino/create', 'plano_viagem_id' => $model->id],
            ['class' => 'btn btn-success shadow-sm rounded-pill px-4']
        ) ?>
    </div>

    <div class="row mb-5">
        <?php if (empty($model->destinos)): ?>
            <div class="col-12">
                <div class="alert alert-light border text-center p-4">
                    <p>Adiciona as cidades que vais visitar.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($model->destinos as $destino): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body">
                            <h4 class="card-title fw-bold"><?= Html::encode($destino->nome_cidade) ?></h4>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <i class="fas fa-globe-europe"></i> <?= Html::encode($destino->pais) ?>
                            </h6>
                            <p class="card-text text-secondary">
                                <small>Chegada: <?= date('d/m/Y', strtotime($destino->data_chegada)) ?></small>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex gap-1 pb-3 flex-wrap">
                            <?= Html::a('Estadia', ['estadia/create', 'destino_id' => $destino->id], ['class' => 'btn btn-info btn-sm text-white fw-bold', 'title' => 'Adicionar Estadia']) ?>
                            <?= Html::a('Ativ.', ['atividade/create', 'destino_id' => $destino->id], ['class' => 'btn btn-warning btn-sm text-dark fw-bold', 'title' => 'Adicionar Atividade']) ?>
                            <?= Html::a('<i class="fas fa-eye"></i>', ['destino/view', 'id' => $destino->id], ['class' => 'btn btn-primary btn-sm flex-grow-1', 'title' => 'Ver Detalhes']) ?>
                            <?= Html::a('<i class="fas fa-edit"></i>', ['destino/update', 'id' => $destino->id], ['class' => 'btn btn-light btn-sm', 'title' => 'Editar']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i>', ['destino/delete', 'id' => $destino->id], ['class' => 'btn btn-light text-danger btn-sm', 'data' => ['confirm' => 'Apagar?', 'method' => 'post']]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h3 class="fw-bold border-start border-4 border-info ps-3">Estadias</h3>
        <small class="text-muted">Gere as estadias dentro de cada Destino</small>
    </div>

    <div class="row mb-5">
        <?php if (empty($todasEstadias)): ?>
            <div class="col-12">
                <div class="alert alert-light border text-center p-4">
                    <p class="text-muted mb-0">Ainda não tens estadias marcadas.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($todasEstadias as $estadia): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-info">
                                <?= Html::encode($estadia->nome_alojamento) ?>
                            </h5>

                            <p class="card-text text-dark mb-1">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                <?= Html::encode($estadia->destino ? $estadia->destino->nome_cidade : 'Sem destino') ?>
                            </p>

                            <p class="card-text text-muted small">
                                <i class="fas fa-calendar-check text-success"></i>
                                Check-in: <?= date('d/m/Y', strtotime($estadia->data_checkin)) ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex gap-2 pb-3">
                            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['estadia/update', 'id' => $estadia->id], ['class' => 'btn btn-light btn-sm flex-grow-1']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h3 class="fw-bold border-start border-4 border-success ps-3">Transportes</h3>
        <?= Html::a('<i class="fas fa-plus"></i> Adicionar Transporte', ['transporte/create', 'plano_viagem_id' => $model->id], ['class' => 'btn btn-success shadow-sm rounded-pill px-4']) ?>
    </div>

    <div class="row mb-5">
        <?php if (empty($model->transportes)): ?>
            <div class="col-12">
                <div class="alert alert-light border text-center p-4">
                    <p class="text-muted mb-0">Adiciona os teus voos, comboios ou autocarros.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($model->transportes as $transporte): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success">
                                <i class="fas fa-route me-2"></i><?= Html::encode($transporte->tipo) ?>
                            </h5>
                            <div class="mt-3 mb-2">
                                <div class="d-flex justify-content-between align-items-center text-dark">
                                    <span class="fw-bold"><?= Html::encode($transporte->origem) ?></span>
                                    <i class="fas fa-long-arrow-alt-right text-muted mx-2"></i>
                                    <span class="fw-bold"><?= Html::encode($transporte->destino) ?></span>
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                <i class="fas fa-calendar-check text-success"></i>
                                <?= date('d/m/Y', strtotime($transporte->data_partida)) ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex gap-2 pb-3">
                            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['transporte/update', 'id' => $transporte->id], ['class' => 'btn btn-light btn-sm flex-grow-1']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i>', ['transporte/delete', 'id' => $transporte->id], ['class' => 'btn btn-light text-danger btn-sm', 'data' => ['confirm' => 'Apagar transporte?', 'method' => 'post']]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h3 class="fw-bold border-start border-4 border-warning ps-3">Fotos e Memórias</h3>
        <?= Html::a('<i class="fas fa-camera"></i> Adicionar Foto', ['fotos-memorias/create', 'plano_id' => $model->id], ['class' => 'btn btn-warning text-dark shadow-sm rounded-pill px-4']) ?>
    </div>

    <div class="row mb-5">
        <?php if (empty($model->fotosMemorias)): ?>
            <div class="col-12">
                <div class="alert alert-light border text-center p-4">
                    <p class="text-muted mb-0">Guarda aqui as melhores recordações desta viagem.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($model->fotosMemorias as $foto): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="bg-light text-center overflow-hidden position-relative">
                            <?php if (!empty($foto->foto)): ?>
                                <img src="<?= Yii::getAlias('@web/uploads/') . $foto->foto ?>" alt="Foto" class="w-100">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-secondary fst-italic">"<?= Html::encode($foto->comentario) ?>"</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex gap-2 pb-3">
                            <?= Html::a('<i class="fas fa-edit"></i> Editar', ['fotos-memorias/update', 'id' => $foto->id], ['class' => 'btn btn-light btn-sm flex-grow-1']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i>', ['fotos-memorias/delete', 'id' => $foto->id], ['class' => 'btn btn-light text-danger btn-sm', 'data' => ['confirm' => 'Apagar?', 'method' => 'post']]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>