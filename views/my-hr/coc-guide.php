<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrComplaintSearch $searchModel
*/

$this->title = [
    'page_title' => 'CoC (Code of Conduct) Guide',
    'tab_title' => 'CoC (Code of Conduct) Guide',
    'breadcrumbs_title' => 'CoC (Code of Conduct) Guide'
];

?>

<div class="row">
	<div class="col-sm-12">
		<ol style="font-size: 1.5em;">
			<li>
				<?= Html::a('Help Line', ['/uploads/CoC/pengumuman_coc.pdf'], ['target' => '_blank']); ?>
			</li>
			<li>
				<?= Html::a('Training CoC', ['/uploads/CoC/alur_pelaporan_coc.pptx'], ['target' => '_blank']); ?>
			</li>
		</ol>
	</div>
</div>