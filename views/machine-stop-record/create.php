<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MachineStopRecord $model
*/

$this->title = Yii::t('models', 'Machine Stop Record (Add Data)');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Machine Stop Records (Add Data)'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud machine-stop-record-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
