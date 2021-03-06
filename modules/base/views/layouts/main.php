<?php
use yii\helpers\Html;
use yii\bootstrap\Alert;
use yii\widgets\Breadcrumbs;
use app\web\themes\null\AppAsset;
use yii\bootstrap\NavBar;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
raoul2000\bootswatch\BootswatchAsset::$theme = 'journal';
AppAsset::register($this);
\himiklab\colorbox\Colorbox::widget(['coreStyle' => 4]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo \bariew\pageModule\widgets\MainMenu::widget([
            'options' => ['class' => 'navbar-nav navbar nav'],
        ]);
        echo \yii\bootstrap\Nav::widget([
            'options' => ['class' => 'navbar-nav navbar'],
            'items' => [
                [
                    'label' => Yii::t('app', 'Admin'),
                    'items' => [
                        ['label' => Yii::t('app', 'Pages'), 'url' => ['/page/item/index']],
                        ['label' => Yii::t('app', 'Polls'), 'url' => ['/poll/question/index']],
                        ['label' => Yii::t('app', 'Code'),  'url' => ['/code/pull-request/index']],
                        ['label' => Yii::t('app', 'Users'), 'url' => ['/user/user/index']],
                        ['label' => Yii::t('app', 'My account'), 'url' => ['/user/default/update']],
                    ],
                    'visible' => !Yii::$app->user->isGuest
                ],
                (Yii::$app->user->isGuest
                    ? ['label' => Yii::t('app', 'Login'), 'url' => ['/user/default/login']]
                    : ['label' => Yii::t('app', 'Logout'),'url' => ['/user/default/logout']]
                )
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?php foreach(Yii::$app->session->getAllFlashes() as $key=>$message): ?>
                <?= Alert::widget([
                    'options' => ['class' => 'alert-'.($key == 'error' ? 'danger' : $key)],
                    'body' => implode("<hr />", (array) $message),
                ]); ?>
            <?php endforeach; ?>
            <?= $content ?>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
