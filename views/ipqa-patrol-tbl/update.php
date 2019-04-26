<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\IpqaPatrolTbl $model
*/

$this->title = Yii::t('models', 'Ipqa Patrol Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ipqa Patrol Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud ipqa-patrol-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
