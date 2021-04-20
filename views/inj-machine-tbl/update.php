<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\InjMachineTbl $model
*/

$this->title = Yii::t('models', 'Inj Machine Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Inj Machine Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->MACHINE_ID, 'url' => ['view', 'MACHINE_ID' => $model->MACHINE_ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud inj-machine-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
