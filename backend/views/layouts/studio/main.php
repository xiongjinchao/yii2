<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\StudioAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

StudioAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <?= $this->render(
        'left.php'
    )?>

    <?= $this->render(
        'content.php',
        ['content' => $content]
    )?>

    <?= $this->render(
        'right.php',
        ['content' => $content]
    )?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
