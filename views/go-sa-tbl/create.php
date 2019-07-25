<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\GoSaTbl $model
*/

$this->title = Yii::t('models', 'GO Sub Assy Input Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Go Sa Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud go-sa-tbl-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
