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

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Update Data</h3>
        </div>
        <?php echo $this->render('_form', [
        'model' => $model,
        ]); ?>

    </div>

</div>
