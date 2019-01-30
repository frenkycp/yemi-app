<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WipEffTbl $model
*/

$this->title = Yii::t('models', 'Production Plan Update Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Production Plan Update Form'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->lot_id, 'url' => ['view', 'lot_id' => $model->lot_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud wip-eff-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
