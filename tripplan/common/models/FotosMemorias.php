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
 * @property string $foto  <-- IMPORTANTE: Tens de ter esta coluna na BD
 * @property string $comentario
 *
 * @property PlanoViagem $planoViagem
 * @property User $user
 */
class FotosMemorias extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile Variável virtual para receber o ficheiro do formulário
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
            // Removi 'foto' dos required porque é preenchido automaticamente pelo upload()
            [['user_id', 'plano_viagem_id'], 'required'],
            [['user_id', 'plano_viagem_id'], 'integer'],
            [['comentario'], 'string'],
            [['foto'], 'string', 'max' => 255], // Regra para o caminho da foto

            // Regra para validar o ficheiro (apenas imagens)
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],

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
            'comentario' => 'Comentário / Memória',
            'imageFile' => 'Carregar Foto',
        ];
    }

    /**
     * Gets query for [[PlanoViagem]].
     */
    public function getPlanoViagem()
    {
        return $this->hasOne(PlanoViagem::class, ['id' => 'plano_viagem_id']);
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Função para processar o upload
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {
                // 1. Gera nome único
                $nomeFicheiro = 'uploads/' . uniqid() . '.' . $this->imageFile->extension;

                // 2. Define caminho (frontend/web/uploads)
                $caminhoCompleto = Yii::getAlias('@frontend/web/') . $nomeFicheiro;

                // 3. Cria pasta se não existir
                if (!is_dir(dirname($caminhoCompleto))) {
                    mkdir(dirname($caminhoCompleto), 0777, true);
                }

                // 4. Guarda o ficheiro
                $this->imageFile->saveAs($caminhoCompleto);

                // 5. Atualiza a propriedade 'foto' para gravar na BD
                $this->foto = $nomeFicheiro;
            }
            return true;
        } else {
            return false;
        }
    }
}