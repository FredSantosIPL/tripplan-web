<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use Yii; // Importante para aceder ao authManager

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            // 'auth_key', // Comentei isto, geralmente não se deve mostrar keys de segurança
            // 'password_hash', // Também não deves mostrar a hash da password
            'email:email', // Descomentei o email, é útil veres

            // Coluna Status personalizada (Opcional, para veres texto em vez de números)
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 10 ? 'Ativo' : 'Inativo';
                }
            ],

            [
                'class' => ActionColumn::className(),
                // 1. Adicionamos o {promote} ao template
                'template' => '{view} {update} {delete} {promote}',

                // 2. O teu urlCreator original mantém-se para as ações padrão
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },

                // 3. Configuração dos botões personalizados
                'buttons' => [
                    'promote' => function ($url, $model, $key) {
                        // Obter o AuthManager
                        $auth = Yii::$app->authManager;

                        // Verificar se já é Agente OU Admin
                        $isAgent = $auth->getAssignment('agente', $model->id);
                        $isAdmin = $auth->getAssignment('admin', $model->id);

                        // Se já tiver cargo elevado, não mostra o botão
                        if ($isAgent || $isAdmin) {
                            return '';
                        }

                        // Se for Cliente normal, mostra o botão de promover
                        // Nota: Usei 'fa-briefcase' (mala), mas podes usar 'fa-user-plus'
                        return Html::a('<span class="fas fa-briefcase"></span>', ['promote', 'id' => $model->id], [
                            'title' => 'Promover a Agente',
                            'aria-label' => 'Promover a Agente',
                            'class' => 'btn btn-sm btn-primary', // Estilo botão azul pequeno
                            'style' => 'margin-left: 5px;', // Espaçamento
                            'data' => [
                                'confirm' => 'Tens a certeza que queres promover este utilizador a Agente?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>