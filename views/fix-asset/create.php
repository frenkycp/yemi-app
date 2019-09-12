<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
*/

$this->title = Yii::t('models', 'Input New Asset');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Asset Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud asset-tbl-create">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Insert Data</h3>
        </div>
    
    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

    </div>

</div>
