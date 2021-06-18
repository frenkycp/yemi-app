<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShipLiner $model
*/

$this->title = Yii::t('models', 'Ship Liner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ship Liner'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SEQ, 'url' => ['view', 'SEQ' => $model->SEQ]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud ship-liner-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
