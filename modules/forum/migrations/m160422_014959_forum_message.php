<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;
use app\modules\forum\models\Topic;
use app\modules\forum\models\Message;

class m160422_014959_forum_message extends Migration
{
    public function up()
    {
        $this->createTable(Message::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'topic_id' => $this->integer(),
            'content' => $this->text(),
            'created_at' => $this->integer(),
        ]);
        MigrationHelper::addForeignKey(Message::tableName(), 'user_id', \app\modules\user\models\User::tableName(), 'id');
        MigrationHelper::addForeignKey(Message::tableName(), 'topic_id', Topic::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(Message::tableName());
    }
}
