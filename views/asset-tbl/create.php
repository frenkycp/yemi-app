<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
*/

$this->title = Yii::t('models', 'Asset Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Asset Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud asset-tbl-create">

    <h1>
        <?= Yii::t('models', 'Asset Tbl') ?>
        <small>
                        <?= Html::encode($model->asset_id) ?>
        </small>
    </h1>

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
