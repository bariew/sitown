<?php
use app\modules\user\models\User;

class m140417_081329_user_user extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable(User::tableName(), array(
            'id'            => 'pk',
            'email'         => 'string',
            'password'      => 'string',
            'auth_key'      => 'string',
            'created_at'    => 'integer',
            'updated_at'    => 'integer',
            'password_reset_token'=>'string',
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
