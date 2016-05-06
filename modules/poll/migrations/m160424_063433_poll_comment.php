<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;

class m160424_063433_poll_comment extends Migration
{
    public function up()
    {
        $table = \app\modules\poll\models\Comment::tableName();
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'question_id' => $this->integer(),
            'created_at' => $this->integer(),
            'message' => $this->text(),
        ]);
        MigrationHelper::addForeignKey($table, 'user_id', \app\modules\user\models\User::tableName(), 'id', 'SET NULL', 'CASCADE');
        MigrationHelper::addForeignKey($table, 'question_id', \app\modules\poll\models\Question::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(\app\modules\poll\models\Comment::tableName());
    }
}
