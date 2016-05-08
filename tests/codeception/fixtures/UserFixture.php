<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 08.05.16
 * Time: 14:45
 */

namespace tests\codeception\fixtures;


use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $dataFile = '@tests/codeception/fixtures/data/user.php';
    public $modelClass = 'app\modules\user\models\User';
}