<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MachineStopRecord $model
*/

$this->title = Yii::t('models', 'Machine Stop Record (Update Data)');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Machine Stop Record (Update Data)'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud machine-stop-record-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
