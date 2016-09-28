<?php

use yii\db\Migration;

class m160928_131534_ctreate_golos_result_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%golos_result}}',[
            'id'=>$this->primaryKey(),
            'golos_id'=>$this->integer(),
            'result'=>$this->text()
        ]);
        $this->addForeignKey('FK_golos_result','{{%golos_result}}','golos_id','{{%golos}}','id');
    }

    public function down()
    {
        $this->dropTable('{{%golos_result}}');
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
