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

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
