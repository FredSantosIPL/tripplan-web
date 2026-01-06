<?php
namespace backend\modules\api\controllers;

use yii\rest\Controller;
use common\models\User;
use Yii;

class AuthController extends Controller
{
    // OBRIGATÓRIO: Desliga a validação CSRF para o Android conseguir entrar
    public $enableCsrfValidation = false;

    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);

        // Se falhar o username, tenta pelo email
        if (!$user) {
            $user = User::findOne(['email' => $username]);
        }

        if ($user && $user->validatePassword($password)) {

            // --- MARTELADA TEMPORÁRIA ---
            // Vamos enviar um texto fixo para garantir que não vem vazio da BD
            $tokenFixo = "TOKEN_DE_TESTE_123456";

            // Se o user não tiver auth_key, geramos e guardamos
            if (empty($user->auth_key)) {
                $user->generateAuthKey();
                $user->save(false);
                $tokenFixo = $user->auth_key; // Se gerou agora, usamos o real
            } elseif (!empty($user->auth_key)) {
                $tokenFixo = $user->auth_key; // Se já tinha, usamos o real
            }
            // ---------------------------

            return [
                'token' => $tokenFixo, // <--- AQUI ESTÁ O SEGREDO
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        }

        Yii::$app->response->statusCode = 401;
        return ['message' => 'Login incorreto!'];
    }
}