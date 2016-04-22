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
        $searchModel = new PullRequest();
        $searchModel->load(\Yii::$app->request->get());
        $dataProvider = $searchModel->search([
            'page' => @$_GET['page'] ?:1,
            'per_page' => @$_GET['per_page'] ?:30,
        ]);
        return $this->render('index', compact('dataProvider', 'searchModel'));
    }
}
