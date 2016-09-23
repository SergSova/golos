<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `user`.
     */
    class m160922_133341_create_user_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%user}}', [
                'id' => $this->primaryKey(10),
                'username' => $this->string(50)
                                   ->notNull()
                                   ->comment('Логин'),
                'password' => $this->string(255)
                                   ->comment('Пароль'),
                'auth_key' => $this->string(255),
                'password_reset_token' => $this->text(),
                'email' => $this->string(50),
                'access_token' => $this->string(255),
                'f_name' => $this->string(50)
                                 ->comment('Фамилия'),
                'l_name' => $this->string(50)
                                 ->comment('Имя'),
                'photo' => $this->string(255)
                                ->comment('Фото'),
                'role' => "Enum('user','admin') default 'user'",
                'candidate' => $this->boolean()
                                    ->defaultValue(false)
            ]);
            $this->createIndex('IX_user_email', '{{%user}}', 'email', true);
            $this->createIndex('IX_user_username', '{{%user}}', 'username', true);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%user}}');
        }
    }
