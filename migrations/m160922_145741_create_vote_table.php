<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `vote`.
     */
    class m160922_145741_create_vote_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%vote}}', [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()
                                  ->notNull(),
                'vote' => $this->integer()
                               ->notNull(),
                'candidate_id' => $this->integer()
                                       ->notNull()
            ]);
            $this->addForeignKey('FK_user_vote', '{{%vote}}', 'user_id', '{{%user}}', 'id');
            $this->addForeignKey('FK_candidate_vote', '{{%vote}}', 'candidate_id', '{{%user}}', 'id');
            $this->createIndex('IX_user_candidate', '{{%vote}}', [
                'user_id',
                'candidate_id'
            ], true);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%vote}}');
        }
    }
