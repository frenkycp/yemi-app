<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PcbInsertPoint $model
*/

$this->title = Yii::t('models', 'Pcb Insert Point Update Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Pcb Insert Point'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->part_no, 'url' => ['view', 'part_no' => $model->part_no]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud pcb-insert-point-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
