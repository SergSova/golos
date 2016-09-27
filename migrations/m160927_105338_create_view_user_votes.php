<?php

use yii\db\Migration;

class m160927_105338_create_view_user_votes extends Migration
{
    public function up()
    {
        $this->execute(<<<SQL
        CREATE VIEW user_votes as
select {{%user}}.`id` AS `id`, 
{{%user}}.`f_name` AS `f_name`,
{{%user}}.`l_name` AS `l_name`,
{{%user}}.`photo` AS `photo`,
(select sum({{%vote}}.`vote`) from {{%vote}} where ({{%vote}}.`candidate_id` = {{%user}}.`id`)) AS `vote` 
from {{%user}} 
where ({{%user}}.`candidate` = 1)
SQL
        );
    }

    public function down()
    {
        $this->execute(<<<SQL
Drop VIEW user_votes
SQL
);
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
