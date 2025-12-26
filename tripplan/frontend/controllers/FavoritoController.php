<?php

namespace frontend\controllers;

use common\models\Destino;
use common\models\Favorito;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FavoritoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Favorito::find()->where(['user_id' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionToggle($destino_id)
    {
        $userId = Yii::$app->user->id;

        $destino = Destino::findOne($destino_id);
        if (!$destino) {
            throw new NotFoundHttpException('Destino não encontrado');
        }

        // Procura se já existe (usando user_id)
        $favorito = Favorito::findOne(['user_id' => $userId, 'destino_id' => $destino_id]);

        if ($favorito) {
            // Se existe, remove
            $favorito->delete();
            Yii::$app->session->setFlash('success', 'Removido dos Favoritos');
        } else {
            // Se não existe, cria
            $novoFavorito = new Favorito();
            $novoFavorito->user_id = $userId;
            $novoFavorito->destino_id = $destino_id;

            // Tenta guardar
            if ($novoFavorito->save()) {
                Yii::$app->session->setFlash('success', 'Adicionado aos Favoritos');
            } else {
                // SE FALHAR, MOSTRA O ERRO NO ECRÃ
                // Isto é crucial para descobrir o problema ("nothing happens")
                $erros = implode(', ', array_map(function($e) { return implode(', ', $e); }, $novoFavorito->getErrors()));
                Yii::$app->session->setFlash('error', 'Erro ao gravar: ' . $erros);
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
}