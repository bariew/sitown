<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;
use app\modules\forum\models\Topic;
use app\modules\forum\models\Vote;

class m160422_015004_forum_vote extends Migration
{
    public function up()
    {
        $this->createTable(Vote::tableName(), [
            'user_id' => $this->integer(),
            'topic_id' => $this->integer(),
            'result' => $this->smallInteger(),
        ]);
        MigrationHelper::addForeignKey(Vote::tableName(), 'user_id', \app\modules\user\models\User::tableName(), 'id');
        MigrationHelper::addForeignKey(Vote::tableName(), 'topic_id', Topic::tableName(), 'id');
        $this->addPrimaryKey('id', Vote::tableName(), ['user_id', 'topic_id']);
    }

    public function down()
    {
        $this->dropTable(Vote::tableName());
    }
}
