<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WipLimitQty $model
*/

$this->title = Yii::t('models', 'WIP Limit Update Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Wip Limit Qty'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->child_analyst, 'url' => ['view', 'child_analyst' => $model->child_analyst]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud wip-limit-qty-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
