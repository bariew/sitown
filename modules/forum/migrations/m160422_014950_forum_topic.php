<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;
use app\modules\forum\models\Topic;

class m160422_014950_forum_topic extends Migration
{
    public function up()
    {
        $this->createTable(Topic::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
        ]);
        MigrationHelper::addForeignKey(Topic::tableName(), 'user_id', \app\modules\user\models\User::tableName(), 'id');
    }

    public function down()
    {
        $this->dropTable(Topic::tableName());
    }
}
