<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = Yii::t('models', 'Update Data (Quota)');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Cuti Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->CUTI_ID, 'url' => ['view', 'CUTI_ID' => $model->CUTI_ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud cuti-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
