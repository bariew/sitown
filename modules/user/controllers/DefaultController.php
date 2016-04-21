<?php
/**
 * DefaultController class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\modules\user\controllers;

use app\modules\user\models\LoginForm;
use yii\web\Controller;
use app\modules\user\models\User;
use Yii;
 
/**
 * Default controller for all users.
 * 
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class DefaultController extends Controller
{
    /**
     * Url for redirecting after login
     * @return null
     */
    public function getLoginRedirect()
    {
        return ["/"];
    }

    /**
     * Renders login form.
     * @param string $view
     * @param bool $partial
     * @return string view.
     */
    public function actionLogin($view = 'login', $partial = false)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect($this->getLoginRedirect());
        }
        if (\Yii::$app->request->isAjax || $partial) {
            return $this->renderAjax($view, compact('model'));
        }
        return $this->render($view, compact('model'));
    }

    /**
     * Logs user out and redirects to homepage.
     * @return string view.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        if (!$model = $this->findModel()) {
            Yii::$app->session->setFlash("error", Yii::t('modules/user', "You are not logged in."));
            $this->goHome();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", Yii::t('modules/user', "Changes has been saved."));
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Finds user model.
     * @param boolean $new
     * @return User
     */
    public function findModel($new = false)
    {
        $class = \Yii::$app->user->identityClass;
        return $new === true ? new $class() : Yii::$app->user->identity;
    }
}