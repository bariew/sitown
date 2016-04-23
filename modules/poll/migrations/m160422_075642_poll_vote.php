<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;
use app\modules\poll\models\Answer;
use app\modules\user\models\User;
use app\modules\poll\models\Vote;

class m160422_075642_poll_vote extends Migration
{
    public function up()
    {
        $table = Vote::tableName();
        $this->createTable($table, [
            'answer_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
        MigrationHelper::addForeignKey($table, 'answer_id', Answer::tableName(), 'id', 'CASCADE', 'CASCADE');
        MigrationHelper::addForeignKey($table, 'user_id', User::tableName(), 'id');
        $this->addPrimaryKey('id', $table, ['answer_id', 'user_id']);
    }

    public function down()
    {
        $this->dropTable(Vote::tableName());
    }
}
