<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
*/

$this->title = Yii::t('models', 'Asset Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Asset Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->asset_id, 'url' => ['view', 'asset_id' => $model->asset_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud asset-tbl-update">

    <h1>
        <?= Yii::t('models', 'Asset Tbl') ?>
        <small>
                        <?= Html::encode($model->asset_id) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'asset_id' => $model->asset_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
