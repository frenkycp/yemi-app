<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

app\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);
\app\assets\AdminLtePluginAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$pluginAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/plugins');

$sidebar_collapse_arr = [
    'about-me', 'manufacture-flow', 'audit-patrol-monitoring', 'audit-patrol', 'covid-patrol', 'covid-patrol-monitoring', 'mis-patrol', 'mis-patrol-monitoring', 'she-patrol', 'she-patrol-monitoring'
];
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
    <script>
        var baseUrl = "<?= Yii::$app->urlManager->baseUrl ?>";
    </script>
    <?php $this->head() ?>
    <style type="text/css">
        .content-header>.breadcrumb>li>a, .breadcrumb > .active {
            color: silver;
        }
        .japanesse {
            font-family: 'MS PGothic', Osaka, Arial, sans-serif;
            font-weight: bold;
        }
        .light-green {
            color: <?= \Yii::$app->params['green_color_j']; ?> !important;
        }
    </style>
</head>
<body class="hold-transition <?= \dmstr\helpers\AdminLteHelper::skinClass(); ?> sidebar-mini<?= in_array(\Yii::$app->controller->id, $sidebar_collapse_arr) ? ' sidebar-collapse' : ''; ?>">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'header.php',
        [
            'directoryAsset' => $directoryAsset,
            'pluginAsset' => $pluginAsset,
        ]
    ) ?>

    <?= $this->render(
        'left.php',
        [
            'directoryAsset' => $directoryAsset,
            'pluginAsset' => $pluginAsset,
        ]
    )
    ?>

    <?= $this->render(
        'content.php',
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
