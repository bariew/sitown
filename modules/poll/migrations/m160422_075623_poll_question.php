<?php

use yii\db\Migration;
use app\modules\poll\models\Question;
use \bariew\yii2Tools\helpers\MigrationHelper;
use app\modules\user\models\User;

class m160422_075623_poll_question extends Migration
{
    public function up()
    {
        $this->createTable(Question::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger(),
            'type' => $this->smallInteger(),
            'relation_id' => $this->string(), // e.g. code pull request url + sha
            'event_object' => $this->text(),
            'title' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
        ]);
        MigrationHelper::addForeignKey(Question::tableName(), 'user_id', User::tableName(), 'id');
    }

    public function down()
    {
        $this->dropTable(Question::tableName());
    }
}
