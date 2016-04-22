<?php

use yii\db\Migration;
use app\modules\poll\models\Question;

class m160422_075623_poll_question extends Migration
{
    public function up()
    {
        $this->createTable(Question::tableName(), [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(),
            'type' => $this->smallInteger(),
            'relation_id' => $this->string(), // e.g. code pull request url + sha
            'title' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable(Question::tableName());
    }
}
