<?php

use yii\db\Migration;

class m160928_114012_create_golos extends Migration
{
    public function up()
    {
        $this->createTable('{{%golos}}',[
            'id'=>$this->primaryKey(),
            'about'=>$this->text()->notNull(),
            'date_start'=>$this->integer()->notNull(),
            'date_end'=>$this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%golos}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
