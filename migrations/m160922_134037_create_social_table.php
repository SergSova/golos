<?php

use yii\db\Migration;

/**
 * Handles the creation for table `social`.
 */
class m160922_134037_create_social_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%social}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()
                              ->notNull(),
            'social_name' => $this->string()
                                  ->notNull(),
            'social_id' => $this->string()
                                ->notNull()
        ]);

        $this->addForeignKey('FK_user_soc','{{%social}}','user_id','{{%user}}','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%social}}');
    }
}
