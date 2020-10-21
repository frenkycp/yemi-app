<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetDtrTbl $model
*/

$this->title = [
    'page_title' => 'Update Sub Fix Asset <span class="japanesse light-green"></span>',
    'tab_title' => 'Update Sub Fix Asset',
    'breadcrumbs_title' => 'Update Sub Fix Asset'
];
?>
<div class="giiant-crud asset-dtr-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
