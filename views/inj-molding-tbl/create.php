<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\InjMoldingTbl $model
*/

$this->title = Yii::t('models', 'Inj Molding Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Inj Molding Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud inj-molding-tbl-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
