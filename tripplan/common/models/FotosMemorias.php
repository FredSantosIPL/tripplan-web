<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "fotos_memorias".
 *
 * @property int $id
 * @property int $user_id
 * @property int $plano_viagem_id
 * @property string $foto
 * @property string $comentario
 *
 * @property PlanoViagem $planoViagem
 * @property User $user
 */
class FotosMemorias extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile Variável virtual para o site (frontend)
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fotos_memorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // --- CORREÇÃO IMPORTANTE AQUI ---
            // 1. Mantivemos apenas 'plano_viagem_id' como OBRIGATÓRIO.
            // 2. Removemos 'user_id' e 'foto' do required para não bloquear a gravação via API.
            [['plano_viagem_id'], 'required', 'message' => 'Falta o ID da viagem.'],

            // Definimos que user_id e plano_viagem_id são números inteiros
            [['user_id', 'plano_viagem_id'], 'integer'],

            // Definimos que foto e comentario são texto
            [['comentario'], 'string'],
            [['foto'], 'string', 'max' => 255], // O Controller da API vai meter aqui o nome do ficheiro (ex: memoria_123.jpg)

            // Regra para o site (upload normal via browser) - skipOnEmpty=true é essencial!
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],

            // Relações (Foreign Keys)
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['plano_viagem_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanoViagem::class, 'targetAttribute' => ['plano_viagem_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Utilizador',
            'plano_viagem_id' => 'Plano de Viagem',
            'foto' => 'Caminho da Foto',
            'comentario' => 'Comentário',
            'imageFile' => 'Carregar Foto',
        ];
    }

    /**
     * Relações
     */
    public function getPlanoViagem()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_viagem_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Upload Web (Não afeta a API, mas mantemos para o site funcionar)
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {
                $nomeFicheiro = 'uploads/' . uniqid() . '.' . $this->imageFile->extension;
                $caminhoCompleto = Yii::getAlias('@frontend/web/') . $nomeFicheiro;

                if (!is_dir(dirname($caminhoCompleto))) {
                    mkdir(dirname($caminhoCompleto), 0777, true);
                }

                $this->imageFile->saveAs($caminhoCompleto);
                $this->foto = $nomeFicheiro;
            }
            return true;
        } else {
            return false;
        }
    }
}