<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;
use app\modules\poll\models\Question;
use app\modules\poll\models\Answer;

class m160422_075633_poll_answer extends Migration
{
    public function up()
    {
        $table = Answer::tableName();
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(),
            'title' => $this->string(),
        ]);
        MigrationHelper::addForeignKey($table, 'question_id', Question::tableName(), 'id');
    }

    public function down()
    {
        $this->dropTable(Answer::tableName());
    }
}
