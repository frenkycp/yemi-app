<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AuditPatrolTbl $model
*/

$this->title = Yii::t('models', 'Create MIS Patrol');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'MIS Patrols'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud audit-patrol-tbl-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
