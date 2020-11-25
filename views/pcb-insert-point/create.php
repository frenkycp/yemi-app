<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PcbInsertPoint $model
*/

$this->title = Yii::t('models', 'PCB Insert Point Add Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Pcb Insert Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud pcb-insert-point-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
