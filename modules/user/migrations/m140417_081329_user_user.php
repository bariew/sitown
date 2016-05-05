<?php
use app\modules\user\models\User;

class m140417_081329_user_user extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable(User::tableName(), array(
            'id'            => $this->primaryKey(),
            'email'         => $this->string(),
            'password'      => $this->string(),
            'auth_key'      => $this->string(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
            'password_reset_token'=>$this->string(),
        ));

        $this->insert(User::tableName(), array(
            'id'            => 1,
            'email'         => 'admin@admin.admin',
            'password'      => '$2y$13$Rx7MzVUFuYsrKAE4pUksBO2r7fecmboV4MM8WZrSCPDFI3LiHSGOm',
            'created_at'    => time(),
        ));
    }

    public function down()
    {
        $this->dropTable(User::tableName());
    }
}
