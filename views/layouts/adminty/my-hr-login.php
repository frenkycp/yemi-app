<?php
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $content string */
dmstr\web\AdminLteAsset::register($this);
//\app\assets\AdminLtePluginAsset::register($this);
\app\assets\AdmintyPluginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="fix-menu">

<?php $this->beginBody() ?>

    
    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
