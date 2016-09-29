<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `reklama`.
     */
    class m160929_083800_create_reklama_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%reklama}}', [
                'id'    => $this->primaryKey(),
                'title' => $this->string(50),
                'body'  => $this->text()
            ]);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%reklama}}');
        }
    }
