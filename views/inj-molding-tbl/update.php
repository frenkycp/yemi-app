<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\InjMoldingTbl $model
*/

$this->title = Yii::t('models', 'Inj Molding Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Inj Molding Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->MOLDING_ID, 'url' => ['view', 'MOLDING_ID' => $model->MOLDING_ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud inj-molding-tbl-update">
    
    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
