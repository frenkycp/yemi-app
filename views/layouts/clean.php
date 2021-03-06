<?php
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $content string */

app\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);
//\app\assets\AdminLtePluginAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$pluginAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/plugins');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?php 
    $this_title = $this->title;
    if (is_array($this_title)) {
        echo $this_title['tab_title'];
    } else {
        echo Html::encode($this->title);
    }
     
    ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        .content-header {background-color: #61258e !important; padding: 10px; border-radius: 5px;}
        .japanesse {
            font-family: 'MS PGothic', Osaka, Arial, sans-serif;
            font-weight: bold;
        }
        .light-green {
            color: <?= \Yii::$app->params['green_color_j']; ?> !important;
        }
    </style>
</head>
<body class="hold-transition skin-blue layout-top-nav">
<?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'content-hr.php',
            [
                'content' => $content,
                'directoryAsset' => $directoryAsset,
                'pluginAsset' => $pluginAsset,
            ]
        ) ?>
    </div>
    <?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'common-modal',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => true]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
