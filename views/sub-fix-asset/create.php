<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetDtrTbl $model
*/

$this->title = [
    'page_title' => 'Create Sub Fix Asset <span class="japanesse light-green"></span>',
    'tab_title' => 'Create Sub Fix Asset',
    'breadcrumbs_title' => 'Create Sub Fix Asset'
];
?>
<div class="giiant-crud asset-dtr-tbl-create">

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
