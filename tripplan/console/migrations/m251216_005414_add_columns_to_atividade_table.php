<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%atividade}}`.
 */
class m251216_005414_add_columns_to_atividade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Data e Hora da atividade
        $this->addColumn('atividade', 'data_hora', $this->dateTime()->after('tipo'));

        // 2. Preço (Decimal com 2 casas decimais, padrão 0.00)
        $this->addColumn('atividade', 'preco', $this->decimal(10, 2)->defaultValue(0.00)->after('data_hora'));

        // 3. Observações (Texto longo)
        $this->addColumn('atividade', 'observacoes', $this->text()->after('preco'));


    }

    /**
     * {@inheritdoc}
     */

    public function safeDown()
    {

        $this->dropColumn('atividade', 'observacoes');
        $this->dropColumn('atividade', 'preco');
        $this->dropColumn('atividade', 'data_hora');
    }
}
