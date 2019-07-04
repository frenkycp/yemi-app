<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\CrusherTbl $model
*/

$this->title = Yii::t('models', 'Crusher Input Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Crusher Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud crusher-tbl-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
