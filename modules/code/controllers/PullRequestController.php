<?php

namespace app\modules\code\controllers;

use app\modules\code\models\PullRequest;
use yii\web\Controller;

/**
 * Default controller for the `code` module
 */
class PullRequestController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['dataProvider' => (new PullRequest())->search([
            'page' => @$_GET['page'] ?:1,
            'per_page' => @$_GET['per_page'] ?:30,
            //'q' => 'is:open+is:pr'
        ])]);
    }
}
