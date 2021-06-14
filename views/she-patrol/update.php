<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AuditPatrolTbl $model
*/

$this->title = Yii::t('models', 'Update Covid Patrol');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Update Covid Patrol'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud audit-patrol-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
